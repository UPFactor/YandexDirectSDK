<?php

namespace YandexDirectSDK\Common;

use Closure;

/**
 * Trait CollectionBaseTrait
 *
 * @package Sim\Common
 */
trait CollectionBaseTrait {

    /**
     * The items contained in the collection.
     *
     * @var array
     */
    protected $items = [];

    /**
     * Create a new collection instance.
     *
     * @param mixed ...$values
     * @return static
     */
    public static function make(...$values){
        return (new static())->reset($values);
    }

    /**
     * Create a new collection instance.
     *
     * @param mixed $value
     * @return static
     */
    public static function wrap($value){
        return (new static())->reset($value);
    }

    /**
     * Convert the collection to its string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return self::class;
    }

    /**
     * Retrieve a new collection with items from the current collection.
     *
     * @return static
     */
    public function copy(){
        return $this->redeclare($this->items);
    }

    /**
     * Re-declares the current collection with a new set of elements.
     *
     * @param mixed $value
     * @return static
     */
    public function redeclare($value){
        return (new static())->reset($value);
    }

    /**
     * Reset the collection.
     *
     * @param mixed $value
     * @return $this
     */
    public function reset($value = []){
        $this->items = $this->dataCreationController($value);
        return $this;
    }

    /**
     * Get the collection of items as a plain array.
     *
     * @return array
     */
    public function unwrap(){
        return Arr::map($this->items, function($item){
            return $item instanceof self ? $item->unwrap() : $item;
        });
    }

    /**
     * Retrieve the collection hash
     *
     * @return string
     */
    public function hash(){
        return Arr::hash($this->items);
    }

    /**
     * Get all of the items in the collection.
     *
     * @return array
     */
    public function all(){
        return $this->items;
    }

    /**
     * Count the number of items in the collection.
     *
     * @return int
     */
    public function count(){
        return count($this->items);
    }

