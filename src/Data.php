<?php

namespace YandexDirectSDK;

use YandexDirectSDK\Common\Arr;

/**
 * Class Data
 *
 * @package YandexDirectSDK
 */
class Data
{
    private $items = [];

    /**
     * Create data instance.
     *
     * @param $data
     * @return static
     */
    public static function wrap($data){
        return new static($data);
    }

    /**
     * Create data instance.
     *
     * @param $data
     */
    public function __construct($data){
        if (is_array($data)) {
            $this->items = $data;
        } elseif ($data instanceof self) {
            $this->items = $data->all();
        } elseif (is_string($data)) {
            if (is_array($value = json_decode($data, true))){
                $this->items =  $value;
            } elseif (is_array($value = @unserialize($data))){
                $this->items =  $value;
            }
        } else {
            $this->items = [$data];
        }
    }

    /**
     * Re-declares the current instance with a new set of elements.
     *
     * @param array $items
     * @return static
     */
    public function redeclare($items){
        return new static($items);
    }

    /**
     * Get all of the items in the dataset.
     *
     * @return array
     */
    public function all(){
        return $this->items;
    }

    /**
     * Count the number of items in the dataset.
     *
     * @return int
     */
    public function count(){
        return count($this->items);
    }

    /**
     * Determine if the dataset is empty.
     *
     * @return bool
     */
    public function isEmpty(){
        return empty($this->items);
    }

    /**
     * Get the keys of the dataset items.
     *
     * @return array
     */
    public function keys(){
        return array_keys($this->items);
    }

    /**
     * Get the values of the dataset items.
     *
     * @return array
     */
    public function values(){
        return array_values($this->items);
    }

    /**
     * Flatten a dataset with dots.
     *
     * @return array
     */
    public function dot(){
        return Arr::dot($this->items);
    }

    /**
     * Returns the serialized representation of a dataset.
     *
     * @return string
     */
    public function serialize(){
        return Arr::serialize($this->items);
    }

    /**
     * Returns the JSON representation of a dataset.
     *
     * @return string
     */
    public function json(){
        return Arr::json($this->items);
    }

    /**
     * Retrieve an element or elements from a dataset using dot notation.
     *
     * @param $keys
     * @param null $default
     * @return static|mixed
     */
    public function get($keys, $default = null){
        $item = Arr::get($this->items, $keys, $default);
        if (is_array($item)){
            return $this->redeclare($item);
        }
        return $item;
    }

    /**
     * Check by key/keys if there is an item/items in the dataset using "dot" notation.
     * Set the parameter [$strict], for additional checking for empty values.
     *
     * @param $keys
     * @param bool $strict
     * @return bool
     */
    public function has($keys, $strict = false){
        return Arr::has($this->items, $keys, $strict);
    }

    /**
     * Get a subset of items from a given dataset.
     *
     * @param $keys
     * @param bool $strict
     * @return static
     */
    public function only($keys, $strict = false){
        return $this->redeclare(Arr::only($this->items, $keys, $strict));
    }

    /**
     * Get a new dataset based on the dataset, excluding items with
     * the specified keys using "dot" notation.
     *
     * @param $keys
     * @return static
     */
    public function except($keys){
        return $this->redeclare(Arr::except($this->items, $keys));
    }

    /**
     * Retrieve a new dataset with the results of calling a provided
     * function on every element in the dataset.
     *
     * @param callable $callable
     * @param null $context
     * @return static
     */
    public function map(callable $callable, $context = null){
        return $this->redeclare(Arr::map($this->items, $callable, $context));
    }

    /**
     * Executes a provided function once for each dataset element.
     *
     * @param callable $callable
     * @param null $context
     * @return $this
     */
    public function each(callable $callable, $context = null){
        Arr::each($this->items, $callable, $context);
        return $this;
    }

    /**
     * Get a new dataset with all elements that pass the test
     * implemented by the provided function.
     *
     * @param callable $callable
     * @param null $context
     * @return static
     */
    public function filter(callable $callable, $context = null){
        return $this->redeclare(Arr::filter($this->items, $callable, $context));
    }

    /**
     * Pluck an dataset from the current dataset by key/keys
     * using "dot" notation.
     *
     * @param $keys
     * @return static
     */
    public function pluck($keys){
        return $this->redeclare(Arr::pluck($this->items, $keys));
    }

    /**
     * Splits a dataset into groups, united by the result of calling the "condition"
     * function for each element. To group by the value of a dataset element,
     * in the "condition" parameter, specify the element key ("dot" notation)
     * for which you want to group.
     *
     * @param $condition
     * @return static
     */
    public function group($condition){
        return $this->redeclare(Arr::group($this->items, $condition));
    }

    /**
     * Chunk the dataset.
     *
     * @param int $size
     * @return static
     */
    public function chunk($size){
        if (!is_numeric($size) or $size < 1){
            return $this->redeclare($this->items);
        }

        return $this->redeclare(array_chunk($this->items, $size, true));
    }

    /**
     * Filter items by the given key value pair using "dot" notation.
     *
     * @see \YandexDirectSDK\Common\Arr::where()
     *
     * @param $key
     * @param null $operator
     * @param null $value
     * @return static
     */
    public function where($key, $operator = null, $value = null){
        return $this->redeclare(Arr::where($this->items, ...func_get_args()));
    }

    /**
     * Get a new dataset of items from the current dataset that are equal
     * to one of the passed values using "dot" notation.
     *
     * @param $key
     * @param $values
     * @param bool $strict
     * @return static
     */
    public function whereIn($key, $values, $strict = false){
        return $this->redeclare(Arr::whereIn($this->items, $key, $values, $strict));
    }

    /**
     * Get the new dataset of items from the current dataset that are not equal
     * to all specified values using the dot notation.
     *
     * @param $key
     * @param $values
     * @param bool $strict
     * @return static
     */
    public function whereNotIn($key, $values, $strict = false){
        return $this->redeclare(Arr::whereNotIn($this->items, $key, $values, $strict));
    }

    /**
     * Find max value in the dataset.
     *
     * @param null $key
     * @return mixed
     */
    public function max($key = null){
        return Arr::max($this->items, $key);
    }

    /**
     * Find min value in the dataset.
     *
     * @param null $key
     * @return mixed
     */
    public function min($key = null){
        return Arr::min($this->items, $key);
    }

    /**
     * Find average value in the dataset.
     *
     * @param null $key
     * @return float|int
     */
    public function avg($key = null){
        return Arr::avg($this->items, $key);
    }

    /**
     * Retrieve sum of values.
     *
     * @param null $key
     * @return float|int
     */
    public function sum($key = null){
        return Arr::sum($this->items, $key);
    }
}