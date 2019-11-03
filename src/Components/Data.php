<?php

namespace YandexDirectSDK\Components;

use UPTools\Arr;
use UPTools\CollectionBaseTrait;
use UPTools\CollectionConversionTrait;
use UPTools\CollectionFusionTrait;
use UPTools\CollectionMathsTrait;
use UPTools\CollectionMultipleTrait;
use UPTools\CollectionSetTrait;
use UPTools\CollectionSortingTrait;

class Data
{
    use CollectionBaseTrait,
        CollectionSortingTrait,
        CollectionFusionTrait,
        CollectionMultipleTrait,
        CollectionSetTrait,
        CollectionConversionTrait,
        CollectionMathsTrait;

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