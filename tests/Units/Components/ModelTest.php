<?php

namespace YandexDirectSDKTest\Unit\Session;

use PHPUnit\Framework\TestCase;
use YandexDirectSDK\Exceptions\ModelException;
use YandexDirectSDK\Session;
use YandexDirectSDKTest\Helpers\ModelCollectionTools;
use YandexDirectSDKTest\Helpers\ModelTools;
use YandexDirectSDKTest\Helpers\SessionTools;

class ModelTest extends TestCase
{
    /**
     * @var Session
     */
    public static $session;

    public static function setUpBeforeClass():void
    {
        self::$session = SessionTools::init();
    }

    public static function tearDownAfterClass():void
    {
        self::$session = null;
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Insert
     |
     |-------------------------------------------------------------------------------
    */

    public function dataInsert(){
        return [
            [ModelTools::create(['properties' => ['test' => 'boolean']]),   true,                   true],
            [ModelTools::create(['properties' => ['test' => 'boolean']]),   false,                  false],
            [ModelTools::create(['properties' => ['test' => 'boolean']]),   null,                   null],
            [ModelTools::create(['properties' => ['test' => 'boolean']]),   'string',               'string'],
            [ModelTools::create(['properties' => ['test' => 'boolean']]),   123,                    123],
            [ModelTools::create(['properties' => ['test' => 'boolean']]),   [1,2,3],                [1,2,3]],
            [ModelTools::create(['properties' => ['test' => 'boolean']]),   ['Items' => [1,2,3]],   ['Items' => [1,2,3]]],

            [ModelTools::create(['properties' => ['test' => 'string']]),   true,                    true],
            [ModelTools::create(['properties' => ['test' => 'string']]),   false,                   false],
            [ModelTools::create(['properties' => ['test' => 'string']]),   null,                    null],
            [ModelTools::create(['properties' => ['test' => 'string']]),   'string',                'string'],
            [ModelTools::create(['properties' => ['test' => 'string']]),   123,                     123],
            [ModelTools::create(['properties' => ['test' => 'string']]),   [1,2,3],                 [1,2,3]],
            [ModelTools::create(['properties' => ['test' => 'string']]),   ['Items' => [1,2,3]],    ['Items' => [1,2,3]]],

            [ModelTools::create(['properties' => ['test' => 'float']]),   true,                     true],
            [ModelTools::create(['properties' => ['test' => 'float']]),   false,                    false],
            [ModelTools::create(['properties' => ['test' => 'float']]),   null,                     null],
            [ModelTools::create(['properties' => ['test' => 'float']]),   'string',                 'string'],
            [ModelTools::create(['properties' => ['test' => 'float']]),   123,                      123],
            [ModelTools::create(['properties' => ['test' => 'float']]),   [1,2,3],                  [1,2,3]],
            [ModelTools::create(['properties' => ['test' => 'float']]),   ['Items' => [1,2,3]],     ['Items' => [1,2,3]]],

            [ModelTools::create(['properties' => ['test' => 'integer']]),   true,                   true],
            [ModelTools::create(['properties' => ['test' => 'integer']]),   false,                  false],
            [ModelTools::create(['properties' => ['test' => 'integer']]),   null,                   null],
            [ModelTools::create(['properties' => ['test' => 'integer']]),   'string',               'string'],
            [ModelTools::create(['properties' => ['test' => 'integer']]),   123,                    123],
            [ModelTools::create(['properties' => ['test' => 'integer']]),   [1,2,3],                [1,2,3]],
            [ModelTools::create(['properties' => ['test' => 'integer']]),   ['Items' => [1,2,3]],   ['Items' => [1,2,3]]],

            [ModelTools::create(['properties' => ['test' => 'array:string']]),   true,                  null],
            [ModelTools::create(['properties' => ['test' => 'array:string']]),   false,                 null],
            [ModelTools::create(['properties' => ['test' => 'array:string']]),   null,                  null],
            [ModelTools::create(['properties' => ['test' => 'array:string']]),   'string',              null],
            [ModelTools::create(['properties' => ['test' => 'array:string']]),   123,                   null],
            [ModelTools::create(['properties' => ['test' => 'array:string']]),   [1,2,3],               null],
            [ModelTools::create(['properties' => ['test' => 'array:string']]),   ['Items' => [1,2,3]],  [1,2,3]],

            [ModelTools::create(['properties' => ['test' => 'stack:string']]),   true,                  true],
            [ModelTools::create(['properties' => ['test' => 'stack:string']]),   false,                 false],
            [ModelTools::create(['properties' => ['test' => 'stack:string']]),   null,                  null],
            [ModelTools::create(['properties' => ['test' => 'stack:string']]),   'string',              'string'],
            [ModelTools::create(['properties' => ['test' => 'stack:string']]),   123,                   123],
            [ModelTools::create(['properties' => ['test' => 'stack:string']]),   [1,2,3],               [1,2,3]],
            [ModelTools::create(['properties' => ['test' => 'stack:string']]),   ['Items' => [1,2,3]],  ['Items' => [1,2,3]]],

            [ModelTools::create(['properties' => ['test' => 'enum:a,b']]),   true,                  true],
            [ModelTools::create(['properties' => ['test' => 'enum:a,b']]),   false,                 false],
            [ModelTools::create(['properties' => ['test' => 'enum:a,b']]),   null,                  null],
            [ModelTools::create(['properties' => ['test' => 'enum:a,b']]),   'string',              'string'],
            [ModelTools::create(['properties' => ['test' => 'enum:a,b']]),   123,                   123],
            [ModelTools::create(['properties' => ['test' => 'enum:a,b']]),   [1,2,3],               [1,2,3]],
            [ModelTools::create(['properties' => ['test' => 'enum:a,b']]),   ['Items' => [1,2,3]],  ['Items' => [1,2,3]]],

            [ModelTools::create(['properties' => ['test' => 'set:a,b']]),   true,                   true],
            [ModelTools::create(['properties' => ['test' => 'set:a,b']]),   false,                  false],
            [ModelTools::create(['properties' => ['test' => 'set:a,b']]),   null,                   null],
            [ModelTools::create(['properties' => ['test' => 'set:a,b']]),   'string',               'string'],
            [ModelTools::create(['properties' => ['test' => 'set:a,b']]),   123,                    123],
            [ModelTools::create(['properties' => ['test' => 'set:a,b']]),   [1,2,3],                [1,2,3]],
            [ModelTools::create(['properties' => ['test' => 'set:a,b']]),   ['Items' => [1,2,3]],   ['Items' => [1,2,3]]],

            [ModelTools::create(['properties' => ['test' => 'arrayOfEnum:a,b']]),   true,                   null],
            [ModelTools::create(['properties' => ['test' => 'arrayOfEnum:a,b']]),   false,                  null],
            [ModelTools::create(['properties' => ['test' => 'arrayOfEnum:a,b']]),   null,                   null],
            [ModelTools::create(['properties' => ['test' => 'arrayOfEnum:a,b']]),   'string',               null],
            [ModelTools::create(['properties' => ['test' => 'arrayOfEnum:a,b']]),   123,                    null],
            [ModelTools::create(['properties' => ['test' => 'arrayOfEnum:a,b']]),   [1,2,3],                null],
            [ModelTools::create(['properties' => ['test' => 'arrayOfEnum:a,b']]),   ['Items' => [1,2,3]],   [1,2,3]],

            [ModelTools::create(['properties' => ['test' => 'arrayOfSet:a,b']]),   true,                    null],
            [ModelTools::create(['properties' => ['test' => 'arrayOfSet:a,b']]),   false,                   null],
            [ModelTools::create(['properties' => ['test' => 'arrayOfSet:a,b']]),   null,                    null],
            [ModelTools::create(['properties' => ['test' => 'arrayOfSet:a,b']]),   'string',                null],
            [ModelTools::create(['properties' => ['test' => 'arrayOfSet:a,b']]),   123,                     null],
            [ModelTools::create(['properties' => ['test' => 'arrayOfSet:a,b']]),   [1,2,3],                 null],
            [ModelTools::create(['properties' => ['test' => 'arrayOfSet:a,b']]),   ['Items' => [1,2,3]],    [1,2,3]],

            [ModelTools::create(['properties' => ['test' => 'object:'.ModelTools::class]]),   true,                 ModelTools::class],
            [ModelTools::create(['properties' => ['test' => 'object:'.ModelTools::class]]),   false,                ModelTools::class],
            [ModelTools::create(['properties' => ['test' => 'object:'.ModelTools::class]]),   null,                 null],
            [ModelTools::create(['properties' => ['test' => 'object:'.ModelTools::class]]),   'string',             ModelTools::class],
            [ModelTools::create(['properties' => ['test' => 'object:'.ModelTools::class]]),   123,                  ModelTools::class],
            [ModelTools::create(['properties' => ['test' => 'object:'.ModelTools::class]]),   [1,2,3],              ModelTools::class],
            [ModelTools::create(['properties' => ['test' => 'object:'.ModelTools::class]]),   ['Items' => [1,2,3]], ModelTools::class],

            [ModelTools::create(['properties' => ['test' => 'object:'.ModelCollectionTools::class]]),   true,                    ModelCollectionTools::class],
            [ModelTools::create(['properties' => ['test' => 'object:'.ModelCollectionTools::class]]),   false,                   ModelCollectionTools::class],
            [ModelTools::create(['properties' => ['test' => 'object:'.ModelCollectionTools::class]]),   null,                    null],
            [ModelTools::create(['properties' => ['test' => 'object:'.ModelCollectionTools::class]]),   'string',                ModelCollectionTools::class],
            [ModelTools::create(['properties' => ['test' => 'object:'.ModelCollectionTools::class]]),   123,                     ModelCollectionTools::class],
            [ModelTools::create(['properties' => ['test' => 'object:'.ModelCollectionTools::class]]),   [1,2,3],                 ModelCollectionTools::class],
            [ModelTools::create(['properties' => ['test' => 'object:'.ModelCollectionTools::class]]),   ['Items' => [1,2,3]],    ModelCollectionTools::class],
        ];
    }

    /**
     * @dataProvider dataInsert
     *
     * @param ModelTools $model
     * @param $value
     * @param $expected
     * @throws ModelException
     */
    public function testInsert($model, $value, $expected){
        $model->insert(['test' => $value]);
        $actual = $model->getPropertyValue('test');

        if (is_object($actual)){
            $this->assertSame($expected, get_class($actual));
        } else {
            $this->assertSame($expected, $actual);
        }
    }

    public function dataToArray(){
        return [
            [ModelTools::create(['properties' => ['test' => 'string']]),   true,                   true],
            [ModelTools::create(['properties' => ['test' => 'string']]),   false,                  false],
            [ModelTools::create(['properties' => ['test' => 'string']]),   null,                   null],
            [ModelTools::create(['properties' => ['test' => 'string']]),   '',                     ''],
            [ModelTools::create(['properties' => ['test' => 'string']]),   'string',               'string'],
            [ModelTools::create(['properties' => ['test' => 'string']]),   0,                      0],
            [ModelTools::create(['properties' => ['test' => 'string']]),   123,                    123],
            [ModelTools::create(['properties' => ['test' => 'string']]),   [1,2,3],                [1,2,3]],
            [ModelTools::create(['properties' => ['test' => 'string']]),   ['Items' => [1,2,3]],   ['Items' => [1,2,3]]],

            [ModelTools::create(['properties' => ['test' => 'object:'.ModelTools::class]]),         true,                                       null],
            [ModelTools::create(['properties' => ['test' => 'object:'.ModelTools::class]]),         false,                                      null],
            [ModelTools::create(['properties' => ['test' => 'object:'.ModelTools::class]]),         null,                                       null],
            [ModelTools::create(['properties' => ['test' => 'object:'.ModelTools::class]]),         '',                                         null],
            [ModelTools::create(['properties' => ['test' => 'object:'.ModelTools::class]]),         'string',                                   null],
            [ModelTools::create(['properties' => ['test' => 'object:'.ModelTools::class]]),         0,                                          null],
            [ModelTools::create(['properties' => ['test' => 'object:'.ModelTools::class]]),         123,                                        null],
            [ModelTools::create(['properties' => ['test' => 'object:'.ModelTools::class]]),         [1,2,3],                                    null],
            [ModelTools::create(['properties' => ['test' => 'object:'.ModelTools::class]]),         ['Items' => [1,2,3]],                       null],
            [ModelTools::create(['properties' => ['test' => 'object:'.ModelTools::class]]),         ['propString' => 'string'],                 ['PropString' => 'string']],
            [ModelTools::create(['properties' => ['test' => 'arrayOfObject:'.ModelTools::class]]),  ['propString' => 'string'],                 null],
            [ModelTools::create(['properties' => ['test' => 'arrayOfObject:'.ModelTools::class]]),  ['Items' => ['propString' => 'string']],    ['Items' => ['PropString' => 'string']]],

            [ModelTools::create(['properties' => ['test' => 'object:'.ModelCollectionTools::class]]),           true,                                       null],
            [ModelTools::create(['properties' => ['test' => 'object:'.ModelCollectionTools::class]]),           false,                                      null],
            [ModelTools::create(['properties' => ['test' => 'object:'.ModelCollectionTools::class]]),           null,                                       null],
            [ModelTools::create(['properties' => ['test' => 'object:'.ModelCollectionTools::class]]),           '',                                         null],
            [ModelTools::create(['properties' => ['test' => 'object:'.ModelCollectionTools::class]]),           'string',                                   null],
            [ModelTools::create(['properties' => ['test' => 'object:'.ModelCollectionTools::class]]),           0,                                          null],
            [ModelTools::create(['properties' => ['test' => 'object:'.ModelCollectionTools::class]]),           123,                                        null],
            [ModelTools::create(['properties' => ['test' => 'object:'.ModelCollectionTools::class]]),           [1,2,3],                                    [[],[],[]]],
            [ModelTools::create(['properties' => ['test' => 'object:'.ModelCollectionTools::class]]),           ['Items' => [1,2,3]],                       [[]]],
            [ModelTools::create(['properties' => ['test' => 'object:'.ModelCollectionTools::class]]),           ['propString' => 'string'],                 [[]]],
            [ModelTools::create(['properties' => ['test' => 'object:'.ModelCollectionTools::class]]),           [['propString' => 'string']],               [['PropString' => 'string']]],
            [ModelTools::create(['properties' => ['test' => 'arrayOfObject:'.ModelCollectionTools::class]]),    [['propString' => 'string']],               null],
            [ModelTools::create(['properties' => ['test' => 'arrayOfObject:'.ModelCollectionTools::class]]),    ['Items' => [['propString' => 'string']]],  ['Items' => [['PropString' => 'string']]]],

        ];
    }

    /**
     * @dataProvider dataToArray
     *
     * @param ModelTools $model
     * @param $value
     * @param $expected
     */
    public function testToArray($model, $value, $expected){
        $model->insert(['test' => $value]);
        $actual = $model->toArray()['Test'];

        $this->assertSame($expected, $actual);
    }


}