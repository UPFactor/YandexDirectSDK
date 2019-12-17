<?php

namespace YandexDirectSDK\Components;

use ReflectionClass;
use UPTools\Arr;
use UPTools\Components\Collection\ArrayAccessTrait;
use UPTools\Components\Collection\BaseTrait;
use UPTools\Components\Collection\MapTrait;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\ModelCollectionException;
use YandexDirectSDK\Interfaces\Model as ModelInterface;
use YandexDirectSDK\Interfaces\ModelCollection as ModelCollectionInterface;

/**
 * Class ModelCollection
 *
 * @package YandexDirectSDK\Components
 */
abstract class ModelCollection implements ModelCollectionInterface
{
    use BaseTrait,
        MapTrait,
        ArrayAccessTrait;

    /**
     * Boot data registry.
     *
     * @var Registry
     */
    protected static $boot;

    /**
     * Declared virtual methods of the collection.
     *
     * @var Service[]
     */
    protected static $methods = [];

    /**
     * Declared virtual static methods of the collection.
     *
     * @var Service[]
     */
    protected static $staticMethods = [];

    /**
     * Compatible class of model.
     *
     * @var ModelInterface
     */
    protected static $compatibleModel;

    /**
     * The models contained in the collection.
     *
     * @var ModelInterface[]
     */
    protected $items = [];

    /**
     * Returns object name.
     *
     * @return string
     */
    public static function getClassName()
    {
        return static::boot()->name;
    }

    /**
     * Returns the metadata of the declared methods.
     *
     * @return array
     */
    public static function getMethodsMeta()
    {
        return static::boot()->methods->toArray();
    }

    /**
     * Returns the metadata of the declared static methods.
     *
     * @return array
     */
    public static function getStaticMethodsMeta()
    {
        return static::boot()->staticMethods->toArray();
    }

    /**
     * Returns class of compatible model.
     *
     * @return ModelInterface|string|null
     */
    public static function getCompatibleModelClass()
    {
        return static::boot()->compatibility;
    }

    /**
     * Retrieve instance of compatible model.
     *
     * @param Data|array|null $properties
     * @return ModelInterface|null
     */
    public static function makeCompatibleModel($properties = null)
    {
        $compatibility = static::boot()->compatibility;
        return is_null($compatibility) ? null : $compatibility::make($properties);
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

        if (is_null(static::$compatibleModel)){
            throw ModelCollectionException::noCompatibleModel(static::class);
        }

        self::$boot->set($class, new ModelBootstrap([
            'name' => (new ReflectionClass($class))->getShortName(),
            'methods' => new ModelMethodCollection(Arr::map(static::$methods, function($provider, $name){
                return new ModelMethod($name, $provider);
            })),
            'staticMethods' => new ModelMethodCollection(Arr::map(static::$staticMethods, function($provider, $name){
                return new ModelMethod($name, $provider);
            })),
            'compatibility' => static::$compatibleModel
        ]));

        return self::$boot->get($class);
    }

    /**
     * Create a new collection instance.
     *
     * @param ModelInterface[] $models
     */
    public function __construct($models = [])
    {
        $this->reset($models);
    }

    /**
     * Returns a string representation of the current collection.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
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
        if (is_null($bootMethod = static::boot()->getStaticMethod($method))){
            throw ModelCollectionException::modelMethodNotExist(static::class, $method);
        }

        return $bootMethod->call(...$arguments);
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
        if (is_null($bootMethod = static::boot()->getMethod($method))){
            throw ModelCollectionException::modelMethodNotExist(static::class, $method);
        }

        return $bootMethod->call($this, ...$arguments);
    }

    /**
     * Retrieve the collection hash.
     *
     * @return string
     */
    public function hash()
    {
        return Arr::hash($this->toArray());
    }

    /**
     * Retrieve copy of the object.
     *
     * @return static
     */
    public function copy(){
        return $this->redeclare(
            Arr::map($this->items, function(ModelInterface $item){
                return $item->copy();
            })
        );
    }

    /**
     * Extract the array of model property values from the collection.
     *
     * @param string|string[] $properties
     * @return array
     */
    public function extract($properties)
    {
        if (is_string($properties)){
            return Arr::map($this->items, function(ModelInterface $model) use ($properties){
                return $model->getPropertyValue($properties);
            });
        }

        if (is_array($properties)){
            return Arr::map($this->items, function(ModelInterface $model) use ($properties){
                $result = [];
                foreach ($properties as $property){
                    $result[$property] = $model->getPropertyValue($property);
                }
                return $result;
            });
        }

        return [];
    }

    /**
     * Push an item onto the end of the collection.
     *
     * @param ModelInterface $value
     * @return $this
     */
    public function push($value)
    {
        array_push($this->items, $this->dataItemController($value));
        return $this;
    }

    /**
     * Insert model source into the collection.
     *
     * @param ModelCollectionInterface|ModelInterface[]|Data|array $source
     * @return $this
     */
    public function insert($source)
    {
        if ($source instanceof Data){
            $source = $source->unwrap();
        } elseif (!is_array($source) and !($source instanceof ModelCollectionInterface)) {
            throw InvalidArgumentException::modelCollectionInsert(
                static::class,
                static::class . "|" . Data::class . '|array',
                $source
            );
        }

        foreach ($source as $index => $model){
            if (array_key_exists($index, $this->items)){
                if ($model instanceof ModelInterface){
                    $this->set($index, $model);
                } else {
                    $this->items[$index]->insert($model);
                }
            } else {
                $this->set($index, $model);
            }
        }

        ksort($this->items);
        return $this;
    }

    /**
     * Converts the current collection to array.
     *
     * @param int $filter
     * @return array
     */
    public function toArray($filter = 0)
    {
        if ($filter !== 0){
            ksort($this->items);
            $this->items = array_values($this->items);
        }

        return Arr::map($this->items, function(ModelInterface $item) use ($filter){
            return $item->toArray($filter);
        });
    }

    /**
     * Converts the current collection to a Data object.
     *
     * @param int $filters
     * @return Data
     */
    public function toData($filters = 0){
        return new Data($this->toArray($filters));
    }

    /**
     * Converts the current collection to JSON.
     *
     * @param int $filters
     * @return string
     */
    public function toJson($filters = 0)
    {
        return Arr::toJson($this->toArray($filters));
    }

    /**
     * Preprocessor combining collections with data.
     *
     * @param ModelInterface[] $models
     * @return ModelInterface[]
     */
    protected function dataFusionController($models)
    {
        if (!is_array($models)){
            throw InvalidArgumentException::modelCollectionMerge(static::class,  'array', $models);
        }

        return Arr::map($models, function($item, $key){
            return $this->dataItemController($item, $key);
        });
    }

    /**
     * Preprocessor adding new items to the collection.
     *
     * @param ModelInterface|array $model
     * @param integer|null $key
     * @return ModelInterface
     */
    protected function dataItemController($model, $key = null)
    {
        if (!is_null($key) and !is_integer($key)){
            throw InvalidArgumentException::modelCollectionKey(static::class, 'integer', $key);
        }

        if (is_array($model)){
            return static::makeCompatibleModel($model);
        }

        $compatibility = static::getCompatibleModelClass();
        if (!is_object($model) or !($model instanceof $compatibility)){
            throw InvalidArgumentException::modelCollectionItem(static::class, $compatibility, $model);
        }

        return $model;
    }
}