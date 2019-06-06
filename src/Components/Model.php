<?php

namespace YandexDirectSDK\Components;

use ReflectionClass;
use ReflectionException;
use YandexDirectSDK\Common\SessionTrait;
use YandexDirectSDK\Common\Arr;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\ModelException;
use YandexDirectSDK\Interfaces\Model as ModelInterface;
use YandexDirectSDK\Interfaces\ModelCollection as ModelCollectionInterface;

/**
 * Class Model
 * @package YandexDirectSDK\Components
 */
abstract class Model implements ModelInterface
{
    use SessionTrait;

    const IS_READABLE = 1 << 0;     // 0001
    const IS_WRITABLE = 1 << 1;     // 0010
    const IS_ADDABLE = 1 << 2;      // 0100
    const IS_UPDATABLE = 1 << 3;    // 1000

    /**
     * Model data.
     *
     * @var array
     */
    protected $modelData = [];

    /**
     * Model property.
     *
     * @var array
     */
    protected $properties = [];

    /**
     * Non-writable properties.
     *
     * @var array
     */
    protected $nonWritableProperties = [];

    /**
     * Non-readable properties.
     *
     * @var array
     */
    protected $nonReadableProperties = [];

    /**
     * Non-updateable properties.
     *
     * @var array
     */
    protected $nonUpdatableProperties = [];

    /**
     * Non-addable properties.
     *
     * @var array
     */
    protected $nonAddableProperties = [];

    /**
     * Compatible class of collection.
     *
     * @var ModelCollectionInterface
     */
    protected $compatibleCollection;

    /**
     * Service-providers methods.
     *
     * @var Service[]
     */
    protected $serviceProvidersMethods = [];

    /**
     * Create a new model instance.
     *
     * @param array $properties
     * @return static
     */
    public static function make($properties = null)
    {
        return (new static())->insert($properties);
    }

    /**
     * Returns the short class name.
     *
     * @return string
     * @throws ReflectionException
     */
    public static function getClassName()
    {
        return (new ReflectionClass(static::class))->getShortName();
    }

    /**
     * Create a new model instance.
     */
    public function __construct()
    {
        $this->initialize();

        $properties = [];

        foreach ($this->properties as $name => $propertyMeta){
            $propertyMeta = explode(':', $propertyMeta, 2);
            $propertyType = trim($propertyMeta[0]);
            $propertyTypeMeta = trim($propertyMeta[1] ?? '');
            $propertyUseItemsSubarray = false;

            switch ($propertyType){
                case 'bool': $propertyType = 'boolean'; break;
                case 'float': $propertyType = 'double'; break;
                case 'int': $propertyType = 'integer'; break;
                case 'array':
                    $propertyUseItemsSubarray = true;
                    $propertyTypeMeta = empty($propertyTypeMeta) ? null : explode(',', $propertyTypeMeta);
                    break;
                case 'stack':
                    $propertyType = 'array';
                    $propertyTypeMeta = empty($propertyTypeMeta) ? null : explode(',', $propertyTypeMeta);
                    break;
                case 'enum':
                case 'set':
                    $propertyTypeMeta = empty($propertyTypeMeta) ? [] : explode(',', $propertyTypeMeta);
                    break;
                case 'arrayOfEnum':
                case 'arrayOfSet':
                    $propertyType = 'set';
                    $propertyUseItemsSubarray = true;
                    $propertyTypeMeta = empty($propertyTypeMeta) ? [] : explode(',', $propertyTypeMeta);
                    break;
                case 'object':
                    $propertyTypeMeta = empty($propertyTypeMeta) ? null : $propertyTypeMeta;
                    break;
                case 'arrayOfObject':
                    $propertyType = 'object';
                    $propertyUseItemsSubarray = true;
                    $propertyTypeMeta = empty($propertyTypeMeta) ? null : $propertyTypeMeta;
                    break;
                case 'custom':
                    $propertyTypeMeta = empty($propertyTypeMeta) ? [] : explode(',', $propertyTypeMeta);
                    break;
            }

            $properties[$name] = [
                'name' => $name,
                'type' => strtolower($propertyType),
                'meta' => $propertyTypeMeta,
                'items' => $propertyUseItemsSubarray,
                'readable' => !in_array($name, $this->nonReadableProperties),
                'writable' => !in_array($name, $this->nonWritableProperties)
            ];

            $properties[$name]['addable'] = ($properties[$name]['writable'] and !in_array($name, $this->nonAddableProperties));
            $properties[$name]['updatable'] = ($properties[$name]['writable'] and !in_array($name, $this->nonUpdatableProperties));
        }

        $this->properties = $properties;
    }

    /**
     * Dynamic recording of model property values.
     *
     * @param string $property
     * @param mixed $value
     * @return mixed
     * @throws InvalidArgumentException
     * @throws ModelException
     */
    public function __set($property, $value)
    {
        $this->setPropertyValue($property, $value);
        return $value;
    }

