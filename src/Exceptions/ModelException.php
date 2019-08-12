<?php

namespace YandexDirectSDK\Exceptions;

class ModelException extends BaseException
{
    public static function modelPropertyNotWritable(string $modelClass, string $propertyName)
    {
        return new static("{$modelClass}::{$propertyName} not writable.");
    }

    public static function modelPropertyNotReadable(string $modelClass, string $propertyName)
    {
        return new static("{$modelClass}::{$propertyName} not readable.");
    }

    public static function modelPropertyNotExist(string $modelClass, string $propertyName)
    {
        return new static("$modelClass::{$propertyName} does not exist.");
    }

    public static function modelMethodNotExist(string $modelClass, string $methodName)
    {
        return new static("{$modelClass}::{$methodName}() does not exist.");
    }
}