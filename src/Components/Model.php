<?php

namespace YandexDirectSDK\Components;

use ReflectionClass;
use ReflectionException;
use BadMethodCallException;
use InvalidArgumentException;
use YandexDirectSDK\Session;
use YandexDirectSDK\Common\Arr;
use YandexDirectSDK\Interfaces\Model as ModelInterface;
use YandexDirectSDK\Interfaces\ModelCollection as ModelCollectionInterface;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;

/**
 * Class Model
 * @package YandexDirectSDK\Components
 */
class Model implements ModelInterface
{
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
     * Non-readable properties
     *
     * @var array
     */
    protected $nonReadableProperties = [];

    /**
     * Required model properties.
     *
     * @var array
     */
    protected $requiredProperties = [];

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
     * Session instance.
     *
     * @var Session|null
     */
    protected $session;

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
        $requiredProperties = [];

        foreach ($this->requiredProperties as $key => $requiredProperty){
            $this->requiredProperties[$key] = explode('|', $requiredProperty);
            $requiredProperties = array_unique(array_merge($requiredProperties, $this->requiredProperties[$key]));
        }

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
            }

            $properties[$name] = [
                'name' => $name,
                'type' => strtolower($propertyType),
                'meta' => $propertyTypeMeta,
                'items' => $propertyUseItemsSubarray,
                'read' => !in_array($name, $this->nonReadableProperties),
                'write' => !in_array($name, $this->nonWritableProperties),
                'require' => in_array($name, $requiredProperties)
            ];
        }

        $this->properties = $properties;
    }

    /**
     * Dynamic recording of model property values.
     *
     * @param string $property
     * @param mixed  $value
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
     * @return mixed|null
     */
    public function __get($property)
    {
        return $this->getPropertyValue($property);
    }

    /**
     * Implementing dynamic methods.
     *
     * @param string  $method
     * @param mixed[] $arguments
     * @return $this|mixed|null
     */
    public function __call($method, $arguments)
    {
        if (array_key_exists($method, $this->serviceProvidersMethods)){
            if (!is_null($this->session)){
                return (new $this->serviceProvidersMethods[$method]($this->session))->{$method}($this);
            }

            throw new BadMethodCallException(static::class.". Failed method [{$method}]. No session to connect.");
        }

        $action = substr($method, 0, 3);
        $property = lcfirst(substr($method, 3));

        if ($action === 'get'){
            return $this->getPropertyValue($property);
        }

        if ($action === 'set'){
            return $this->setPropertyValue($property, ...$arguments);
        }

        throw new BadMethodCallException(static::class.". Method [{$method}] is missing.");
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
     * Get the model as a plain array.
     *
     * @return array
     */
    public function unwrap()
    {
        $properties = [];
        foreach ($this->modelData as $name => $value){
            if ($value instanceof ModelCommonInterface){
                $value = $value->unwrap();
            }

            if (is_numeric($value)){
                $properties[ucfirst($name)] = $value;
                continue;
            }

            if (empty($value)){
                $properties[ucfirst($name)] = null;
                continue;
            }

            if ($this->properties[$name]['items']){
                $value = ['Items' => $value];
            }

            $properties[ucfirst($name)] = $value;
        }
        return $properties;
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

            if ($this->properties[$name]['type'] !== 'object'){
                $this->modelData[$name] =  $value;
                continue;
            }

            $propertyObject = $this->properties[$name]['meta'];
            $propertyObject = new $propertyObject();

            if ($propertyObject instanceof ModelInterface){
                $propertyObject->insert($value);
                $this->modelData[$name] = $propertyObject;
                continue;
            }

            if ($propertyObject instanceof ModelCollectionInterface){
                if (is_array($value)) {
                    foreach ($value as $item) {
                        $propertyObject->push(
                            $propertyObject
                                ->getCompatibleModel()
                                ->insert($item)
                        );
                    }
                }

                $this->modelData[$name] = $propertyObject;
            }
        }

        return $this;
    }

    /**
     * Converts current model to array.
     *
     * @return array
     */
    public function toArray()
    {
        $properties = [];
        foreach ($this->modelData as $name => $value){
            if ($this->properties[$name]['write'] === false){
                continue;
            }

            if ($value instanceof ModelCommonInterface){
                $value = $value->toArray();
            }

            if (is_numeric($value)){
                $properties[ucfirst($name)] = $value;
                continue;
            }

            if (empty($value)){
                $properties[ucfirst($name)] = null;
                continue;
            }

            if ($this->properties[$name]['items']){
                $value = ['Items' => $value];
            }

            $properties[ucfirst($name)] = $value;
        }
        return $properties;
    }

    /**
     * Converts current model to JSON.
     *
     * @return string
     */
    public function toJson()
    {
        return Arr::toJson($this->toArray());
    }

    /**
     * Model sufficiency checking.
     *
     * @return $this
     */
    public function check()
    {
        $modelDataKeys = array_keys($this->modelData);

        foreach ($this->requiredProperties as $requiredProperty){
            $controlProperty = false;

            foreach ($requiredProperty as $requiredPropertyItem){
                if(in_array($requiredPropertyItem, $modelDataKeys)){
                    $controlProperty = true;
                    break;
                }
            }

            if ($controlProperty === false){
                throw new InvalidArgumentException(static::class.". Required property [".implode('|', $requiredProperty)."] is not set.");
            }
        }

        foreach ($this->modelData as $value){
            if ($value instanceof ModelInterface or $value instanceof ModelCollectionInterface){
                $value->check();
            }
        }

        return $this;
    }

    /**
     * Binds the model to a session.
     *
     * @param Session $session
     * @return $this
     */
    public function setSession(Session $session)
    {
        $this->session = $session;
        return $this;
    }

    /**
     * Retrieve the session used by the model.
     *
     * @return null|Session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Retrieve instance of compatible collection.
     *
     * @return ModelCollectionInterface
     */
    public function getCompatibleCollection()
    {
        return $this->compatibleCollection::make();
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
     * @param string $property
     * @param mixed  $value
     * @return $this
     */
    protected function setPropertyValue($property, $value)
    {
        $property = $this->properties[$property] ?? null;

        if (is_null($property)){
            throw new InvalidArgumentException(static::class.". Property [{$property}] does not exist.");
        }

        if ($property['write'] === false){
            throw new InvalidArgumentException(static::class.". Property [{$property}] is not writable.");
        }

        if ($this->propertyValidation($property, $value) === false){
            throw new InvalidArgumentException(static::class.". Failed to write value to property [{$property}]. Expected value [{$this->properties[$property]['type']}].");
        }

        $this->modelData[$property['name']] = $value;
        return $this;
    }

    /**
     * Getting the value of the model property.
     *
     * @param string $property
     * @return mixed|null
     */
    protected function getPropertyValue($property)
    {
        $property = $this->properties[$property] ?? null;

        if (is_null($property)){
            throw new InvalidArgumentException(static::class.". Property [{$property}] does not exist.");
        }

        if ($property['read'] === false){
            throw new InvalidArgumentException(static::class.". Property [{$property}] is not readable.");
        }

        return $this->modelData[$property['name']] ?? null;
    }

    /**
     * Validation of values.
     *
     * @param string $property
     * @param mixed  $value
     * @return bool
     */
    protected function propertyValidation($property, $value)
    {
        if (!is_array($property)){
            return false;
        }

        switch ($property['type']){
            case 'mixed':   return true;                break;
            case 'string':  return is_string($value);   break;
            case 'boolean': return is_bool($value);     break;
            case 'double':  return is_float($value);    break;
            case 'integer': return is_integer($value);  break;
            case 'numeric': return is_numeric($value);  break;
            case 'array':

                if (!is_array($value)) {
                    return false;
                }

                if (!is_null($property['meta'])){
                    foreach ($value as $valueItem){
                        if (!in_array(gettype($valueItem), $property['meta'])) {
                            return false;
                        }
                    }
                }

                return true;
                break;

            case 'enum':

                return in_array($value, $property['meta']);
                break;

            case 'set':

                if (!is_array($value)) {
                    return false;
                }

                foreach ($value as $item){
                    if (!in_array($item,  $property['meta'])) {
                        return false;
                    }
                }

                return true;
                break;

            case 'object':

                if (!is_object($value)) {
                    return false;
                }

                if (!is_null($property['meta'])){
                    return $value instanceof $property['meta'];
                }

                return true;
                break;
        }

        return false;
    }
}