<?php

namespace YandexDirectSDK\Components;

use Closure;
use Exception;
use ReflectionClass;
use YandexDirectSDK\Common\Arr;
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
    /**
     * Boot data registry.
     *
     * @var array
     */
    protected static $boot = [];

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
     * @var int
     */
    protected $position = 0;

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

        throw ModelCollectionException::make(static::class.". Static method [{$method}] is missing.");
    }

    /**
     * Create a new collection instance.
     *
     * @param ModelInterface ...$models
     * @return static
     */
    public static function make(...$models)
    {
        return (new static($models));
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
     * Returns class of compatible model.
     *
     * @return ModelInterface
     */
    public static function getCompatibleModelClass()
    {
        return static::$compatibleModel;
    }

    /**
     * Retrieve instance of compatible model.
     *
     * @return ModelInterface
     */
    public static function makeCompatibleModel()
    {
        return static::$compatibleModel::make();
    }

    /**
     * Create a new collection instance.
     *
     * @param ModelInterface[] $models
     * @return static
     */
    public static function wrap(array $models)
    {
        return (new static($models));
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

        if (key_exists($class, self::$boot)){
            return is_null($key) ? self::$boot[$class] : self::$boot[$class][$key] ?? null;
        }

        try {
            $classShortName = (new ReflectionClass(static::class))->getShortName();
        } catch (Exception $error) {}

        self::$boot[$class] = [
            'name' => $classShortName
        ];

        return is_null($key) ? self::$boot[$class] : self::$boot[$class][$key] ?? null;
    }

    /**
     * Create a new collection instance.
     *
     * @param ModelInterface[] $models
     */
    public function __construct(array $models = null)
    {
        $this->initialize($models);

        if (is_null(static::$compatibleModel)){
            throw ModelCollectionException::make(static::class.". Collection is not serviced.");
        }

        if (!is_null($models)) $this->reset($models);
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

        throw ModelCollectionException::make(static::class.". Static method [{$method}] is missing.");
    }

    /**
     * Rewind the Iterator to the first element
     *
     * @return void
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * Return the current element.
     *
     * @return ModelInterface
     */
    public function current()
    {
        return $this->items[$this->position];
    }

    /**
     * Move forward to next element.
     *
     * @return void
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * Return the key of the current element.
     *
     * @return int
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * Checks if current position is valid.
     *
     * @return bool
     */
    public function valid()
    {
        return isset($this->items[$this->position]);
    }

    /**
     * Seeks to a position.
     *
     * @param int $position
     * @return ModelInterface
     */
    public function seek($position)
    {
        return $this->items[$position];
    }

    /**
     * Reset the collection.
     *
     * @param ModelInterface[] $models
     * @return $this
     */
    public function reset(array $models = [])
    {
        $this->items = $this->dataFusionController($models);
        return $this;
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
     * Get all of the items in the collection.
     *
     * @return ModelInterface[]
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * Count the number of items in the collection.
     *
     * @return int
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * Determine if the collection is empty.
     *
     * @param Closure|null $callable
     * @return bool
     */
    public function isEmpty(Closure $callable = null)
    {
        if (empty($this->items)){
            if (!is_null($callable)){
                $callable($this);
            }
            return true;
        }
        return false;
    }

    /**
     * Determine if the collection is not empty.
     *
     * @param Closure|null $callable
     * @return bool
     */
    public function isNotEmpty(Closure $callable = null)
    {
        if (!empty($this->items)){
            if (!is_null($callable)){
                $callable($this);
            }
            return true;
        }
        return false;
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
     * Return the first item in the collection that passed a given truth test.
     *
     * @param  mixed  $default
     * @param  Closure $callback
     * @return ModelInterface|null
     */
    public function first($default = null, $callback = null)
    {
        return Arr::first($this->items, ...func_get_args());
    }

    /**
     * Return the last item in the collection that passed a given truth test.
     *
     * @param  ModelInterface $default
     * @param  Closure $callback
     * @return ModelInterface|null
     */
    public function last($default = null, $callback = null)
    {
        return Arr::last($this->items, ...func_get_args());
    }

    /**
     * Get and delete the first item from the collection.
     *
     * @param mixed|null $default
     * @return ModelInterface|null
     */
    public function shift($default = null)
    {
        if (count($this->items) > 0){
            return array_shift($this->items);
        }
        return $default;
    }

    /**
     * Get and delete the last item from the collection.
     *
     * @param mixed|null $default
     * @return ModelInterface|null
     */
    public function pop($default = null)
    {
        if (count($this->items) > 0){
            return array_pop($this->items);
        }
        return $default;
    }

    /**
     * Returns all elements of the collection except the last.
     * Pass the "Number" parameter to exclude more elements from the ending of the collection.
     *
     * @param int $count
     * @return static
     */
    public function initial($count = 1)
    {
        return $this->redeclare(array_values(Arr::initial($this->items, $count)));
    }

    /**
     * Returns all elements of the collection except the first.
     * Pass the "Number" parameter to exclude more elements from the beginning of the collection.
     *
     * @param int $count
     * @return static
     */
    public function tail($count = 1)
    {
        return $this->redeclare(array_values(Arr::tail($this->items, $count)));
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
     * Retrieve a new collection with the results of calling a provided function
     * on every element in the current collection.
     *
     * @param Closure $callable
     * @param null $context
     * @return static
     */
    public function map(Closure $callable, $context = null)
    {
        return $this->redeclare(array_values(Arr::map($this->items, $callable, $context)));
    }

    /**
     * Executes a provided function once for each collection  element.
     *
     * @param Closure $callable
     * @param null $context
     * @return $this
     */
    public function each(Closure $callable, $context = null)
    {
        Arr::each($this->items, $callable, $context);
        return $this;
    }

    /**
     * Retrieve a new collection with all the elements that pass the test
     * implemented by the provided function.
     *
     * @param Closure $callable
     * @param null $context
     * @return static
     */
    public function filter(Closure $callable, $context = null)
    {
        return $this->redeclare(array_values(Arr::filter($this->items, $callable, $context)));
    }

    /**
     * Slice the collection.
     *
     * @param $offset
     * @param null $length
     * @return static
     */
    public function slice($offset, $length = null)
    {
        return $this->redeclare(array_slice($this->items, $offset, $length));
    }

    /**
     * Insert model source into the collection.
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

        foreach ($source as $index => $model){
            if (array_key_exists($index, $this->items)){
                $this->items[$index]->insert($model);
            } else {
                $this->push(
                    static::$compatibleModel::make($model)
                );
            }
        }

        return $this;
    }

    /**
     * Converts the current collection to array.
     *
     * @param int $filters
     * @return array
     */
    public function toArray($filters = 0)
    {
        return Arr::map($this->items, function(ModelInterface $item) use ($filters){
            return $item->toArray($filters);
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
     * Collection initialization handler.
     *
     * @param ModelCollectionInterface|ModelInterface[] $models
     * @return void
     */
    protected function initialize($models){}

    /**
     * Re-declares the current collection with a new set of elements.
     *
     * @param ModelInterface[] $models
     * @return static
     */
    protected function redeclare(array $models = [])
    {
        return new static($models);
    }

    /**
     * Preprocessor combining collections with data.
     *
     * @param ModelInterface[] $models
     * @return ModelInterface[]
     */
    protected function dataFusionController(array $models)
    {
        return Arr::map($models, function($item){
            return $this->dataItemController($item);
        });
    }

    /**
     * Preprocessor adding new items to the collection.
     *
     * @param ModelInterface $model
     * @return ModelInterface
     */
    protected function dataItemController($model)
    {
        if (!is_object($model)){
            throw InvalidArgumentException::invalidType(static::class, 1, static::$compatibleModel, gettype($model));
        }

        if (get_class($model) !== static::$compatibleModel){
            throw InvalidArgumentException::invalidType(static::class, 1, static::$compatibleModel, get_class($model));
        }

        return $model;
    }
}