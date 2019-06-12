<?php

namespace YandexDirectSDKTest\Helpers;

use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Exceptions\ModelException;

class FakeModel extends Model
{
    static $initializationData = [];

    /**
     * @var Checklists
     */
    protected $checklists;

    /**
     * Create a new model instance.
     *
     * @param array $initializationData
     * @return FakeModel
     */
    static function create(array $initializationData = []){
        self::$initializationData = $initializationData;
        return new static();
    }

    /**
     * Model initialization handler.
     */
    protected function initialize()
    {
        $this->checklists = new Checklists();

        $initializationData = [
            'compatibleCollection' => FakeModelCollectionTools::class,
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
                'propObject' => 'object:' . FakeModel::class,
                'propArrayOfObject' => 'arrayOfObject:' . FakeModelCollectionTools::class
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

    /**
     * Check properties of this model.
     *
     * @param array $expectedProperties
     * @throws ModelException
     */
    public function check(array $expectedProperties){
        $this->checklists->checkModel($this, $expectedProperties);
    }
}