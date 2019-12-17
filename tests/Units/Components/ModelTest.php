<?php

namespace YandexDirectSDKTest\Unit\Components;

use PHPUnit\Framework\TestCase;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\ModelException;
use YandexDirectSDK\Interfaces\Model as ModelInterface;
use YandexDirectSDK\Interfaces\ModelCollection as ModelCollectionInterface;
use YandexDirectSDKTest\Helpers\Env;

class ModelTest extends TestCase
{
    /*
    |--------------------------------------------------------------------------
    | Data providers
    |--------------------------------------------------------------------------
    */

    /**
     * @return array
     */
    public function insertDataProvider(): array
    {

        $childModelClass = Env::setUpModel('TestInsertChildrenModel',[
            'properties' => [
                'i' => 'integer',
                's' => 'string',
                'f' => 'float',
                'b' => 'boolean'
            ]
        ]);
        $childCollectionClass = Env::setUpModelCollection('TestInsertChildrenCollection', ['compatibleModel' => $childModelClass]);

        return [
            'boolean 1' => ['boolean',              true,                       true],
            'boolean 2' => ['boolean',              'true',                     true],
            'boolean 3' => ['boolean',              1,                          true],
            'boolean 4' => ['boolean',              '1',                        true],
            'boolean 5' => ['boolean',              false,                      false],
            'boolean 6' => ['boolean',              'false',                    false],
            'boolean 7' => ['boolean',              0,                          false],
            'boolean 8' => ['boolean',              '0',                        false],
            'boolean 9' => ['boolean',              null,                       null],
            'boolean 10' => ['boolean',             'string',                   null],
            'boolean 11' => ['boolean',             123,                        null],
            'boolean 12' => ['boolean',             [1,2,3],                    null],
            'boolean 13' => ['boolean',             ['Items' => [1,2,3]],       null],

            'string 1' => ['string',                true,                       '1'],
            'string 2' => ['string',                false,                      ''],
            'string 3' => ['string',                null,                       null],
            'string 4' => ['string',                'string',                   'string'],
            'string 5' => ['string',                123,                        '123'],
            'string 6' => ['string',                0,                          '0'],
            'string 7' => ['string',                [1,2,3],                    null],
            'string 8' => ['string',                ['Items' => [1,2,3]],       null],

            'float 1' => ['float',                  true,                       null],
            'float 2' => ['float',                  false,                      null],
            'float 3' => ['float',                  null,                       null],
            'float 4' => ['float',                  'string',                   null],
            'float 5' => ['float',                  123,                        123.0],
            'float 6' => ['float',                  0,                          0.0],
            'float 7' => ['float',                  2.2,                        2.2],
            'float 8' => ['float',                  [1,2,3],                    null],
            'float 9' => ['float',                  ['Items' => [1,2,3]],       null],

            'integer 1' => ['integer',              true,                       null],
            'integer 2' => ['integer',              false,                      null],
            'integer 3' => ['integer',              null,                       null],
            'integer 4' => ['integer',              'string',                   null],
            'integer 5' => ['integer',              123,                        123],
            'integer 6' => ['integer',              0,                          0],
            'integer 7' => ['integer',              2.2,                        2],
            'integer 8' => ['integer',              [1,2,3],                    null],
            'integer 9' => ['integer',              ['Items' => [1,2,3]],       null],

            'array:string 1' => ['array:string',    true,                       null],
            'array:string 2' => ['array:string',    false,                      null],
            'array:string 3' => ['array:string',    null,                       null],
            'array:string 4' => ['array:string',    'string',                   null],
            'array:string 5' => ['array:string',    123,                        null],
            'array:string 6' => ['array:string',    [1,2,3],                    null],
            'array:string 7' => ['array:string',    ['1','2','3'],              null],
            'array:string 8' => ['array:string',    ['Items' => ['1','2']],     ['1','2']],
            'array:string 9' => ['array:string',    ['Items' => [1,2,3]],       null],

            'stack:string 1' => ['stack:string',    true,                       null],
            'stack:string 2' => ['stack:string',    false,                      null],
            'stack:string 3' => ['stack:string',    null,                       null],
            'stack:string 4' => ['stack:string',    'string',                   null],
            'stack:string 5' => ['stack:string',    123,                        null],
            'stack:string 6' => ['stack:string',    [1,2,3],                    null],
            'stack:string 7' => ['stack:string',    ['1','2','3'],              ['1','2','3']],
            'stack:string 8' => ['stack:string',    ['Items' => [1,2,3]],       null],
            'stack:string 9' => ['stack:array',     ['key' => [1,2,3]],         ['key' => [1,2,3]]],

            'enum 1' => ['enum:a,b',                'a',                        'a'],
            'enum 2' => ['enum:a,b',                'b',                        'b'],
            'enum 3' => ['enum:a,b',                true,                       null],
            'enum 4' => ['enum:a,b',                false,                      null],
            'enum 5' => ['enum:a,b',                null,                       null],
            'enum 6' => ['enum:a,b',                'string',                   null],
            'enum 7' => ['enum:a,b',                123,                        null],
            'enum 8' => ['enum:a,b',                0,                          null],
            'enum 9' => ['enum:a,b',                [1,2,3],                    null],
            'enum 10' => ['enum:a,b',               ['Items' => [1,2,3]],       null],

            'set 1' => ['set:a,b',                  ['a','b'],                  ['a','b']],
            'set 2' => ['set:a,b',                  ['a'],                      ['a']],
            'set 3' => ['set:a,b',                  ['b'],                      ['b']],
            'set 4' => ['set:a,b',                  true,                       null],
            'set 5' => ['set:a,b',                  false,                      null],
            'set 6' => ['set:a,b',                  null,                       null],
            'set 7' => ['set:a,b',                  'string',                   null],
            'set 8' => ['set:a,b',                  123,                        null],
            'set 9' => ['set:a,b',                  [1,2,3],                    null],
            'set 10' => ['set:a,b',                 ['Items' => [1,2,3]],       null],
            'set 11' => ['set:a,b',                 ['Items' => ['a']],         null],
            'set 12' => ['set:a,b',                 ['Items' => ['b']],         null],
            'set 13' => ['set:a,b',                 ['Items' => ['a','b']],     null],

            'arrayOfEnum 1' => ['arrayOfEnum:a,b',  ['a','b'],                  null],
            'arrayOfEnum 2' => ['arrayOfEnum:a,b',  ['a'],                      null],
            'arrayOfEnum 3' => ['arrayOfEnum:a,b',  ['b'],                      null],
            'arrayOfEnum 4' => ['arrayOfEnum:a,b',  true,                       null],
            'arrayOfEnum 5' => ['arrayOfEnum:a,b',  false,                      null],
            'arrayOfEnum 6' => ['arrayOfEnum:a,b',  null,                       null],
            'arrayOfEnum 7' => ['arrayOfEnum:a,b',  'string',                   null],
            'arrayOfEnum 8' => ['arrayOfEnum:a,b',  123,                        null],
            'arrayOfEnum 9' => ['arrayOfEnum:a,b',  [1,2,3],                    null],
            'arrayOfEnum 10' => ['arrayOfEnum:a,b', ['Items' => [1,2,3]],       null],
            'arrayOfEnum 11' => ['arrayOfEnum:a,b', ['Items' => ['a']],         ['a']],
            'arrayOfEnum 12' => ['arrayOfEnum:a,b', ['Items' => ['b']],         ['b']],
            'arrayOfEnum 13' => ['arrayOfEnum:a,b', ['Items' => ['a','b']],     ['a','b']],
            'arrayOfEnum 14' => ['arrayOfEnum:a,b', ['Items' => ['a','b','c']], null],

            'arrayOfSet 1' => ['arrayOfSet:a,b',    ['a','b'],                  null],
            'arrayOfSet 2' => ['arrayOfSet:a,b',    ['a'],                      null],
            'arrayOfSet 3' => ['arrayOfSet:a,b',    ['b'],                      null],
            'arrayOfSet 4' => ['arrayOfSet:a,b',    true,                       null],
            'arrayOfSet 5' => ['arrayOfSet:a,b',    false,                      null],
            'arrayOfSet 6' => ['arrayOfSet:a,b',    null,                       null],
            'arrayOfSet 7' => ['arrayOfSet:a,b',    'string',                   null],
            'arrayOfSet 8' => ['arrayOfSet:a,b',    123,                        null],
            'arrayOfSet 9' => ['arrayOfSet:a,b',    [1,2,3],                    null],
            'arrayOfSet 10' => ['arrayOfSet:a,b',   ['Items' => [1,2,3]],       null],
            'arrayOfSet 11' => ['arrayOfSet:a,b',   ['Items' => ['a']],         ['a']],
            'arrayOfSet 12' => ['arrayOfSet:a,b',   ['Items' => ['b']],         ['b']],
            'arrayOfSet 13' => ['arrayOfSet:a,b',   ['Items' => ['a','b']],     ['a','b']],
            'arrayOfSet 14' => ['arrayOfSet:a,b',   ['Items' => ['a','b','c']], null],

            'object 1' => ['object:'.$childModelClass,              true,                                   null,   InvalidArgumentException::class],
            'object 2' => ['object:'.$childModelClass,              false,                                  null,   InvalidArgumentException::class],
            'object 3' => ['object:'.$childModelClass,              null,                                   null],
            'object 4' => ['object:'.$childModelClass,              'string',                               null,   InvalidArgumentException::class],
            'object 5' => ['object:'.$childModelClass,              123,                                    null,   InvalidArgumentException::class],
            'object 6' => ['object:'.$childModelClass,              ['i'=>'12','s'=>'text'],                ['I'=>12, 'S'=>'text']],
            'object 7' => ['object:'.$childModelClass,              ['miss'=>'text'],                       []],
            'object 8' => ['object:'.$childModelClass,              [],                                     []],

            'collection 1' => ['object:'.$childCollectionClass,             true,                                       null,   InvalidArgumentException::class],
            'collection 2' => ['object:'.$childCollectionClass,             false,                                      null,   InvalidArgumentException::class],
            'collection 3' => ['object:'.$childCollectionClass,             null,                                       null],
            'collection 4' => ['object:'.$childCollectionClass,             'string',                                   null,   InvalidArgumentException::class],
            'collection 5' => ['object:'.$childCollectionClass,             123,                                        null,   InvalidArgumentException::class],
            'collection 6' => ['object:'.$childCollectionClass,             [1,2,3],                                    null,   InvalidArgumentException::class],
            'collection 7' => ['object:'.$childCollectionClass,             [['i'=>'12'],['s'=>'text']],                [['I'=>12], ['S'=>'text']]],
            'collection 8' => ['object:'.$childCollectionClass,             [['i'=>'12'],['miss'=>'text']],             [['I'=>12], []]],
            'collection 9' => ['object:'.$childCollectionClass,             [],                                         []],
            'collection 10' => ['object:'.$childCollectionClass,            ['str_key' => ['i'=>'12']],                 null,   InvalidArgumentException::class],
            'collection 11' => ['arrayOfObject:'.$childCollectionClass,     [['i'=>'12'],['s'=>'text']],                null],
            'collection 12' => ['arrayOfObject:'.$childCollectionClass,     ['Items' => [['i'=>'12'],['s'=>'text']]],   [['I'=>12], ['S'=>'text']]]
        ];
    }

