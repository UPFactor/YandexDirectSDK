<?php

namespace YandexDirectSDK\Exceptions;

use YandexDirectSDK\Components\ModelMethod;

class ModelMethodException extends BaseException
{
    public static function propertyNotExist(string $propertyName)
    {
        return new static(ModelMethod::class . "::{$propertyName} does not exist.");
    }
}