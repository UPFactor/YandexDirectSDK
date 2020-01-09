<?php

namespace YandexDirectSDK\Components;

use ReflectionClass;
use UPTools\Arr;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\ModelException;
use YandexDirectSDK\Interfaces\Model as ModelInterface;
use YandexDirectSDK\Interfaces\ModelCollection as ModelCollectionInterface;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;

/**
 * Class Model
 *
 * @package YandexDirectSDK\Components
 */
abstract class Model implements ModelInterface
{
    const IS_READABLE = 1 << 0;     // 00001
    const IS_WRITABLE = 1 << 1;     // 00010
    const IS_ADDABLE = 1 << 2;      // 00100
    const IS_UPDATABLE = 1 << 3;    // 01000

    /**
     * Boot data registry.
     *
     * @var Registry
     */
    protected static $boot;

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
     * Compatible model collection class.
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
     * Create a new model instance.
     *
     * @param Data|array|null $properties
     * @return static
     */
    public static function make($properties = null)
    {
        return new static($properties);
    }

    /**
     * Returns object name.
     *
     * @return string
     */
    public static function getClassName():string
    {
        return static::boot()->name;
    }

    /**
     * Returns the metadata of the declared model properties.
     *
     * @return array
     */
    public static function getPropertiesMeta():array
    {
        return static::boot()->properties->toArray();
    }

    /**
     * Returns the metadata of the declared methods.
     *
     * @return array
     */
    public static function getMethodsMeta():array
    {
        return static::boot()->methods->toArray();
    }

    /**
     * Returns the metadata of the declared static methods.
     *
     * @return array
     */
    public static function getStaticMethodsMeta():array
    {
        return static::boot()->staticMethods->toArray();
    }

    /**
     * Returns class of compatible collection.
     *
     * @return ModelCollectionInterface|string|null
     */
    public static function getCompatibleCollectionClass()
    {
        return static::boot()->compatibility;
    }

    /**
     * Retrieve instance of compatible collection.
     *
     * @return ModelCollectionInterface|null
     */
    public static function makeCompatibleCollection()
    {
        $compatibility = static::boot()->compatibility;
        return is_null($compatibility) ? null : $compatibility::make();
    }

    /**
     * Bootstrap of the object.
     *
     * @return ModelBootstrap
     */
    protected static function boot()
    {
        $class = static::class;

        if (is_null(self::$boot)){
            self::$boot = new Registry();
        } elseif (self::$boot->has($class)) {
            return self::$boot->get($class);
        }

        self::$boot->set($class, new ModelBootstrap([
            'name' => (new ReflectionClass($class))->getShortName(),
            'properties' => new ModelPropertyCollection(Arr::map(static::$properties, function($signature, $name){
                $property = new ModelProperty($name, $signature);
                $property->readable = !in_array($name, static::$nonReadableProperties);
                $property->writable = !in_array($name, static::$nonWritableProperties);
                $property->addable = !(in_array($name, static::$nonAddableProperties) or !$property->writable);
                $property->updatable = !(in_array($name, static::$nonUpdatableProperties) or !$property->writable);
                return $property;
            })),
            'methods' => new ModelMethodCollection(Arr::map(static::$methods, function($provider, $name){
                return new ModelMethod($name, $provider);
            })),
            'staticMethods' => new ModelMethodCollection(Arr::map(static::$staticMethods, function($provider, $name){
                return new ModelMethod($name, $provider);
            })),
            'compatibility' => static::$compatibleCollection
        ]));

        return self::$boot->get($class);
    }

