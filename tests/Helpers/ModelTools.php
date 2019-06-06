<?php

namespace YandexDirectSDKTest\Helpers;

use YandexDirectSDK\Components\Model;

class ModelTools extends Model
{
    static $initializationData = [];

    static function create(array $initializationData = []){
        self::$initializationData = $initializationData;
        return new static();
    }

    protected function initialize()
    {
        $initializationData = [
            'compatibleCollection' => ModelCollectionTools::class,
            'serviceProvidersMethods' => [],
            'properties' => [
                'propBoolean' => 'boolean',
                'propFloat' => 'float',
                'propInteger' => 'integer',
                'propString' => 'string',
                'propArray' => 'array:string',
                'propStack' => 'stack:string',
                'propEnum' => 'enum:e1,e2,e3',
                'propSet' => 'set:s1,s2,s3',
                'propArrayOfEnum' => 'arrayOfEnum:e1,e2,e3',
                'propArrayOfSet' => 'arrayOfSet:s1,s2,s3',
                'propObject' => 'object:' . ModelTools::class,
                'propArrayOfObject' => 'arrayOfObject:' . ModelCollectionTools::class
            ]
        ];

        if (is_array(self::$initializationData) or empty(self::$initializationData)){
            $initializationData = array_merge($initializationData, self::$initializationData);
        }

        foreach ($initializationData as $property => $value){
            $this->{$property} = $value;
        }

        self::$initializationData = [];
    }
}