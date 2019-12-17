<?php

namespace YandexDirectSDK\Interfaces;

use ArrayAccess;
use Closure;
use Countable;
use IteratorAggregate;
use YandexDirectSDK\Components\Data;
use YandexDirectSDK\Interfaces\Model as ModelInterface;
use YandexDirectSDK\Interfaces\ModelCollection as ModelCollectionInterface;

/**
 * Interface ModelCollection
 *
 * @package YandexDirectSDK\Interfaces
 */
interface ModelCollection extends ModelCommon, Countable, IteratorAggregate, ArrayAccess
{
    /**
     * Returns class of compatible model.
     *
     * @return ModelInterface|string|null
     */
    public static function getCompatibleModelClass();

    /**
     * Retrieve instance of compatible models.
     *
     * @return ModelInterface|null
     */
    public static function makeCompatibleModel();

    /**
     * Create a new collection instance.
     *
     * @param ModelInterface[] ...$models
     * @return static
     */
    public static function make(...$models);

    /**
     * Create a new collection instance.
     *
     * @param ModelInterface[]
     * @return static
     */
    public static function wrap(array $models);

    /**
     * Get all of the items in the collection.
     *
     * @return ModelInterface[]
     */
    public function unwrap();

    /**
     * Reset the collection.
     *
     * @param ModelInterface[] $models
     * @return static
     */
    public function reset(array $models = []);

    /**
     * Get all of the items in the collection.
     *
     * @return ModelInterface[]
     */
    public function all();

    /**
     * Count the number of items in the collection.
     *
     * @return int
     */
    public function count();

    /**
     * Determine if the collection is empty.
     *
     * @param Closure|null $callable
     * @return bool
     */
    public function isEmpty(Closure $callable = null);

    /**
     * Determine if the collection is not empty.
     *
     * @param Closure|null $callable
     * @return bool
     */
    public function isNotEmpty(Closure $callable = null);

    /**
     * Get the keys of the collection items.
     *
     * @return array
     */
    public function keys();

    /**
     * Get the values of the collection items.
     *
     * @return ModelInterface[]
     */
    public function values();

    /**
     * Divide the collection into two arrays. One with keys,
     * and the other with values.
     *
     * @return array
     */
    public function divide();

    /**
     * Return the first item in the collection that passed a given truth test.
     *
     * @param  mixed|null  $default
     * @param  Closure $callback
     * @return ModelInterface|null
     */
    public function first($default = null, $callback = null);

    /**
     * Return the last item in the collection that passed a given truth test.
     *
     * @param  mixed|null $default
     * @param  Closure $callback
     * @return ModelInterface|null
     */
    public function last($default = null, $callback = null);

    /**
     * Get and delete the first item from the collection.
     *
     * @param mixed|null $default
     * @return ModelInterface|null
     */
    public function shift($default = null);

    /**
     * Get and delete the last item from the collection.
     *
     * @param mixed|null $default
     * @return ModelInterface|null
     */
    public function pop($default = null);

    /**
     * Get a subset of the items from the given array.
     *
     * @param string|array $keys
     * @return static
     */
    public function only($keys);

    /**
     * Get a new collection based on the current one, eliminating
     * a subset of items.
     *
     * @param string|array $keys
     * @return static
     */
    public function not($keys);

    /**
     * Returns all elements of the collection except the last.
     * Pass the "Number" parameter to exclude more elements from the ending of the collection.
     *
     * @param int $count
     * @return static
     */
    public function initial($count = 1);

    /**
     * Returns all elements of the collection except the first.
     * Pass the "Number" parameter to exclude more elements from the beginning of the collection.
     *
     * @param int $count
     * @return static
     */
    public function tail($count = 1);

    /**
     * Retrieve a new collection with the results of calling a provided function
     * on every element in the current collection.
     *
     * @param Closure $callable
     * @param null $context
     * @return static
     */
    public function map(Closure $callable, $context = null);

    /**
     * Executes a provided function once for each collection  element.
     *
     * @param Closure $callable
     * @param null $context
     * @return $this
     */
    public function each(Closure $callable, $context = null);

    /**
     * Retrieve a new collection with all the elements that pass the test
     * implemented by the provided function.
     *
     * @param Closure $callable
     * @param null $context
     * @return static
     */
    public function filter(Closure $callable, $context = null);

    /**
     * Slice the collection.
     *
     * @param $offset
     * @param null $length
     * @return static
     */
    public function slice($offset, $length = null);

    /**
     * Push an item onto the end of the collection.
     *
     * @param ModelInterface|array $value
     * @return $this
     */
    public function push($value);

    /**
     * Get model/models from collection by key/keys.
     *
     * @param string|string[]|int|int[] $keys
     * @param mixed|null $default
     * @return ModelInterface|ModelInterface[]
     */
    public function get($keys, $default = null);

    /**
     * Get and delete model/models from collection by key/keys.
     *
     * @param string|string[]|int|int[] $keys
     * @param mixed|null $default
     * @return ModelInterface|ModelInterface[]
     */
    public function pull($keys, $default = null);

    /**
     * Check by key/keys if there is an model/models in the collection.
     * Set the parameter [$strict], for additional checking for empty values.
     *
     * @param string|string[]|int|int[] $keys
     * @param bool $strict
     * @return bool
     */
    public function has($keys, $strict = false);

    /**
     * Set model to collection.
     *
     * @param string|int $key
     * @param ModelInterface|array $value
     * @return $this
     */
    public function set($key, $value);

    /**
     * Add model to collection, if it does not exist.
     *
     * @param string|int $key
     * @param ModelInterface|array $value
     * @return $this
     */
    public function add($key, $value);

    /**
     * Remove model/models from collection by key/keys.
     *
     * @param string|string[]|int|int[] $keys
     * @return $this
     */
    public function remove($keys);

    /**
     * Extract the array of model property values from the collection.
     *
     * @param string|string[] $properties
     * @return array
     */
    public function extract($properties);

    /**
     * Insert data into the object.
     *
     * @param ModelCollectionInterface|ModelInterface[]|Data|array $source
     * @return $this
     */
    public function insert($source);
}