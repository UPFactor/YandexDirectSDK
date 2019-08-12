<?php

namespace YandexDirectSDK\Exceptions;

class ModelCollectionException extends BaseException
{
    public static function noCompatibleModel(string $collectionClass)
    {
        return new static("{$collectionClass} cannot be created. No compatible model class specified.");
    }

    public static function modelMethodNotExist(string $collectionClass, string $methodName)
    {
        return new static("{$collectionClass}::{$methodName}() does not exist.");
    }
}