    /**
     * @return array
     */
    public function convertingDataProvider(): array
    {

        $childModelClass = Env::setUpModel('TestConvertingChildrenModel', [
            'properties' => [
                'i' => 'integer',
                's' => 'string',
                'f' => 'float',
                'b' => 'boolean'
            ]
        ]);

        $childCollectionClass = Env::setUpModelCollection('TestConvertingChildrenCollection', [
            'compatibleModel' => $childModelClass
        ]);

        return [
            'boolean 1' => ['boolean',              true,                       true],
            'boolean 2' => ['boolean',              'true',                     true],
            'boolean 3' => ['boolean',              1,                          true],
            'boolean 4' => ['boolean',              '1',                        true],
            'boolean 5' => ['boolean',              false,                      false],
            'boolean 6' => ['boolean',              'false',                    false],
            'boolean 7' => ['boolean',              0,                          false],
            'boolean 8' => ['boolean',              '0',                        false],
            'boolean 9' => ['boolean',              null,                       null],
            'boolean 10' => ['boolean',             'string',                   null],
            'boolean 11' => ['boolean',             123,                        null],
            'boolean 12' => ['boolean',             [1,2,3],                    null],
            'boolean 13' => ['boolean',             ['Items' => [1,2,3]],       null],

            'string 1' => ['string',                true,                       '1'],
            'string 2' => ['string',                false,                      ''],
            'string 3' => ['string',                null,                       null],
            'string 4' => ['string',                'string',                   'string'],
            'string 5' => ['string',                123,                        '123'],
            'string 6' => ['string',                0,                          '0'],
            'string 7' => ['string',                [1,2,3],                    null],
            'string 8' => ['string',                ['Items' => [1,2,3]],       null],

            'float 1' => ['float',                  true,                       null],
            'float 2' => ['float',                  false,                      null],
            'float 3' => ['float',                  null,                       null],
            'float 4' => ['float',                  'string',                   null],
            'float 5' => ['float',                  123,                        123.0],
            'float 6' => ['float',                  0,                          0.0],
            'float 7' => ['float',                  2.2,                        2.2],
            'float 8' => ['float',                  [1,2,3],                    null],
            'float 9' => ['float',                  ['Items' => [1,2,3]],       null],

            'integer 1' => ['integer',              true,                       null],
            'integer 2' => ['integer',              false,                      null],
            'integer 3' => ['integer',              null,                       null],
            'integer 4' => ['integer',              'string',                   null],
            'integer 5' => ['integer',              123,                        123],
            'integer 6' => ['integer',              0,                          0],
            'integer 7' => ['integer',              2.2,                        2],
            'integer 8' => ['integer',              [1,2,3],                    null],
            'integer 9' => ['integer',              ['Items' => [1,2,3]],       null],

            'array:string 1' => ['array:string',    true,                       null],
            'array:string 2' => ['array:string',    false,                      null],
            'array:string 3' => ['array:string',    null,                       null],
            'array:string 4' => ['array:string',    'string',                   null],
            'array:string 5' => ['array:string',    123,                        null],
            'array:string 6' => ['array:string',    [1,2,3],                    null],
            'array:string 7' => ['array:string',    ['1','2','3'],              null],
            'array:string 8' => ['array:string',    ['Items' => ['1','2']],     ['Items' => ['1','2']]],
            'array:string 9' => ['array:string',    ['Items' => [1,2,3]],       null],

            'stack:string 1' => ['stack:string',    true,                       null],
            'stack:string 2' => ['stack:string',    false,                      null],
            'stack:string 3' => ['stack:string',    null,                       null],
            'stack:string 4' => ['stack:string',    'string',                   null],
            'stack:string 5' => ['stack:string',    123,                        null],
            'stack:string 6' => ['stack:string',    [1,2,3],                    null],
            'stack:string 7' => ['stack:string',    ['1','2','3'],              ['1','2','3']],
            'stack:string 8' => ['stack:string',    ['Items' => [1,2,3]],       null],
            'stack:string 9' => ['stack:array',     ['key' => [1,2,3]],         ['key' => [1,2,3]]],

            'enum 1' => ['enum:a,b',                'a',                        'a'],
            'enum 2' => ['enum:a,b',                'b',                        'b'],
            'enum 3' => ['enum:a,b',                true,                       null],
            'enum 4' => ['enum:a,b',                false,                      null],
            'enum 5' => ['enum:a,b',                null,                       null],
            'enum 6' => ['enum:a,b',                'string',                   null],
            'enum 7' => ['enum:a,b',                123,                        null],
            'enum 8' => ['enum:a,b',                0,                          null],
            'enum 9' => ['enum:a,b',                [1,2,3],                    null],
            'enum 10' => ['enum:a,b',               ['Items' => [1,2,3]],       null],

            'set 1' => ['set:a,b',                  ['a','b'],                  ['a','b']],
            'set 2' => ['set:a,b',                  ['a'],                      ['a']],
            'set 3' => ['set:a,b',                  ['b'],                      ['b']],
            'set 4' => ['set:a,b',                  true,                       null],
            'set 5' => ['set:a,b',                  false,                      null],
            'set 6' => ['set:a,b',                  null,                       null],
            'set 7' => ['set:a,b',                  'string',                   null],
            'set 8' => ['set:a,b',                  123,                        null],
            'set 9' => ['set:a,b',                  [1,2,3],                    null],
            'set 10' => ['set:a,b',                 ['Items' => [1,2,3]],       null],
            'set 11' => ['set:a,b',                 ['Items' => ['a']],         null],
            'set 12' => ['set:a,b',                 ['Items' => ['b']],         null],
            'set 13' => ['set:a,b',                 ['Items' => ['a','b']],     null],

            'arrayOfEnum 1' => ['arrayOfEnum:a,b',  ['a','b'],                  null],
            'arrayOfEnum 2' => ['arrayOfEnum:a,b',  ['a'],                      null],
            'arrayOfEnum 3' => ['arrayOfEnum:a,b',  ['b'],                      null],
            'arrayOfEnum 4' => ['arrayOfEnum:a,b',  true,                       null],
            'arrayOfEnum 5' => ['arrayOfEnum:a,b',  false,                      null],
            'arrayOfEnum 6' => ['arrayOfEnum:a,b',  null,                       null],
            'arrayOfEnum 7' => ['arrayOfEnum:a,b',  'string',                   null],
            'arrayOfEnum 8' => ['arrayOfEnum:a,b',  123,                        null],
            'arrayOfEnum 9' => ['arrayOfEnum:a,b',  [1,2,3],                    null],
            'arrayOfEnum 10' => ['arrayOfEnum:a,b', ['Items' => [1,2,3]],       null],
            'arrayOfEnum 11' => ['arrayOfEnum:a,b', ['Items' => ['a']],         ['Items' => ['a']]],
            'arrayOfEnum 12' => ['arrayOfEnum:a,b', ['Items' => ['b']],         ['Items' => ['b']]],
            'arrayOfEnum 13' => ['arrayOfEnum:a,b', ['Items' => ['a','b']],     ['Items' => ['a','b']]],
            'arrayOfEnum 14' => ['arrayOfEnum:a,b', ['Items' => ['a','b','c']], null],

            'arrayOfSet 1' => ['arrayOfSet:a,b',    ['a','b'],                  null],
            'arrayOfSet 2' => ['arrayOfSet:a,b',    ['a'],                      null],
            'arrayOfSet 3' => ['arrayOfSet:a,b',    ['b'],                      null],
            'arrayOfSet 4' => ['arrayOfSet:a,b',    true,                       null],
            'arrayOfSet 5' => ['arrayOfSet:a,b',    false,                      null],
            'arrayOfSet 6' => ['arrayOfSet:a,b',    null,                       null],
            'arrayOfSet 7' => ['arrayOfSet:a,b',    'string',                   null],
            'arrayOfSet 8' => ['arrayOfSet:a,b',    123,                        null],
            'arrayOfSet 9' => ['arrayOfSet:a,b',    [1,2,3],                    null],
            'arrayOfSet 10' => ['arrayOfSet:a,b',   ['Items' => [1,2,3]],       null],
            'arrayOfSet 11' => ['arrayOfSet:a,b',   ['Items' => ['a']],         ['Items' => ['a']]],
            'arrayOfSet 12' => ['arrayOfSet:a,b',   ['Items' => ['b']],         ['Items' => ['b']]],
            'arrayOfSet 13' => ['arrayOfSet:a,b',   ['Items' => ['a','b']],     ['Items' => ['a','b']]],
            'arrayOfSet 14' => ['arrayOfSet:a,b',   ['Items' => ['a','b','c']], null],

            'object 1' => ['object:'.$childModelClass,          true,                                   null,   InvalidArgumentException::class],
            'object 2' => ['object:'.$childModelClass,          false,                                  null,   InvalidArgumentException::class],
            'object 3' => ['object:'.$childModelClass,          null,                                   null],
            'object 4' => ['object:'.$childModelClass,          'string',                               null,   InvalidArgumentException::class],
            'object 5' => ['object:'.$childModelClass,          123,                                    null,   InvalidArgumentException::class],
            'object 6' => ['object:'.$childModelClass,          [],                                     null],
            'object 7' => ['object:'.$childModelClass,          ['miss'=>'text'],                       null],
            'object 8' => ['object:'.$childModelClass,          ['i'=>'12','s'=>'text'],                ['I'=>12, 'S'=>'text']],

            'collection 1' => ['object:'.$childCollectionClass,             true,                                       null,   InvalidArgumentException::class],
            'collection 2' => ['object:'.$childCollectionClass,             false,                                      null,   InvalidArgumentException::class],
            'collection 3' => ['object:'.$childCollectionClass,             null,                                       null],
            'collection 4' => ['object:'.$childCollectionClass,             'string',                                   null,   InvalidArgumentException::class],
            'collection 5' => ['object:'.$childCollectionClass,             123,                                        null,   InvalidArgumentException::class],
            'collection 6' => ['object:'.$childCollectionClass,             [1,2,3],                                    null,   InvalidArgumentException::class],
            'collection 7' => ['object:'.$childCollectionClass,             [['i'=>'12'],['s'=>'text']],                [['I'=>12], ['S'=>'text']]],
            'collection 8' => ['object:'.$childCollectionClass,             [['i'=>'12'],['miss'=>'text']],             [['I'=>12], []]],
            'collection 9' => ['object:'.$childCollectionClass,             [],                                         []],
            'collection 10' => ['object:'.$childCollectionClass,            ['str_key' => ['i'=>'12']],                 null,   InvalidArgumentException::class],
            'collection 11' => ['arrayOfObject:'.$childCollectionClass,     [['i'=>'12'],['s'=>'text']],                null],
            'collection 12' => ['arrayOfObject:'.$childCollectionClass,     ['Items' => [['i'=>'12'],['s'=>'text']]],  ['Items' => [['I'=>12], ['S'=>'text']]]]
        ];
    }

