<?php

namespace YandexDirectSDK\Interfaces;

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

    /**
     * Binds the object to a session.
     *
     * @param Session $session
     * @return $this;
     */
    public function setSession(Session $session);

    /**
     * Retrieve the session used by the object.
     *
     * @return null|Session
     */
    public function getSession();

    /**
     * Retrieve metadata of service-providers methods.
     *
     * @return Service[]
     */
    public function getServiceProvidersMethodsMeta();
}