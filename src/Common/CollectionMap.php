<?php

namespace YandexDirectSDK\Common;

/**
 * Class CollectionMap
 *
 * @package Sim\Common
 */
class CollectionMap {

    use CollectionBaseTrait,
        CollectionMapTrait;

    /**
     * Create a new collection.
     *
     * @param mixed $items
     */
    public function __construct($items = []){
        $this->reset($items);
    }
}