<?php

namespace YandexDirectSDK\Exceptions;

use YandexDirectSDK\Components\ServiceMethod;

class ServiceMethodException extends BaseException
{
    public static function signatureIsEmpty()
    {
        return new static("Inconsistent signature. Signature is empty.");
    }

    public static function handlerIsEmpty()
    {
        return new static("Inconsistent signature. Method handler not found.");
    }

    public static function propertyNotExist(string $methodName)
    {
        return new static(ServiceMethod::class . "::{$methodName} does not exist.");
    }
}