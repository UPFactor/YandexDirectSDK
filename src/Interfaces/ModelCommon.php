<?php

namespace YandexDirectSDK\Interfaces;

use YandexDirectSDK\Components\Data;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Interfaces\ModelCollection as ModelCollectionInterface;

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
     * @return Service[]
     */
    public static function getMethodsMeta();

    /**
     * Returns the metadata of the declared static methods.
     *
     * @return Service[]
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
     * @param int $filters
     * @return Data
     */
    public function toData($filters = 0);

    /**
     * Converts to JSON.
     *
     * @param int $filters
     * @return string
     */
    public function toJson($filters = 0);

    /**
     * Insert data into the object.
     *
     * @param Data|array $source
     * @return $this
     */
    public function insert($source);
}