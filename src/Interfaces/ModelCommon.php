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
    public static function getClassName():string;

    /**
     * Returns the metadata of the declared methods.
     *
     * @return array
     */
    public static function getMethodsMeta():array;

    /**
     * Returns the metadata of the declared static methods.
     *
     * @return array
     */
    public static function getStaticMethodsMeta():array;

    /**
     * Retrieve copy of the object.
     *
     * @return static
     */
    public function copy();

    /**
     * Retrieve the object hash.
     *
     * @return string
     */
    public function hash():string;

    /**
     * Converter of object.
     *
     * @param int $filter
     * @param bool $jsonMode
     * @return array|object
     */
    public function converter(int $filter, bool $jsonMode = false);

    /**
     * Converts to array.
     *
     * @param int $filter
     * @return array
     */
    public function toArray(int $filter = 0):array;

    /**
     * Converts to a Data object.
     *
     * @param int $filter
     * @return Data
     */
    public function toData(int $filter = 0):Data;

    /**
     * Converts to JSON.
     *
     * @param int $filter
     * @return string
     */
    public function toJson(int $filter = 0):string;
}