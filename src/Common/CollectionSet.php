<?php

namespace YandexDirectSDK\Common;

/**
 * Class CollectionSet
 *
 * @package Sim\Common
 */
class CollectionSet {

    use CollectionBaseTrait,
        CollectionSetTrait;

    /**
     * Create a new collection.
     *
     * @param mixed $items
     */
    public function __construct($items = []){
        $this->reset($items);
    }
}