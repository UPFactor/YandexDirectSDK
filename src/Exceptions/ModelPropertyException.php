<?php

namespace YandexDirectSDK\Exceptions;

use YandexDirectSDK\Components\ModelProperty;
use YandexDirectSDK\Interfaces\ModelCollection as ModelCollectionInterface;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;

class ModelPropertyException extends BaseException
{
    public static function signatureIsEmpty()
    {
        return new static("Inconsistent signature. Property signature is empty.");
    }

    public static function inconsistentTypeInSignature(string $signature, string $type){
        return new static(
            "Inconsistent signature [{$signature}]. " .
            "Unknown type [{$type}].");
    }

    public static function inconsistentObjectTypeInSignature(string $signature)
    {
        return new static(
            "Inconsistent signature [{$signature}]. " .
            "The type [object] requires specifying a single class name that implements " .
            "the [" . ModelCommonInterface::class . "] interface as a permissible value.");
    }

    public static function inconsistentArrayOfObjectTypeInSignature(string $signature)
    {
        return new static(
            "Inconsistent signature [{$signature}]. " .
            "The type [arrayOfObject] requires specifying a single class name that implements " .
            "the [" . ModelCollectionInterface::class . "] interface as a permissible value.");
    }

    public static function inconsistentEnumTypeInSignature(string $signature)
    {
        return new static(
            "Inconsistent signature [{$signature}]. " .
            "The type [enum] or [set] requires specifying a list of permissible values.");
    }

    public static function propertyNotWritable(string $propertyName)
    {
        return new static(ModelProperty::class . "::{$propertyName} not writable.");
    }

    public static function propertyNotExist(string $propertyName)
    {
        return new static(ModelProperty::class . "::{$propertyName} does not exist.");
    }
}