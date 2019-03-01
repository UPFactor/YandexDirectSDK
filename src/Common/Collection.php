<?php

namespace YandexDirectSDK\Common;

/**
 * Class Collection
 *
 * @package Sim\Common
 */
class Collection {

    use CollectionBaseTrait,
        CollectionMultipleTrait,
        CollectionSetTrait,
        CollectionConversionTrait,
        CollectionMathsTrait;

    /**
     * Create a new collection.
     *
     * @param mixed $items
     */
    public function __construct($items = []){
        $this->reset($items);
    }
}