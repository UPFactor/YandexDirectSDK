<?php

namespace YandexDirectSDK\Interfaces;

use YandexDirectSDK\Interfaces\ModelCollection as ModelCollectionInterface;

/**
 * Interface Model
 *
 * @package YandexDirectSDK\Interfaces
 */
interface Model extends ModelCommon
{
    /**
     * Create a new model instance.
     *
     * @param array $properties
     * @return static
     */
    public static function make($properties = null);

    /**
     * Retrieve instance of compatible collection.
     *
     * @return ModelCollectionInterface|null
     */
    public function getCompatibleCollection();

    /**
     * Retrieve model property metadata.
     *
     * @return array
     */
    public function getPropertiesMeta();
}