<?php

namespace YandexDirectSDK\Exceptions;

use YandexDirectSDK\Components\ServiceBootstrap;
use YandexDirectSDK\Components\ServiceMethodCollection;

class ServiceBootstrapException extends BaseException
{
    protected static function invalidBootstrapComposition($parameter, $expected, $actual)
    {
        new static(
            "Incorrect bootstrap composition for service. " .
            "Parameter [{$parameter}] expects [{$expected}], actual [" . static::getValueType($actual) . "]");
    }

    public static function invalidNameInComposition($actual)
    {
        static::invalidBootstrapComposition('name', 'string', $actual);
    }

    public static function invalidMethodsInComposition($actual)
    {
        static::invalidBootstrapComposition('methods', ServiceMethodCollection::class, $actual);
    }

    public static function invalidModelClassInComposition($actual)
    {
        static::invalidBootstrapComposition('modelClass', 'string', $actual);
    }

    public static function invalidModelCollectionClassInComposition($actual)
    {
        static::invalidBootstrapComposition('modelCollectionClass', 'string', $actual);
    }

    public static function propertyNotExist(string $propertyName)
    {
        return new static(ServiceBootstrap::class . "::{$propertyName} does not exist.");
    }
}