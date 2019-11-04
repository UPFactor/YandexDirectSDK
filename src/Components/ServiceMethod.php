<?php

namespace YandexDirectSDK\Components;

use Exception;
use UPTools\Arr;
use YandexDirectSDK\Exceptions\ServiceMethodException;

/**
 * Class ServiceMethod
 *
 * @property-read string $name
 * @property-read string $service
 * @property-read string $method
 * @property-read string $handler
 *
 * @package YandexDirectSDK\Components
 */
class ServiceMethod
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
     * API Method.
     *
     * @var string
     */
    protected $method;

    /**
     * Method handler name.
     *
     * @var string
     */
    protected $handler;

    /**
     * ServiceMethod constructor.
     *
     * @param string $name
     * @param string $service
     * @param string $signature
     */
    public function __construct(string $name, string $service, string $signature)
    {
        if (empty($signature)){
            throw ServiceMethodException::signatureIsEmpty();
        }

        $signature = explode(':', $signature, 2);

        $this->name = $name;
        $this->service = $service;
        $this->method = trim($signature[0]);
        $this->handler = trim($signature[1] ?? '');

        if (empty($this->handler)){
            throw ServiceMethodException::handlerIsEmpty();
        }
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
            throw ServiceMethodException::propertyNotExist($name);
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
            'service' => $this->service,
            'method' => $this->method,
            'handler' => $this->handler
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
        return (function($method, $handler, $arguments){
            return static::{$handler}($method, ...$arguments);
        })->bindTo(null, $this->service)($this->method, $this->handler, $arguments);
    }
}