<?php

namespace YandexDirectSDK\Components;

use Exception;
use UPTools\Arr;
use YandexDirectSDK\Exceptions\ModelMethodException;

/**
 * Class ModelMethod
 *
 * @property-read string $name
 * @property-read Service $service
 *
 * @package YandexDirectSDK\Components
 */
class ModelMethod
{
    /**
     * Method name.
     *
     * @var string
     */
    protected $name;

    /**
     * Service provider for the method.
     *
     * @var Service
     */
    protected $service;

    /**
     * ModelMethod constructor.
     *
     * @param string $name
     * @param string $service
     */
    public function __construct(string $name, string $service)
    {
        $this->name = $name;
        $this->service = $service;
    }

    /**
     * Returns a string representation of the current object.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }

    /**
     * Overload object properties.
     *
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        try {
            return $this->{$name};
        } catch (Exception $error){
            throw ModelMethodException::propertyNotExist($name);
        }
    }

    /**
     * Retrieve object hash.
     *
     * @return string
     */
    public function hash()
    {
        return Arr::hash($this->toArray());
    }

    /**
     * Convert object to array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'name' => $this->name,
            'service' => $this->service
        ];
    }

    /**
     * Convert object to JSON.
     *
     * @return string
     */
    public function toJson()
    {
        return Arr::toJson($this->toArray());
    }

    /**
     * Method call.
     *
     * @param mixed ...$arguments
     * @return mixed
     */
    public function call(...$arguments)
    {
        return $this->service::{$this->name}(...$arguments);
    }
}