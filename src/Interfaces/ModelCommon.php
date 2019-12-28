<?php

namespace YandexDirectSDK\Interfaces;

use YandexDirectSDK\Components\Data;

/**
 * Interface ModelsCommon
 * @package YandexDirectSDK\Interfaces
 */
interface ModelCommon
{
    /**
     * Returns object name.
     *
     * @return string
     */
    public static function getClassName();

    /**
     * Returns the metadata of the declared methods.
     *
     * @return array
     */
    public static function getMethodsMeta();

    /**
     * Returns the metadata of the declared static methods.
     *
     * @return array
     */
    public static function getStaticMethodsMeta();

    /**
     * Retrieve copy of the object.
     *
     * @return static
     */
    public function copy();

    /**
     * Retrieve the object hash
     *
     * @return string
     */
    public function hash();

    /**
     * Converts to array.
     *
     * @param int $filter
     * @return array
     */
    public function toArray($filter = 0);

    /**
     * Converts to a Data object.
     *
     * @param int $filter
     * @return Data
     */
    public function toData($filter = 0);

    /**
     * Converts to JSON.
     *
     * @param int $filter
     * @return string
     */
    public function toJson($filter = 0);
}