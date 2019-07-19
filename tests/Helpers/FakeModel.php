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
     * @return void
     */
    protected function initialize()
    {
        $initializationData = [
            'compatibleCollection' => FakeModelCollectionTools::class,
            'serviceMethods' => [],
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
            ],
            'nonWritableProperties' => [],
            'nonReadableProperties' => [],
            'nonUpdatableProperties' => [],
            'nonAddableProperties' => []
        ];

        if (is_array(self::$initializationData) or empty(self::$initializationData)){
            foreach (self::$initializationData as $property => $value){
                if (array_key_exists($property, $initializationData)){
                    $initializationData[$property] = $value;
                }
            }
        }

        static::$compatibleCollection = $initializationData['compatibleCollection'];
        static::$methods = $initializationData['serviceMethods'];
        static::$properties = $initializationData['properties'];
        static::$nonWritableProperties = $initializationData['nonWritableProperties'];
        static::$nonReadableProperties = $initializationData['nonReadableProperties'];
        static::$nonUpdatableProperties = $initializationData['nonUpdatableProperties'];
        static::$nonAddableProperties = $initializationData['nonAddableProperties'];

        if (array_key_exists(static::class, self::$boot)){
            unset(self::$boot[static::class]);
        }

        $this->modelProperties = self::bootstrap()['properties'];
        self::$initializationData = [];

        $this->checklists = new Checklists();
    }

    /**
     * Check properties of this model.
     *
     * @param array $expectedProperties
     */
    public function check(array $expectedProperties)
    {
        $this->checklists->checkModel($this, $expectedProperties);
    }
}