<?php

namespace YandexDirectSDK\Exceptions;

use YandexDirectSDK\Components\ModelMethodCollection;
use YandexDirectSDK\Components\ModelPropertyCollection;
use YandexDirectSDK\Components\ServiceMethodCollection;

class InvalidArgumentException extends BaseException
{
    /*
    |--------------------------------------------------------------------------
    | Base
    |--------------------------------------------------------------------------
    */

    /**
     * @param string $function
     * @param string $argument
     * @param array|string|null $expected
     * @param string|null $actual
     * @return static
     */
    public static function invalidType($function, $argument = null, $expected = null, string $actual = null){
        if (is_null($argument)){
            $message = "{$function}. Invalid type of argument.";
        } else {
            $message = "{$function}. Invalid type of argument [$argument].";
        }

        if (!is_null($expected)){
            $expected = is_array($expected) ? implode('|', $expected) : strval($expected);
            $actual = is_null($actual) ? '' : strval($actual);
            $message = "{$message} Expects [{$expected}], actual [{$actual}].";
        }

        return new static($message);
    }

    /*
    |--------------------------------------------------------------------------
    | Service
    |--------------------------------------------------------------------------
    */

    public static function serviceMethod(string $serviceClass, string $methodName, string $expects)
    {
        return new static("{$serviceClass}::{$methodName}. Invalid argument type. Expects {$expects}");
    }

    /*
    |--------------------------------------------------------------------------
    | Model
    |--------------------------------------------------------------------------
    */

    public static function modelPropertyValue(string $modelClass, string $propertyName, string $expectedType, array $permissibleValues, $actual)
    {
        switch ($expectedType){
            case 'boolean':
                $expects = $expectedType;
                break;
            case 'string':
            case 'double':
            case 'integer':
                if (empty($permissibleValues)) $expects = $expectedType;
                else $expects = $expectedType . ' from list [' . implode(',', $permissibleValues) . ']';
                break;
            case 'array':
                if (empty($permissibleValues)) $expects = 'array';
                else $expects = 'array of [' . implode(',', $permissibleValues) . ']';
                break;
            case 'mixed':
            case 'enum':
                $expects = 'value from list [' . implode(',', $permissibleValues) . ']';
                break;
            case 'set':
                $expects = '[array] from list of values [' . implode(',', $permissibleValues) . ']';
                break;
            case 'object':
                $expects = '[' . implode('|', $permissibleValues) . ']';
                break;
            default: $expects = '[]';
        }

        return new static("{$modelClass}::{$propertyName}. Invalid model property type. Expects {$expects}, actual [" . static::getValueType($actual) . "].");
    }

    public static function modelInsert($modelClass, $expected, $actual)
    {
        return new static ("{$modelClass}. Invalid data type to insert into model. Expects [{$expected}], actual [" . static::getValueType($actual) . "].");
    }

    public static function modelArrayInsert($modelClass, $key, $expected, $actual)
    {
        $key = is_array($key) ? implode('][', $key) : $key;
        return new static ("{$modelClass}. Invalid data[{$key}] type to insert into model. Expects [{$expected}], actual [" . static::getValueType($actual) . "].");
    }

    /*
    |--------------------------------------------------------------------------
    | ModelCollection
    |--------------------------------------------------------------------------
    */

    public static function modelCollectionItem($collectionClass, $expected, $actual)
    {
        return new static($collectionClass . ". Invalid model collection item. Expects [{$expected}], actual [" . static::getValueType($actual) . "].");
    }

    public static function modelCollectionKey($collectionClass, $expected, $actual)
    {
        return new static($collectionClass . ". Invalid model collection key. Expects [{$expected}], actual [" . static::getValueType($actual) . "].");
    }

    public static function modelCollectionMerge($collectionClass, $expected, $actual)
    {
        return new static ($collectionClass . ". Invalid model collection merge. Expects [{$expected}], actual [" . static::getValueType($actual) . "].");
    }

    public static function modelCollectionInsert($collectionClass, $expected, $actual)
    {
        return new static ($collectionClass . ". Invalid data type to insert into collection. Expects [{$expected}], actual [" . static::getValueType($actual) . "].");
    }

    /*
    |--------------------------------------------------------------------------
    | ModelPropertyCollection
    |--------------------------------------------------------------------------
    */

    public static function modelPropertyCollectionItem($expected, $actual)
    {
        return new static(ModelPropertyCollection::class . ". Invalid model property collection item. Expects [{$expected}], actual [" . static::getValueType($actual) . "].");
    }

    public static function modelPropertyCollectionMerge($expected, $actual)
    {
        return new static (ModelPropertyCollection::class . ". Invalid model property collection merge. Expects [{$expected}], actual [" . static::getValueType($actual) . "].");
    }

    /*
    |--------------------------------------------------------------------------
    | ModelMethodCollection
    |--------------------------------------------------------------------------
    */

    public static function modelMethodCollectionItem($expected, $actual)
    {
        return new static(ModelMethodCollection::class . ". Invalid model method collection item. Expects [{$expected}], actual [" . static::getValueType($actual) . "].");
    }

    public static function modelMethodCollectionMerge($expected, $actual)
    {
        return new static (ModelMethodCollection::class . ". Invalid model method collection merge. Expects [{$expected}], actual [" . static::getValueType($actual) . "].");
    }

    /*
    |--------------------------------------------------------------------------
    | ServiceMethodCollection
    |--------------------------------------------------------------------------
    */

    public static function serviceMethodCollectionItem($expected, $actual)
    {
        return new static(ServiceMethodCollection::class . ". Invalid service method collection item. Expects [{$expected}], actual [" . static::getValueType($actual) . "].");
    }

    public static function serviceMethodCollectionMerge($expected, $actual)
    {
        return new static (ServiceMethodCollection::class . ". Invalid service method collection merge. Expects [{$expected}], actual [" . static::getValueType($actual) . "].");
    }

}