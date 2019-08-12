<?php

namespace YandexDirectSDK\Exceptions;

use YandexDirectSDK\Interfaces\Model as ModelInterface;
use YandexDirectSDK\Interfaces\ModelCollection as ModelCollectionInterface;

class ServiceException extends BaseException
{
    public static function serviceMethodNotExist(string $serviceClass, string $methodName)
    {
        return new static("{$serviceClass}::{$methodName}() does not exist.");
    }

    public static function noIdToBind()
    {
        return new static('Failed bind model. Missing IDs for binding.');
    }

    public static function invalidObjectToBind()
    {
        return new static("Failed bind model. Invalid object type to bind. Expected [" . ModelCollectionInterface::class . "|" . ModelInterface::class . ".");
    }

    public static function modelNotSupportBinding($modelObject)
    {
        return new static("Failed bind model. Model [".static::getValueType($modelObject)."] does not support binding.");
    }

    public static function modelNotSupportMethod($modelObject, string $methodName)
    {
        return new static("Failed method [{$methodName}]. Model [".static::getValueType($modelObject)."] does not support this operation.");
    }

    public static function serviceNotSupportMethod(string $serviceClass, string $methodName)
    {
        return new static("Failed method [{$methodName}]. Model [{$serviceClass}] does not support this operation.");
    }
}