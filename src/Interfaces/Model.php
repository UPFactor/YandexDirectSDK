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
     * Returns the metadata of the declared model properties.
     *
     * @return array
     */
    public static function getPropertiesMeta();

    /**
     * Returns class of compatible collection.
     *
     * @return ModelCollectionInterface|string|null
     */
    public static function getCompatibleCollectionClass();

    /**
     * Retrieve instance of compatible collection.
     *
     * @return ModelCollectionInterface|null
     */
    public static function makeCompatibleCollection();

    /**
     * Setting a value for a model property.
     *
     * @param string $property
     * @param mixed  $value
     * @return $this
     */
    public function setPropertyValue($property, $value);

    /**
     * Getting the value of the model property.
     *
     * @param string $property
     * @return mixed|null
     */
    public function getPropertyValue($property);

    /**
     * Converts the current model to collection
     *
     * @return ModelCollectionInterface
     */
    public function toCollection();
}