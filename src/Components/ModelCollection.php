<?php

namespace YandexDirectSDK\Components;

use Closure;
use ReflectionClass;
use ReflectionException;
use YandexDirectSDK\Common\Arr;
use YandexDirectSDK\Common\SessionTrait;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\ModelCollectionException;
use YandexDirectSDK\Interfaces\Model as ModelInterface;
use YandexDirectSDK\Interfaces\ModelCollection as ModelCollectionInterface;
use YandexDirectSDK\Session;

/**
 * Class ModelCollection
 *
 * @package YandexDirectSDK\Components
 */
abstract class ModelCollection implements ModelCollectionInterface
{
    use SessionTrait;

    /**
     * The models contained in the collection.
     *
     * @var ModelInterface[]
     */
    protected $items = [];

    /**
     * Compatible class of model.
     *
     * @var ModelInterface
     */
    protected $compatibleModel;

    /**
     * Service-providers methods.
     *
     * @var Service[]
     */
    protected $serviceProvidersMethods = [];

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
     * Create a new collection instance.
     *
     * @param mixed ...$values
     * @return static
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public static function make(...$values){
        return (new static())->reset($values);
    }

    /**
     * Create a new collection instance.
     *
     * @param ModelCollectionInterface|ModelInterface[] $models
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function __construct($models = null)
    {
        $this->initialize($models);
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
     * Implementing dynamic methods.
     *
     * @param string  $method
     * @param mixed[] $arguments
     * @return $this|mixed|null
     * @throws ModelCollectionException
     */
    public function __call($method, $arguments)
    {
        if (array_key_exists($method, $this->serviceProvidersMethods)){
            if (!is_null($this->session)){
                return (new $this->serviceProvidersMethods[$method]($this->session))->{$method}($this, ...$arguments);
            }

            throw ModelCollectionException::make(static::class.". Failed method [{$method}]. No session to connect.");
        }

        throw ModelCollectionException::make(static::class.". Method [{$method}] is missing.");
    }

    /**
     * Reset the collection.
     *
     * @param mixed $value
     * @return $this
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function reset($value = []){
        $this->items = $this->dataFusionController($value);
        return $this;
    }

    /**
     * Create a new collection instance.
     *
     * @param mixed $value
     * @return static
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public static function wrap($value){
        return (new static())->reset($value);
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
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function copy(){
        $copy = Arr::map($this->items, function(ModelInterface $item){
            return $item->copy();
        });

        return new static($copy);
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
            return Arr::map($this->items, function($model) use ($properties){
                return $model->{$properties};
            });
        }

        if (is_array($properties)){
            return Arr::map($this->items, function($model) use ($properties){
                $result = [];
                foreach ($properties as $property){
                    $result[$property] = $model->{$property};
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
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
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
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
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
     * @throws InvalidArgumentException
     */
    public function push($value)
    {
        $value = $this->dataItemController($value);

        if (!is_null($this->session)){
            $value->setSession($this->session);
        }

        array_push($this->items, $value);
        return $this;
    }

    /**
     * Retrieve a new collection with the results of calling a provided function
     * on every element in the current collection.
     *
     * @param Closure $callable
     * @param null $context
     * @return static
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
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
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
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
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function slice($offset, $length = null){
        return $this->redeclare(array_slice($this->items, $offset, $length));
    }

    /**
     * Insert model source into the collection.
     *
     * @param Data|array $source
     * @return $this
     * @throws InvalidArgumentException
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
                $model = $this->compatibleModel::make($model);

                if (!is_null($this->session)){
                    $model->setSession($this->session);
                }

                $this->push($model);
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
     * Binds the collection to a session.
     *
     * @param Session $session
     * @return $this
     */
    public function setSession(Session $session)
    {
        $this->session = $session;
        foreach ($this->items as $model){
            $model->setSession($session);
        }
        return $this;
    }

    /**
     * Retrieve instance of compatible models.
     *
     * @return ModelInterface
     */
    public function getCompatibleModel()
    {
        return $this->compatibleModel::make();
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
     * Collection initialization handler.
     *
     * @param ModelCollectionInterface|ModelInterface[] $models
     * @return void
     */
    protected function initialize($models){}

    /**
     * Re-declares the current collection with a new set of elements.
     *
     * @param mixed $value
     * @return static
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    protected function redeclare($value){
        return (new static())->reset($value);
    }

    /**
     * Preprocessor combining collections with data.
     *
     * @param mixed $data
     * @return static[]
     * @throws ModelCollectionException
     * @throws InvalidArgumentException
     */
    protected function dataFusionController($data)
    {
        if (is_null($this->compatibleModel)){
            throw ModelCollectionException::make(static::class.". Collection is not serviced.");
        }

        if (is_object($data)){
            if (get_class($data) !== static::class) {
                throw InvalidArgumentException::invalidType(static::class, 1, static::class."|array of {$this->compatibleModel}", get_class($data));
            }
            return $data->all();
        }

        if (is_array($data)){
            return Arr::map($data, function($item){
                return $this->dataItemController($item);
            });
        }

        throw InvalidArgumentException::invalidType(static::class, 1, static::class."|array of {$this->compatibleModel}", gettype($data));
    }

    /**
     * Preprocessor adding new items to the collection.
     *
     * @param mixed $item
     * @return static
     * @throws InvalidArgumentException
     */
    protected function dataItemController($item)
    {
        if (!is_object($item)){
            throw InvalidArgumentException::invalidType(static::class, 1, $this->compatibleModel, gettype($item));
        }

        if (get_class($item) !== $this->compatibleModel){
            throw InvalidArgumentException::invalidType(static::class, 1, $this->compatibleModel, get_class($item));
        }

        return $item;
    }
}