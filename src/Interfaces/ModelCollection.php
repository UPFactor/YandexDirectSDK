<?php

namespace YandexDirectSDK\Interfaces;

use Closure;
use YandexDirectSDK\Interfaces\Model as ModelInterface;
use YandexDirectSDK\Interfaces\ModelCollection as ModelCollectionInterface;

/**
 * Interface ModelCollection
 *
 * @package YandexDirectSDK\Interfaces
 */
interface ModelCollection extends ModelCommon
{
    /**
     * Create a new collection instance.
     *
     * @param ModelInterface[] ...$values
     * @return static
     */
    public static function make(...$values);

    /**
     * Create a new collection instance.
     *
     * @param ModelInterface[]|ModelCollectionInterface $value
     * @return static
     */
    public static function wrap($value);

    /**
     * Retrieve a new collection with items from the current collection.
     *
     * @return static
     */
    public function copy();

    /**
     * Re-declares the current collection with a new set of elements.
     *
     * @param ModelInterface[]|ModelCollectionInterface $value
     * @return static
     */
    public function redeclare($value);

    /**
     * Reset the collection.
     *
     * @param ModelInterface[]|ModelCollectionInterface $value
     * @return static
     */
    public function reset($value = []);

    /**
     * Retrieve the collection hash
     *
     * @return string
     */
    public function hash();

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
     * @param  mixed  $default
     * @param  Closure $callback
     * @return ModelInterface|null
     */
    public function first($default = null, $callback = null);

    /**
     * Return the last item in the collection that passed a given truth test.
     *
     * @param  ModelInterface $default
     * @param  Closure $callback
     * @return ModelInterface|null
     */
    public function last($default = null, $callback = null);

    /**
     * Push an item onto the end of the collection.
     *
     * @param ModelInterface $value
     * @return $this
     */
    public function push($value);

    /**
     * Pluck an array of model property values from the collection.
     *
     * @param string|string[] $properties
     * @return array
     */
    public function pluck($properties);

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
     * Removes duplicate values from a collection.
     *
     * @return $this
     */
    public function unique();

    /**
     * Retrieve a new collection with unique elements of all transferred arrays or collections.
     * The order of the elements will be determined by the order of their appearance in the source arrays.
     *
     * @param ModelInterface[]|ModelCollectionInterface ...$values
     * @return $this
     */
    public function union(...$values);

    /**
     * Merge the collection with the given items.
     *
     * @param ModelInterface[]|ModelCollectionInterface ...$values
     * @return $this
     */
    public function merge(...$values);

    /**
     * Returns a new collection containing all the values of the current collection that are missing
     * in all transferred arrays or collections.
     *
     * @param ModelInterface[]|ModelCollectionInterface ...$values
     * @return static
     */
    public function diff(...$values);

    /**
     * Returns a new collection containing all the values of the current collection that are present
     * in all transferred arrays or collections.
     *
     * @param ModelInterface[]|ModelCollectionInterface ...$values
     * @return static
     */
    public function intersect(...$values);

    /**
     * Slice the collection.
     *
     * @param $offset
     * @param null $length
     * @return static
     */
    public function slice($offset, $length = null);

    /**
     * Reverse items order.
     *
     * @return $this
     */
    public function reverse();

    /**
     * Sort through each item with a callback.
     *
     * @param Closure|null $callback
     * @return $this
     */
    public function sort(Closure $callback = null);



    /**
     * Retrieve instance of compatible models.
     *
     * @return ModelInterface
     */
    public function getCompatibleModel();
}