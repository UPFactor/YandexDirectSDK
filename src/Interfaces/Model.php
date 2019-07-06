<?php

namespace YandexDirectSDK\Interfaces;

use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\ModelException;
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
     * Gets an array of model properties.
     *
     * @return array
     */
    public static function getProperties();

    /**
     * Retrieve instance of compatible collection.
     *
     * @return ModelCollectionInterface|null
     */
    public static function getCompatibleCollection();

    /**
     * Setting a value for a model property.
     *
     * @param string $propertyName
     * @param mixed  $value
     * @return $this
     * @throws ModelException
     * @throws InvalidArgumentException
     */
    public function setPropertyValue($propertyName, $value);

    /**
     * Getting the value of the model property.
     *
     * @param string $propertyName
     * @return mixed|null
     * @throws ModelException
     */
    public function getPropertyValue($propertyName);

}