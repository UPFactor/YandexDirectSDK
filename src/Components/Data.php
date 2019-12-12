<?php

namespace YandexDirectSDK\Components;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use UPTools\Arr;
use UPTools\Components\Collection\ArrayAccessTrait;
use UPTools\Components\Collection\BaseTrait;
use UPTools\Components\Collection\ConversionTrait;
use UPTools\Components\Collection\FusionTrait;
use UPTools\Components\Collection\MathsTrait;
use UPTools\Components\Collection\MultipleTrait;
use UPTools\Components\Collection\SetTrait;
use UPTools\Components\Collection\SortingTrait;

class Data implements Countable, IteratorAggregate, ArrayAccess
{
    use BaseTrait,
        ConversionTrait,
        FusionTrait,
        MultipleTrait,
        SetTrait,
        SortingTrait,
        MathsTrait,
        ArrayAccessTrait;

    /**
     * Create a new Data instance.
     *
     * @param mixed $items
     */
    public function __construct($items = []){
        $this->reset($items);
    }

    /**
     * Get an item/items from the collection using "dot" notation.
     *
     * @param string|string[]|int|int[] $keys
     * @param mixed|null $default
     * @return static|null|mixed
     */
    public function get($keys, $default = null){
        $result = Arr::get($this->items, $keys, $default);
        return is_array($result) ? static::wrap($result) : $result;
    }
}