    /**
     * Dynamically getting model property values.
     *
     * @param string $property
     * @return mixed|null
     * @throws ModelException
     */
    public function __get($property)
    {
        return $this->getPropertyValue($property);
    }

    /**
     * Implementing dynamic methods.
     *
     * @param string $method
     * @param mixed[] $arguments
     * @return $this|mixed|null
     * @throws InvalidArgumentException
     * @throws ModelException
     */
    public function __call($method, $arguments)
    {
        if (array_key_exists($method, $this->serviceProvidersMethods)){
            if (!is_null($this->session)){
                return (new $this->serviceProvidersMethods[$method]($this->session))->{$method}($this, ...$arguments);
            }

            throw ModelException::make(static::class.". Failed method [{$method}]. No session to connect.");
        }

        $action = substr($method, 0, 3);
        $property = lcfirst(substr($method, 3));

        if ($action === 'get'){
            return $this->getPropertyValue($property);
        }

        if ($action === 'set'){
            return $this->setPropertyValue($property, ...$arguments);
        }

        throw ModelException::make(static::class.". Method [{$method}] is missing.");
    }

    /**
     * Returns a string representation of the current model.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }

    /**
     * Retrieve a shallow copy of the object.
     *
     * @return static
     */
    public function copy(){
        $model = (new static())->insert($this->toArray());

        if (!is_null($this->session)){
            $model->setSession($this->session);
        }

        return $model;
    }

    /**
     * Retrieve the model hash.
     *
     * @return string
     */
    public function hash()
    {
        return Arr::hash($this->toArray());
    }

    /**
     * Converts the current model to array.
     *
     * @param int $filters
     * @return array
     */
    public function toArray($filters = 0)
    {
        $properties = [];
        foreach ($this->modelData as $name => $value){

            if ($filters & self::IS_READABLE and $this->properties[$name]['readable'] === false){
                continue;
            }

            if ($filters & self::IS_WRITABLE and $this->properties[$name]['writable'] === false){
                continue;
            }

            if ($filters & self::IS_ADDABLE and $this->properties[$name]['addable'] === false){
                continue;
            }

            if ($filters & self::IS_UPDATABLE and $this->properties[$name]['updatable'] === false){
                continue;
            }

            if (is_null($value)){
                $properties[ucfirst($name)] = null;
                continue;
            }

            if ($value instanceof ModelInterface){
                $value = $value->toArray($filters);
                if (empty($value)){
                    $value = (object) $value;
                }
            } elseif ($value instanceof ModelCollectionInterface){
                $value = $value->toArray($filters);
            }

            if ($this->properties[$name]['items']){
                $value = ['Items' => $value];
            }

            $properties[ucfirst($name)] = $value;
        }
        return $properties;
    }

    /**
     * Converts the current model to a Data object.
     *
     * @param int $filters
     * @return Data
     */
    public function toData($filters = 0){
        return new Data($this->toArray());
    }

    /**
     * Converts the current model to JSON.
     *
     * @param int $filters
     * @return string
     */
    public function toJson($filters = 0)
    {
        return Arr::toJson($this->toArray($filters));
    }

    /**
     * Insert properties into the model.
     *
     * @param Data|array $source
     * @return $this
     */
    public function insert($source)
    {
        if (empty($source)){
            return $this;
        }

        if (!is_array($source)){
            if (!($source instanceof Data)){
                return $this;
            }

            $source = $source->all();
        }

        foreach ($source as $name => $value){
            $name = lcfirst($name);

            if (!array_key_exists($name, $this->properties)){
                continue;
            }

            if ($this->properties[$name]['items'] === true){
                $value = $value['Items'] ?? null;
            }

            if (is_null($value)){
                $this->modelData[$name] = $value;
                continue;
            }

            if ($this->properties[$name]['type'] === 'object'){
                $propertyObject = $this->properties[$name]['meta'];
                $propertyObject = new $propertyObject();

                if ($propertyObject instanceof ModelInterface){

                    $propertyObject->insert($value);

                } elseif ($propertyObject instanceof ModelCollectionInterface){

                    if (is_array($value)) {
                        foreach ($value as $item) {
                            $propertyObject->push(
                                $propertyObject
                                    ->getCompatibleModel()
                                    ->insert($item)
                            );
                        }
                    }

                }

                $this->modelData[$name] = $propertyObject;
                continue;
            }

            $this->modelData[$name] = $value;
            continue;
        }

        return $this;
    }

    /**
     * Retrieve instance of compatible collection.
     *
     * @return ModelCollectionInterface|null
     */
    public function getCompatibleCollection()
    {
        return is_null($this->compatibleCollection) ? null : $this->compatibleCollection::make();
    }