    /**
     * Model constructor.
     *
     * @param Data|array|null $properties
     */
    public function __construct($properties = null)
    {
        $this->insert($properties);
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
     * Serialization handler.
     *
     * @return array
     */
    public function __sleep()
    {
        return ['data'];
    }

    /**
     * Deserialization handler.
     *
     * @return void
     */
    public function __wakeup()
    {
        static::boot();
    }

    /**
     * Cloning handler.
     *
     * @return void
     */
    public function __clone()
    {
        $data = $this->toArray();
        $this->data = [];
        $this->insert($data);
    }

    /**
     * Overload object properties.
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
     * Overloading object static methods.
     *
     * @param string $method
     * @param mixed[] $arguments
     * @return mixed
     */
    public static function __callStatic($method, $arguments)
    {
        if (!static::boot()->hasStaticMethod($method)){
            throw ModelException::modelMethodNotExist(static::class, $method);
        }

        return static::boot()->getStaticMethod($method)->call(...$arguments);
    }

    /**
     * Overloading object methods.
     *
     * @param string $method
     * @param mixed[] $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        if (!static::boot()->hasMethod($method)){
            $action = substr($method, 0, 3);
            $property = lcfirst(substr($method, 3));

            if ($action === 'get'){
                return $this->getPropertyValue($property);
            }

            if ($action === 'set'){
                return $this->setPropertyValue($property, ...$arguments);
            }

            throw ModelException::modelMethodNotExist(static::class, $method);
        }

        return static::boot()->getMethod($method)->call($this, ...$arguments);
    }

    /**
     * Retrieve a shallow copy of the object.
     *
     * @return static
     */
    public function copy(){
        return new static($this->toArray());
    }

    /**
     * Retrieve the model hash.
     *
     * @return string
     */
    public function hash():string
    {
        return Arr::hash($this->toArray());
    }

    /**
     * Converter of model.
     *
     * @param int $filter
     * @param bool $jsonMode
     * @return array|object
     */
    public function converter(int $filter, bool $jsonMode = false)
    {
        $result = [];
        $properties = static::boot()->properties;

        foreach ($this->data as $dataKey => $dataValue){
            if (is_null($property = $properties->get($dataKey))){
                continue;
            }

            $dataKey = ucfirst($dataKey);

            //Filtering values
            if (($filter & self::IS_READABLE and !$property->readable) or
                ($filter & self::IS_WRITABLE and !$property->writable) or
                ($filter & self::IS_ADDABLE and !$property->addable) or
                ($filter & self::IS_UPDATABLE and !$property->updatable)) {continue;}

            //Handling a custom property type
            if ($property->type === 'custom'){
                if (method_exists($this, $customExport = 'export'.$dataKey)){
                    $dataValue = $this->{$customExport}($dataValue, $filter, $property);
                }
            }

            //Handling a empty value
            if (is_null($dataValue)){
                $result[$dataKey] = null;
                continue;
            }

            //Handling a models and model collections
            if ($dataValue instanceof ModelCommonInterface){
                $dataValue = $dataValue->converter($filter, $jsonMode);
            }

            //Handling a tag [items]
            if ($property->itemTag){
                $dataValue = ['Items' => $dataValue];
            }

            $result[$dataKey] = $dataValue;
        }

        return $jsonMode ? (object) $result : $result;
    }

    /**
     * Converts the current model to array.
     *
     * @param int $filter
     * @return array|object
     */
    public function toArray(int $filter = 0):array
    {
        return $this->converter($filter);
    }

    /**
     * Converts the current model to a Data object.
     *
     * @param int $filter
     * @return Data
     */
    public function toData(int $filter = 0):Data
    {
        return new Data($this->converter($filter));
    }

    /**
     * Converts the current model to JSON.
     *
     * @param int $filter
     * @return string
     */
    public function toJson(int $filter = 0):string
    {
        return Arr::toJson($this->converter($filter, true));
    }

    /**
     * Converts the current model to collection
     *
     * @return ModelCollectionInterface
     */
    public function toCollection()
    {
        if (is_null($collection = static::getCompatibleCollectionClass())){
            throw ModelException::modelNotSupportConversion(static::class, 'toCollection');
        }
        return $collection::make($this);
    }

    /**
     * Insert properties into the model.
     *
     * @param ModelInterface|Data|array $source
     * @return $this
     */
    public function insert($source)
    {
        if (is_null($source)){
            return $this;
        }

        if (!is_array($source)){
            if ($source instanceof Data){
                $source = $source->unwrap();
            } elseif ($source instanceof static){
                $this->data = (function(){return $this->data;})->bindTo($source,$source)();
                return $this;
            } else {
                throw InvalidArgumentException::modelInsert(
                    static::class,
                    static::class . '|' . Data::class . '|array',
                    $source
                );
            }
        }

        foreach ($source as $sourceKey => $sourceValue){
            $sourceKey = lcfirst($sourceKey);

            if (is_null($property = static::boot()->getProperty($sourceKey))){
                throw ModelException::modelPropertyNotExist(static::class, $sourceKey);
            }

            //Handling a tag [items]
            if ($property->itemTag and is_array($sourceValue)){
                if (isset($sourceValue['Items']) and is_array($sourceValue['Items'])){
                    $sourceValue = $sourceValue['Items'];
                } else{
                    throw InvalidArgumentException::modelArrayInsert(
                        static::class,
                        [$sourceKey, 'Items'],
                        'array',
                        null
                    );
                }
            }

            //Handling a custom property type
            if ($property->type === 'custom'){
                if (method_exists($this, $customImport = 'import'.ucfirst($sourceKey))){
                    $sourceValue = $this->{$customImport}($sourceValue, $this->data[$sourceKey] ?? null, $property);
                }
            }

            //Handling a empty value
            if (is_null($sourceValue)){
                $this->data[$sourceKey] = null;
                continue;
            }

            //Handling a models and model collections
            if ($property->type === 'object'){
                $permissibleValue = $property->permissibleValues[0];
                if (is_array($sourceValue)){
                    if (isset($this->data[$sourceKey]) and $this->data[$sourceKey] instanceof $permissibleValue){
                        $this->data[$sourceKey]->insert($sourceValue);
                    } else {
                        $this->data[$sourceKey] = new $permissibleValue($sourceValue);
                    }
                } elseif ($sourceValue instanceof $permissibleValue) {
                    $this->data[$sourceKey] = $sourceValue;
                } else {
                    throw InvalidArgumentException::modelArrayInsert(
                        static::class,
                        $sourceKey,
                        "{$permissibleValue}|array",
                        $sourceValue
                    );
                }
                continue;
            }

            if (!$property->check($sourceValue, $castedValue)){
                throw InvalidArgumentException::modelPropertyValue(
                    static::class,
                    $property->name,
                    $property->type,
                    $property->permissibleValues,
                    $sourceValue
                );
            }

            $this->data[$sourceKey] = $castedValue;
        }

        return $this;
    }

    /**
     * Setting a value for a model property.
     *
     * @param string $property
     * @param mixed  $value
     * @return $this
     */
    public function setPropertyValue(string $property, $value)
    {
        $property = lcfirst($property);
        if (!static::boot()->hasProperty($property)){
            throw ModelException::modelPropertyNotExist(static::class, $property);
        }

        $property = static::boot()->getProperty($property);
        if (!$property->writable){
            throw ModelException::modelPropertyNotWritable(static::class, $property->name);
        }

        if ($property->type === 'custom'){
            if (method_exists($this, $customSetter = 'setter'.ucfirst($property->name))){
                $this->data[$property->name] = $this->{$customSetter}($value, $property);
            } else {
                $this->data[$property->name] = $value;
            }
            return $this;
        }

        if ($property->type === 'object' and is_array($value)){
            $this->data[$property->name] = new $property->permissibleValues[0]($value);
            return $this;
        }

        if (!$property->check($value, $castedValue)){
            throw InvalidArgumentException::modelPropertyValue(
                static::class,
                $property->name,
                $property->type,
                $property->permissibleValues,
                $value
            );
        }

        $this->data[$property->name] = $castedValue;
        return $this;
    }

    /**
     * Getting the value of the model property.
     *
     * @param string $property
     * @return mixed|null
     */
    public function getPropertyValue(string $property)
    {
        $property = lcfirst($property);
        if (!static::boot()->hasProperty($property)){
            throw ModelException::modelPropertyNotExist(static::class, $property);
        }

        $property = static::boot()->getProperty($property);
        if (!$property->readable){
            throw ModelException::modelPropertyNotReadable(static::class, $property->name);
        }

        if ($property->type === 'custom'){
            if (method_exists($this, $customGetter = 'getter'.ucfirst($property->name))){
                return $this->{$customGetter}($this->data[$property->name], $property);
            }
        }

        return $this->data[$property->name] ?? null;
    }
}