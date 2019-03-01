<?php

namespace YandexDirectSDK\Common;

/**
 * Trait CollectionMathsTrait
 *
 * @see \YandexDirectSDK\Common\CollectionBaseTrait
 * @package Sim\Common
 */
trait CollectionMathsTrait {

    /**
     * Find highest value.
     *
     * @param string|int|null $key
     * @return mixed
     */
    public function max($key = null){
        return Arr::max($this->items, $key);
    }

    /**
     * Find lowest value.
     *
     * @param string|int|null $key
     * @return mixed
     */
    public function min($key = null){
        return Arr::min($this->items, $key);
    }

    /**
     * Find average value.
     *
     * @param string|int|null $key
     * @return float|int
     */
    public function avg($key = null){
        return Arr::avg($this->items, $key);
    }

    /**
     * Retrieve sum of values.
     *
     * @param string|int|null $key
     * @return float|int
     */
    public function sum($key = null){
        return Arr::sum($this->items, $key);
    }

}