    /**
     * Retrieve metadata of model properties.
     *
     * @return array
     */
    public function getPropertiesMeta()
    {
        return $this->properties;
    }

    /**
     * Retrieve metadata of service-providers methods.
     *
     * @return Service[]
     */
    public function getServiceProvidersMethodsMeta()
    {
        return $this->serviceProvidersMethods;
    }

    /**
     * Model initialization handler.
     *
     * @return void
     */
    protected function initialize(){}

    /**
     * Setting a value for a model property.
     *
     * @param string $propertyName
     * @param mixed  $value
     * @return $this
     * @throws ModelException
     * @throws InvalidArgumentException
     */
    public function setPropertyValue($propertyName, $value)
    {
        $propertyMeta = $this->properties[$propertyName] ?? null;

        if (is_null($propertyMeta)){
            throw ModelException::make(static::class.". Property [{$propertyName}] does not exist.");
        }

        if ($propertyMeta['writable'] === false){
            throw ModelException::make(static::class.". Property [{$propertyName}] is not writable.");
        }

        if ($propertyMeta['type'] === 'custom'){
            $this->{'setter'.ucfirst($propertyName)}($value, $propertyName, $propertyMeta);
            return $this;
        }

        if (is_null($value) or $propertyMeta['type'] === 'mixed'){
            $this->modelData[$propertyName] = $value;
            return $this;
        }

        switch ($propertyMeta['type']){
            case 'string':
            case 'boolean':
            case 'double':
            case 'integer':
                if (gettype($value) !== $propertyMeta['type']){
                    throw InvalidArgumentException::invalidType(static::class."::{$propertyName}", 1, $propertyMeta['type'], gettype($value));
                }
                break;

            case 'numeric':
                if (!is_numeric($value)){
                    throw InvalidArgumentException::invalidType(static::class."::{$propertyName}", 1, $propertyMeta['type'], gettype($value));
                }
                break;

            case 'array':
                if (!is_array($value)) {
                    throw InvalidArgumentException::invalidType(static::class."::{$propertyName}", 1, $propertyMeta['type'], gettype($value));
                }

                if (!is_null($propertyMeta['meta'])){
                    foreach ($value as $index => $valueItem){
                        if (!in_array(gettype($valueItem), $propertyMeta['meta'])) {
                            throw InvalidArgumentException::invalidType(
                                static::class."::{$propertyName}",
                                1,
                                'array of ' . implode(', ', $propertyMeta['meta']),
                                $index . ' => ' . gettype($valueItem)
                            );
                        }
                    }
                }
                break;

            case 'enum':
                if (!in_array($value, $propertyMeta['meta'])){
                    throw InvalidArgumentException::invalidType(
                        static::class."::{$propertyName}",
                        1,
                        'enum of ' . implode(', ', $propertyMeta['meta']),
                        $value
                    );
                }
                break;

            case 'set':
                if (!is_array($value)) {
                    throw InvalidArgumentException::invalidType(static::class."::{$propertyName}", 1, 'array', gettype($value));
                }

                foreach ($value as $index => $valueItem){
                    if (!in_array($valueItem,  $propertyMeta['meta'])) {
                        throw InvalidArgumentException::invalidType(
                            static::class."::{$propertyName}",
                            1,
                            'array contain ' . implode(', ', $propertyMeta['meta']),
                            $index . ' => ' . $valueItem
                        );
                    }
                }
                break;

            case 'object':
                if (!is_object($value)) {
                    throw InvalidArgumentException::invalidType(
                        static::class."::{$propertyName}",
                        1,
                        is_null($propertyMeta['meta']) ? 'object' : $propertyMeta['meta'],
                        gettype($value)
                    );
                }

                if (!is_null($propertyMeta['meta']) and !($value instanceof $propertyMeta['meta'])){
                    throw InvalidArgumentException::invalidType(static::class."::{$propertyName}", 1, $propertyMeta['meta'], get_class($value));
                }
                break;
        }

        $this->modelData[$propertyName] = $value;
        return $this;
    }

    /**
     * Getting the value of the model property.
     *
     * @param string $propertyName
     * @return mixed|null
     * @throws ModelException
     */
    public function getPropertyValue($propertyName)
    {
        $propertyMeta = $this->properties[$propertyName] ?? null;

        if (is_null($propertyMeta)){
            throw ModelException::make(static::class.". Property [{$propertyName}] does not exist.");
        }

        if ($propertyMeta['readable'] === false){
            throw ModelException::make(static::class.". Property [{$propertyName}] is not readable.");
        }

        if ($propertyMeta['type'] === 'custom'){
            return $this->{'getter'.ucfirst($propertyName)}($propertyName, $propertyMeta);
        }

        return $this->modelData[$propertyName] ?? null;
    }
}