    /**
     * @return array
     */
    public static function modelDataProvider(): array
    {
        $model = Env::setUpModel('TestNonAddableProperties', [
            'properties' => [
                'nonAddable' => 'string',
                'nonUpdatable' => 'string',
                'nonReadable' => 'string',
                'nonWritable' => 'string'
            ],
            'nonAddableProperties' => [
                'nonAddable'
            ],
            'nonUpdatableProperties' => [
                'nonUpdatable'
            ],
            'nonReadableProperties' => [
                'nonReadable'
            ],
            'nonWritableProperties' => [
                'nonWritable'
            ]
        ]);

        $model = $model::make([
            'nonAddable' => 'nonAddableValue',
            'nonUpdatable' => 'nonUpdatableValue',
            'nonReadable' => 'nonReadableValue',
            'nonWritable' => 'nonWritableValue'
        ]);

        return [
            [$model]
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Tests
    |--------------------------------------------------------------------------
    */

    /**
     * @test
     * @dataProvider insertDataProvider
     *
     * @param string $propertyType
     * @param mixed $value
     * @param mixed $expected
     * @param string $exceptionClass
     */
    public function insertProperties(string $propertyType, $value, $expected, string $exceptionClass = null):void
    {
        if(!is_null($exceptionClass)){
            $this->expectException($exceptionClass);
        }

        $model = Env::setUpModel('ModelTest', ['properties' => ['test' => $propertyType]]);
        $model = $model::make()->insert(['test' => $value]);
        $actual = $model->getPropertyValue('test');

        if ($actual instanceof ModelInterface or $actual instanceof ModelCollectionInterface){
            static::assertSame($expected, $actual->toArray());
        } else {
            static::assertSame($expected, $actual);
        }
    }

    /**
     * @test
     * @dataProvider convertingDataProvider
     *
     * @param string $propertyType
     * @param mixed $value
     * @param mixed $expected
     * @param string|null $exceptionClass
     */
    public function convertingProperties(string $propertyType, $value, $expected, string $exceptionClass = null):void
    {
        if(!is_null($exceptionClass)){
            $this->expectException($exceptionClass);
        }

        $model = Env::setUpModel('ModelTest', ['properties' => ['test' => $propertyType]]);
        $model = $model::make(['test' => $value]);
        $actual = $model->toArray()['Test'];

        if ($actual instanceof ModelInterface or $actual instanceof ModelCollectionInterface){
            static::assertSame($expected, $actual->toArray());
        } else {
            static::assertSame($expected, $actual);
        }
    }

    /**
     * @test
     * @dataProvider modelDataProvider
     *
     * @param ModelInterface $model
     */
    public static function nonAddableProperties(ModelInterface $model):void
    {
        static::assertEquals(
            [
                'NonReadable' => 'nonReadableValue',
                'NonUpdatable' => 'nonUpdatableValue'
            ],
            $model->toArray(Model::IS_ADDABLE)
        );
    }

    /**
     * @test
     * @dataProvider modelDataProvider
     *
     * @param ModelInterface $model
     */
    public static function nonUpdatableProperties(ModelInterface $model):void
    {
        static::assertEquals(
            [
                'NonReadable' => 'nonReadableValue',
                'NonAddable' => 'nonAddableValue'
            ],
            $model->toArray(Model::IS_UPDATABLE)
        );
    }

    /**
     * @test
     * @dataProvider modelDataProvider
     *
     * @param ModelInterface $model
     */
    public static function nonReadableProperties(ModelInterface $model):void
    {
        static::assertEquals(
            [
                'NonUpdatable' => 'nonUpdatableValue',
                'NonAddable' => 'nonAddableValue',
                'NonWritable' => 'nonWritableValue'
            ],
            $model->toArray(Model::IS_READABLE)
        );
    }

    /**
     * @test
     * @dataProvider modelDataProvider
     *
     * @param ModelInterface $model
     */
    public static function nonWritableProperties(ModelInterface $model):void
    {
        static::assertEquals(
            [
                'NonReadable' => 'nonReadableValue',
                'NonUpdatable' => 'nonUpdatableValue',
                'NonAddable' => 'nonAddableValue'
            ],
            $model->toArray(Model::IS_WRITABLE)
        );
    }

    /**
     * @test
     * @dataProvider modelDataProvider
     *
     * @param ModelInterface $model
     */
    public function accessToNonReadableProperties(ModelInterface $model):void
    {
        $this->expectException(ModelException::class);
        $model->getPropertyValue('nonReadable');
    }

    /**
     * @test
     * @dataProvider modelDataProvider
     *
     * @param ModelInterface $model
     */
    public function accessToNonWritableProperties(ModelInterface $model):void
    {
        $this->expectException(ModelException::class);
        $model->setPropertyValue('nonWritable', 'new value');
    }

    /**
     * @test
     * @dataProvider modelDataProvider
     *
     * @param ModelInterface $model
     */
    public function accessToNonExistentProperties(ModelInterface $model):void
    {
        $this->expectException(ModelException::class);
        $model->getPropertyValue('nonexistentProperties');
    }
}