    /**
     * Determine if the collection is empty.
     *
     * @param Closure|null $callable
     * @return bool
     */
    public function isEmpty(Closure $callable = null){
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
    public function isNotEmpty(Closure $callable = null){
        if (!empty($this->items)){
            if (!is_null($callable)){
                $callable($this);
            }
            return true;
        }
        return false;
    }

    /**
     * Get the keys of the collection items.
     *
     * @return array
     */
    public function keys(){
        return array_keys($this->items);
    }

    /**
     * Get the values of the collection items.
     *
     * @return array
     */
    public function values(){
        return array_values($this->items);
    }

    /**
     * Divide the collection into two arrays. One with keys,
     * and the other with values.
     *
     * @return array
     */
    public function divide(){
        return Arr::divide($this->items);
    }

    /**
     * Return the first item in the collection that passed a given truth test.
     *
     * @param  mixed  $default
     * @param  Closure $callback
     * @return mixed|null
     */
    public function first($default = null, $callback = null){
        return Arr::first($this->items, ...func_get_args());
    }

    /**
     * Return the last item in the collection that passed a given truth test.
     *
     * @param  mixed  $default
     * @param  Closure $callback
     * @return mixed|null
     */
    public function last($default = null, $callback = null){
        return Arr::last($this->items, ...func_get_args());
    }

    /**
     * Get and delete the first item from the collection.
     *
     * @param mixed|null $default
     * @return mixed|null
     */
    public function shift($default = null){
        if (count($this->items) > 0){
            return array_shift($this->items);
        }
        return $default;
    }

    /**
     * Get and delete the last item from the collection.
     *
     * @param mixed|null $default
     * @return mixed|null
     */
    public function pop($default = null){
        if (count($this->items) > 0){
            return array_pop($this->items);
        }
        return $default;
    }

    /**
     * Get a subset of the items from the given array.
     *
     * @param string|array $keys
     * @return static
     */
    public function only($keys){
        return $this->redeclare(Arr::only($this->items, $keys));
    }

    /**
     * Returns all elements of the collection except the last.
     * Pass the "Number" parameter to exclude more elements from the ending of the collection.
     *
     * @param int $count
     * @return static
     */
    public function initial($count = 1){
        return $this->redeclare(Arr::initial($this->items, $count));
    }

    /**
     * Returns all elements of the collection except the first.
     * Pass the "Number" parameter to exclude more elements from the beginning of the collection.
     *
     * @param int $count
     * @return static
     */
    public function tail($count = 1){
        return $this->redeclare(Arr::tail($this->items, $count));
    }

    /**
     * Retrieve a new collection with the results of calling a provided function
     * on every element in the current collection.
     *
     * @param Closure $callable
     * @param null $context
     * @return static
     */
    public function map(Closure $callable, $context = null){
        return $this->redeclare(Arr::map($this->items, $callable, $context));
    }

    /**
     * Executes a provided function once for each collection  element.
     *
     * @param Closure $callable
     * @param null $context
     * @return $this
     */
    public function each(Closure $callable, $context = null){
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
    public function filter(Closure $callable, $context = null){
        return $this->redeclare(Arr::filter($this->items, $callable, $context));
    }

    /**
     * Removes duplicate values from a collection.
     *
     * @return static
     */
    public function unique(){
        $this->items = Arr::unique($this->items);
        return $this;
    }

    /**
     * Retrieve a new collection with unique elements of all transferred arrays or collections.
     * The order of the elements will be determined by the order of their appearance in the source arrays.
     *
     * @param mixed ...$values
     * @return static
     */
    public function union(...$values){
        foreach ($values as $key => $value){
            $values[$key] = $this->dataFusionController($value);
        }

        $this->items = Arr::union($this->items, ...$values);

        return $this;
    }

    /**
     * Merge the collection with the given items.
     *
     * @param mixed ...$values
     * @return static
     */
    public function merge(...$values){
        foreach ($values as $key => $value){
            $values[$key] = $this->dataFusionController($value);
        }

        $this->items = array_merge($this->items, ...$values);

        return $this;
    }

    /**
     * Returns a new collection containing all the values of the current collection that are missing
     * in all transferred arrays or collections.
     *
     * @param mixed ...$values
     * @return static
     */
    public function diff(...$values){
        foreach ($values as $key => $value){
            $values[$key] = $this->dataFusionController($value);
        }

        return $this->redeclare(Arr::diff($this->items, ...$values));
    }

    /**
     * Returns a new collection containing all the values of the current collection that are present
     * in all transferred arrays or collections.
     *
     * @param mixed ...$values
     * @return static
     */
    public function intersect(...$values){
        foreach ($values as $key => $value){
            $values[$key] = $this->dataFusionController($value);
        }

        return $this->redeclare(Arr::intersect($this->items, ...$values));
    }

    /**
     * Slice the collection.
     *
     * @param $offset
     * @param null $length
     * @return static
     */
    public function slice($offset, $length = null){
        return $this->redeclare(array_slice($this->items, $offset, $length, true));
    }

    /**
     * Reverse items order.
     *
     * @return $this
     */
    public function reverse(){
        $this->items = array_reverse($this->items, true);
        return $this;
    }

    /**
     * Sort through each item with a callback.
     *
     * @param Closure|null $callback
     * @return $this
     */
    public function sort(Closure $callback = null){
        $callback ? uasort($this->items, $callback) : asort($this->items);
        return $this;
    }

    /**
     * Preprocessor of data from which the collection can be created.
     *
     * @param mixed $data
     * @return mixed
     */
    protected function dataCreationController($data){
        return $this->dataFusionController($data);
    }

    /**
     * Preprocessor combining collections with data.
     *
     * @param mixed $data
     * @return mixed
     */
    protected function dataFusionController($data){
        if (is_array($data)) {

            return $data;

        } elseif ($data instanceof self) {

            return $data->all();

        } elseif (is_string($data)) {

            if (Str::isJSON($data, function($source, $decoded) use (&$data){
                $data = is_array($decoded) ? $decoded : [$source];
            })){return $data;}

            if (Str::isSerialize($data, function(...$result) use (&$data){
                $data = Arr::wrap($result[1]);
            })){return $data;}

        }

        return [$data];
    }

    /**
     * Preprocessor adding new items to the collection.
     *
     * @param mixed $item
     * @param string|integer|null $key
     * @return mixed
     */
    protected function dataItemController($item, $key = null){
        return $item;
    }
}