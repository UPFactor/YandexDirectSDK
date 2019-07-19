<?php

namespace YandexDirectSDK\Interfaces;

use Closure;
use Countable;
use Iterator;
use SeekableIterator;
use YandexDirectSDK\Interfaces\Model as ModelInterface;

/**
 * Interface ModelCollection
 *
 * @package YandexDirectSDK\Interfaces
 */
interface ModelCollection extends ModelCommon, Iterator, SeekableIterator, Countable
{
    /**
     * Returns class of compatible model.
     *
     * @return ModelInterface
     */
    public static function getCompatibleModelClass();

    /**
     * Retrieve instance of compatible models.
     *
     * @return ModelInterface
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
     * Extract the array of model property values from the collection.
     *
     * @param string|string[] $properties
     * @return array
     */
    public function extract($properties);

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
}