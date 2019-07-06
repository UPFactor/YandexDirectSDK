<?php

namespace YandexDirectSDK\Interfaces;

use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Session;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\Data;

/**
 * Interface ModelsCommon
 * @package YandexDirectSDK\Interfaces
 */
interface ModelCommon
{
    /**
     * Returns the short class name.
     *
     * @return string
     */
    public static function getClassName();

    /**
     * Retrieve metadata of service-providers methods.
     *
     * @return Service[]
     */
    public static function getServiceMethods();

    /**
     * Implementing dynamic methods.
     *
     * @param string $method
     * @param Session|null $session
     * @param mixed ...$arguments
     * @return Result
     */
    public function call($method, Session $session = null, ...$arguments);

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
     * @param int $filters
     * @return array
     */
    public function toArray($filters = 0);

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