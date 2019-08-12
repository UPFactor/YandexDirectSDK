<?php

namespace YandexDirectSDK\Exceptions;

use YandexDirectSDK\Components\ModelMethodCollection;
use YandexDirectSDK\Components\ModelPropertyCollection;

class ModelBootstrapException extends BaseException
{
    protected static function invalidBootstrapComposition($parameter, $expected, $actual)
    {
        new static(
            "Incorrect bootstrap composition for model. " .
            "Parameter [{$parameter}] expects [{$expected}], actual [" . static::getValueType($actual) . "]");
    }

    public static function invalidNameInComposition($actual)
    {
        static::invalidBootstrapComposition('name', 'string', $actual);
    }

    public static function invalidCompatibilityInComposition($actual)
    {
        static::invalidBootstrapComposition('compatibility', 'string', $actual);
    }

    public static function invalidPropertiesInComposition($actual)
    {
        static::invalidBootstrapComposition('properties', ModelPropertyCollection::class, $actual);
    }

    public static function invalidMethodsInComposition($actual)
    {
        static::invalidBootstrapComposition('methods', ModelMethodCollection::class, $actual);
    }

    public static function invalidStaticMethodsInComposition($actual)
    {
        static::invalidBootstrapComposition('staticMethods', ModelMethodCollection::class, $actual);
    }

    public static function propertyNotExist(string $propertyName)
    {
        return new static(ModelMethodCollection::class . "::{$propertyName} does not exist.");
    }
}