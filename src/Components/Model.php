<?php

namespace YandexDirectSDK\Components;

use Exception;
use ReflectionClass;
use YandexDirectSDK\Common\Arr;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\ModelException;
use YandexDirectSDK\Interfaces\Model as ModelInterface;
use YandexDirectSDK\Interfaces\ModelCollection as ModelCollectionInterface;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;

/**
 * Class Model
 * @package YandexDirectSDK\Components
 */
abstract class Model implements ModelInterface
{
    const IS_READABLE = 1 << 0;     // 0001
    const IS_WRITABLE = 1 << 1;     // 0010
    const IS_ADDABLE = 1 << 2;      // 0100
    const IS_UPDATABLE = 1 << 3;    // 1000

    /**
     * Boot data registry.
     *
     * @var array
     */
    protected static $boot = [];

    /**
     * Declared virtual properties of the model.
     *
     * @var array
     */
    protected static $properties = [];

    /**
     * Declared virtual methods of the model.
     *
     * @var Service[]
     */
    protected static $methods = [];

    /**
     * Declared virtual static methods of the model.
     *
     * @var Service[]
     */
    protected static $staticMethods = [];

    /**
     * Compatible class of collection.
     *
     * @var ModelCollectionInterface
     */
    protected static $compatibleCollection;

    /**
     * Non-writable properties.
     *
     * @var array
     */
    protected static $nonWritableProperties = [];

    /**
     * Non-readable properties.
     *
     * @var array
     */
    protected static $nonReadableProperties = [];

    /**
     * Non-updateable properties.
     *
     * @var array
     */
    protected static $nonUpdatableProperties = [];

    /**
     * Non-addable properties.
     *
     * @var array
     */
    protected static $nonAddableProperties = [];

    /**
     * Data of the model instance.
     *
     * @var array
     */
    protected $data = [];

    /**
     * Implementing magic methods.
     *
     * @param string $method
     * @param mixed[] $arguments
     * @return mixed
     */
    public static function __callStatic($method, $arguments)
    {
        if (array_key_exists($method, static::$staticMethods)){
            return static::$methods[$method]::{$method}(...$arguments);
        }

        throw ModelException::make(static::class.". Static method [{$method}] is missing.");
    }

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
     * Returns object name.
     *
     * @return string
     */
    public static function getClassName()
    {
        return static::bootstrap('name');
    }

    /**
     * Returns the metadata of the declared model properties.
     *
     * @return array
     */
    public static function getPropertiesMeta()
    {
        return static::bootstrap('properties');
    }

    /**
     * Returns the metadata of the declared methods.
     *
     * @return Service[]
     */
    public static function getMethodsMeta()
    {
        return static::$methods;
    }

    /**
     * Returns the metadata of the declared static methods.
     *
     * @return Service[]
     */
    public static function getStaticMethodsMeta()
    {
        return static::$staticMethods;
    }

    /**
     * Returns class of compatible collection.
     *
     * @return ModelCollectionInterface
     */
    public static function getCompatibleCollectionClass()
    {
        return static::$compatibleCollection;
    }

    /**
     * Retrieve instance of compatible collection.
     *
     * @return ModelCollectionInterface|null
     */
    public static function makeCompatibleCollection()
    {
        return is_null(static::$compatibleCollection) ? null : static::$compatibleCollection::make();
    }

    /**
     * Bootstrap of the object.
     *
     * @param string|null $key
     * @return array|string|null
     */
    protected static function bootstrap(string $key = null)
    {
        $class = static::class;
        $classShortName = null;
        $properties = [];

        if (key_exists($class, self::$boot)){
            return is_null($key) ? self::$boot[$class] : self::$boot[$class][$key] ?? null;
        }

        try {
            $classShortName = (new ReflectionClass(static::class))->getShortName();
        } catch (Exception $error) {}

        foreach (static::$properties as $name => $propertyMeta){
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
                'readable' => !in_array($name, static::$nonReadableProperties),
                'writable' => !in_array($name, static::$nonWritableProperties)
            ];

            $properties[$name]['addable'] = ($properties[$name]['writable'] and !in_array($name, static::$nonAddableProperties));
            $properties[$name]['updatable'] = ($properties[$name]['writable'] and !in_array($name, static::$nonUpdatableProperties));
        }

        self::$boot[$class] = [
            'name' => $classShortName,
            'properties' => $properties
        ];

        return is_null($key) ? self::$boot[$class] : self::$boot[$class][$key] ?? null;
    }

    /**
     * Create a new model instance.
     */
    public function __construct()
    {
        $this->initialize();
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
     * Dynamic recording of model property values.
     *
     * @param string $property
     * @param mixed $value
     * @return mixed
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
     * @return mixed
     */
    public function __get($property)
    {
        return $this->getPropertyValue($property);
    }

    /**
     * Implementing magic methods.
     *
     * @param string $method
     * @param mixed[] $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        if (array_key_exists($method, static::$methods)){
            return static::$methods[$method]::{$method}($this, ...$arguments);
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
     * Retrieve a shallow copy of the object.
     *
     * @return static
     */
    public function copy(){
        return (new static())->insert($this->toArray());
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
        $bootProperties = static::bootstrap('properties');
        $properties = [];

        foreach ($this->data as $name => $value){

            if ($filters & self::IS_READABLE and $bootProperties[$name]['readable'] === false){
                continue;
            }

            if ($filters & self::IS_WRITABLE and $bootProperties[$name]['writable'] === false){
                continue;
            }

            if ($filters & self::IS_ADDABLE and $bootProperties[$name]['addable'] === false){
                continue;
            }

            if ($filters & self::IS_UPDATABLE and $bootProperties[$name]['updatable'] === false){
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

            if ($bootProperties[$name]['items']){
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
        $bootProperties = static::bootstrap('properties');

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

            if (!array_key_exists($name, $bootProperties)){
                continue;
            }

            if ($bootProperties[$name]['items'] === true){
                $value = $value['Items'] ?? null;
            }

            if (is_null($value)){
                $this->data[$name] = $value;
                continue;
            }

            if ($bootProperties[$name]['type'] === 'object'){
                if (!empty($this->data[$name]) and $this->data[$name] instanceof ModelCommonInterface){
                    $this->data[$name]->insert($value);
                } else {
                    $this->data[$name] = (new $bootProperties[$name]['meta'])->{'insert'}($value);
                }
                continue;
            }

            $this->data[$name] = $value;
            continue;
        }

        return $this;
    }

    /**
     * Setting a value for a model property.
     *
     * @param string $propertyName
     * @param mixed  $value
     * @return $this
     */
    public function setPropertyValue($propertyName, $value)
    {
        $propertyMeta = static::bootstrap('properties')[$propertyName] ?? null;

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
            $this->data[$propertyName] = $value;
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

        $this->data[$propertyName] = $value;
        return $this;
    }

    /**
     * Getting the value of the model property.
     *
     * @param string $propertyName
     * @return mixed|null
     */
    public function getPropertyValue($propertyName)
    {
        $propertyMeta = static::bootstrap('properties')[$propertyName] ?? null;

        if (is_null($propertyMeta)){
            throw ModelException::make(static::class.". Property [{$propertyName}] does not exist.");
        }

        if ($propertyMeta['readable'] === false){
            throw ModelException::make(static::class.". Property [{$propertyName}] is not readable.");
        }

        if ($propertyMeta['type'] === 'custom'){
            return $this->{'getter'.ucfirst($propertyName)}($propertyName, $propertyMeta);
        }

        return $this->data[$propertyName] ?? null;
    }

    /**
     * Model initialization handler.
     *
     * @return void
     */
    protected function initialize(){}
}