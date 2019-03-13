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
     * Retrieve a shallow copy of the object.
     *
     * @return static
     */
    public function copy();

    /**
     * Get the object as a plain array.
     *
     * @return array
     */
    public function unwrap();

    /**
     * Converts to array.
     *
     * @return array
     */
    public function toArray();

    /**
     * Converts to JSON.
     *
     * @return string
     */
    public function toJson();

    /**
     * Sufficiency checking.
     *
     * @return $this
     */
    public function check();

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