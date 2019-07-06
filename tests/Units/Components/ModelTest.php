<?php

namespace YandexDirectSDKTest\Unit\Components;

use PHPUnit\Framework\TestCase;
use YandexDirectSDK\Exceptions\ModelException;
use YandexDirectSDKTest\Helpers\FakeModelCollectionTools;
use YandexDirectSDKTest\Helpers\FakeModel;

class ModelTest extends TestCase
{
    /*
     |-------------------------------------------------------------------------------
     |
     | Insert
     |
     |-------------------------------------------------------------------------------
    */

    public function dataInsert(){
        return [
            [FakeModel::create(['properties' => ['test' => 'boolean']]),   true,                   true],
            [FakeModel::create(['properties' => ['test' => 'boolean']]),   false,                  false],
            [FakeModel::create(['properties' => ['test' => 'boolean']]),   null,                   null],
            [FakeModel::create(['properties' => ['test' => 'boolean']]),   'string',               'string'],
            [FakeModel::create(['properties' => ['test' => 'boolean']]),   123,                    123],
            [FakeModel::create(['properties' => ['test' => 'boolean']]),   [1,2,3],                [1,2,3]],
            [FakeModel::create(['properties' => ['test' => 'boolean']]),   ['Items' => [1,2,3]],   ['Items' => [1,2,3]]],

            [FakeModel::create(['properties' => ['test' => 'string']]),   true,                    true],
            [FakeModel::create(['properties' => ['test' => 'string']]),   false,                   false],
            [FakeModel::create(['properties' => ['test' => 'string']]),   null,                    null],
            [FakeModel::create(['properties' => ['test' => 'string']]),   'string',                'string'],
            [FakeModel::create(['properties' => ['test' => 'string']]),   123,                     123],
            [FakeModel::create(['properties' => ['test' => 'string']]),   [1,2,3],                 [1,2,3]],
            [FakeModel::create(['properties' => ['test' => 'string']]),   ['Items' => [1,2,3]],    ['Items' => [1,2,3]]],

            [FakeModel::create(['properties' => ['test' => 'float']]),   true,                     true],
            [FakeModel::create(['properties' => ['test' => 'float']]),   false,                    false],
            [FakeModel::create(['properties' => ['test' => 'float']]),   null,                     null],
            [FakeModel::create(['properties' => ['test' => 'float']]),   'string',                 'string'],
            [FakeModel::create(['properties' => ['test' => 'float']]),   123,                      123],
            [FakeModel::create(['properties' => ['test' => 'float']]),   [1,2,3],                  [1,2,3]],
            [FakeModel::create(['properties' => ['test' => 'float']]),   ['Items' => [1,2,3]],     ['Items' => [1,2,3]]],

            [FakeModel::create(['properties' => ['test' => 'integer']]),   true,                   true],
            [FakeModel::create(['properties' => ['test' => 'integer']]),   false,                  false],
            [FakeModel::create(['properties' => ['test' => 'integer']]),   null,                   null],
            [FakeModel::create(['properties' => ['test' => 'integer']]),   'string',               'string'],
            [FakeModel::create(['properties' => ['test' => 'integer']]),   123,                    123],
            [FakeModel::create(['properties' => ['test' => 'integer']]),   [1,2,3],                [1,2,3]],
            [FakeModel::create(['properties' => ['test' => 'integer']]),   ['Items' => [1,2,3]],   ['Items' => [1,2,3]]],

            [FakeModel::create(['properties' => ['test' => 'array:string']]),   true,                  null],
            [FakeModel::create(['properties' => ['test' => 'array:string']]),   false,                 null],
            [FakeModel::create(['properties' => ['test' => 'array:string']]),   null,                  null],
            [FakeModel::create(['properties' => ['test' => 'array:string']]),   'string',              null],
            [FakeModel::create(['properties' => ['test' => 'array:string']]),   123,                   null],
            [FakeModel::create(['properties' => ['test' => 'array:string']]),   [1,2,3],               null],
            [FakeModel::create(['properties' => ['test' => 'array:string']]),   ['Items' => [1,2,3]],  [1,2,3]],

            [FakeModel::create(['properties' => ['test' => 'stack:string']]),   true,                  true],
            [FakeModel::create(['properties' => ['test' => 'stack:string']]),   false,                 false],
            [FakeModel::create(['properties' => ['test' => 'stack:string']]),   null,                  null],
            [FakeModel::create(['properties' => ['test' => 'stack:string']]),   'string',              'string'],
            [FakeModel::create(['properties' => ['test' => 'stack:string']]),   123,                   123],
            [FakeModel::create(['properties' => ['test' => 'stack:string']]),   [1,2,3],               [1,2,3]],
            [FakeModel::create(['properties' => ['test' => 'stack:string']]),   ['Items' => [1,2,3]],  ['Items' => [1,2,3]]],

            [FakeModel::create(['properties' => ['test' => 'enum:a,b']]),   true,                  true],
            [FakeModel::create(['properties' => ['test' => 'enum:a,b']]),   false,                 false],
            [FakeModel::create(['properties' => ['test' => 'enum:a,b']]),   null,                  null],
            [FakeModel::create(['properties' => ['test' => 'enum:a,b']]),   'string',              'string'],
            [FakeModel::create(['properties' => ['test' => 'enum:a,b']]),   123,                   123],
            [FakeModel::create(['properties' => ['test' => 'enum:a,b']]),   [1,2,3],               [1,2,3]],
            [FakeModel::create(['properties' => ['test' => 'enum:a,b']]),   ['Items' => [1,2,3]],  ['Items' => [1,2,3]]],

            [FakeModel::create(['properties' => ['test' => 'set:a,b']]),   true,                   true],
            [FakeModel::create(['properties' => ['test' => 'set:a,b']]),   false,                  false],
            [FakeModel::create(['properties' => ['test' => 'set:a,b']]),   null,                   null],
            [FakeModel::create(['properties' => ['test' => 'set:a,b']]),   'string',               'string'],
            [FakeModel::create(['properties' => ['test' => 'set:a,b']]),   123,                    123],
            [FakeModel::create(['properties' => ['test' => 'set:a,b']]),   [1,2,3],                [1,2,3]],
            [FakeModel::create(['properties' => ['test' => 'set:a,b']]),   ['Items' => [1,2,3]],   ['Items' => [1,2,3]]],

            [FakeModel::create(['properties' => ['test' => 'arrayOfEnum:a,b']]),   true,                   null],
            [FakeModel::create(['properties' => ['test' => 'arrayOfEnum:a,b']]),   false,                  null],
            [FakeModel::create(['properties' => ['test' => 'arrayOfEnum:a,b']]),   null,                   null],
            [FakeModel::create(['properties' => ['test' => 'arrayOfEnum:a,b']]),   'string',               null],
            [FakeModel::create(['properties' => ['test' => 'arrayOfEnum:a,b']]),   123,                    null],
            [FakeModel::create(['properties' => ['test' => 'arrayOfEnum:a,b']]),   [1,2,3],                null],
            [FakeModel::create(['properties' => ['test' => 'arrayOfEnum:a,b']]),   ['Items' => [1,2,3]],   [1,2,3]],

            [FakeModel::create(['properties' => ['test' => 'arrayOfSet:a,b']]),   true,                    null],
            [FakeModel::create(['properties' => ['test' => 'arrayOfSet:a,b']]),   false,                   null],
            [FakeModel::create(['properties' => ['test' => 'arrayOfSet:a,b']]),   null,                    null],
            [FakeModel::create(['properties' => ['test' => 'arrayOfSet:a,b']]),   'string',                null],
            [FakeModel::create(['properties' => ['test' => 'arrayOfSet:a,b']]),   123,                     null],
            [FakeModel::create(['properties' => ['test' => 'arrayOfSet:a,b']]),   [1,2,3],                 null],
            [FakeModel::create(['properties' => ['test' => 'arrayOfSet:a,b']]),   ['Items' => [1,2,3]],    [1,2,3]],

            [FakeModel::create(['properties' => ['test' => 'object:'.FakeModel::class]]),   true,                 FakeModel::class],
            [FakeModel::create(['properties' => ['test' => 'object:'.FakeModel::class]]),   false,                FakeModel::class],
            [FakeModel::create(['properties' => ['test' => 'object:'.FakeModel::class]]),   null,                 null],
            [FakeModel::create(['properties' => ['test' => 'object:'.FakeModel::class]]),   'string',             FakeModel::class],
            [FakeModel::create(['properties' => ['test' => 'object:'.FakeModel::class]]),   123,                  FakeModel::class],
            [FakeModel::create(['properties' => ['test' => 'object:'.FakeModel::class]]),   [1,2,3],              FakeModel::class],
            [FakeModel::create(['properties' => ['test' => 'object:'.FakeModel::class]]),   ['Items' => [1,2,3]], FakeModel::class],

            [FakeModel::create(['properties' => ['test' => 'object:'.FakeModelCollectionTools::class]]),   true,                    FakeModelCollectionTools::class],
            [FakeModel::create(['properties' => ['test' => 'object:'.FakeModelCollectionTools::class]]),   false,                   FakeModelCollectionTools::class],
            [FakeModel::create(['properties' => ['test' => 'object:'.FakeModelCollectionTools::class]]),   null,                    null],
            [FakeModel::create(['properties' => ['test' => 'object:'.FakeModelCollectionTools::class]]),   'string',                FakeModelCollectionTools::class],
            [FakeModel::create(['properties' => ['test' => 'object:'.FakeModelCollectionTools::class]]),   123,                     FakeModelCollectionTools::class],
            [FakeModel::create(['properties' => ['test' => 'object:'.FakeModelCollectionTools::class]]),   [1,2,3],                 FakeModelCollectionTools::class],
            [FakeModel::create(['properties' => ['test' => 'object:'.FakeModelCollectionTools::class]]),   ['Items' => [1,2,3]],    FakeModelCollectionTools::class],
        ];
    }

    /**
     * @dataProvider dataInsert
     *
     * @param FakeModel $model
     * @param $value
     * @param $expected
     * @throws ModelException
     */
    public function testInsert($model, $value, $expected)
    {
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
            [FakeModel::create(['properties' => ['test' => 'string']]),   true,                   true],
            [FakeModel::create(['properties' => ['test' => 'string']]),   false,                  false],
            [FakeModel::create(['properties' => ['test' => 'string']]),   null,                   null],
            [FakeModel::create(['properties' => ['test' => 'string']]),   '',                     ''],
            [FakeModel::create(['properties' => ['test' => 'string']]),   'string',               'string'],
            [FakeModel::create(['properties' => ['test' => 'string']]),   0,                      0],
            [FakeModel::create(['properties' => ['test' => 'string']]),   123,                    123],
            [FakeModel::create(['properties' => ['test' => 'string']]),   [1,2,3],                [1,2,3]],
            [FakeModel::create(['properties' => ['test' => 'string']]),   ['Items' => [1,2,3]],   ['Items' => [1,2,3]]],

            [FakeModel::create(['properties' => ['test' => 'object:'.FakeModel::class]]),         true,                                       'object'],
            [FakeModel::create(['properties' => ['test' => 'object:'.FakeModel::class]]),         false,                                      'object'],
            [FakeModel::create(['properties' => ['test' => 'object:'.FakeModel::class]]),         null,                                       null],
            [FakeModel::create(['properties' => ['test' => 'object:'.FakeModel::class]]),         '',                                         'object'],
            [FakeModel::create(['properties' => ['test' => 'object:'.FakeModel::class]]),         'string',                                   'object'],
            [FakeModel::create(['properties' => ['test' => 'object:'.FakeModel::class]]),         0,                                          'object'],
            [FakeModel::create(['properties' => ['test' => 'object:'.FakeModel::class]]),         123,                                        'object'],
            [FakeModel::create(['properties' => ['test' => 'object:'.FakeModel::class]]),         [1,2,3],                                    'object'],
            [FakeModel::create(['properties' => ['test' => 'object:'.FakeModel::class]]),         ['Items' => [1,2,3]],                       'object'],
            [FakeModel::create(['properties' => ['test' => 'object:'.FakeModel::class]]),         ['propString' => 'string'],                 ['PropString' => 'string']],
            [FakeModel::create(['properties' => ['test' => 'arrayOfObject:'.FakeModel::class]]),  ['propString' => 'string'],                 null],
            [FakeModel::create(['properties' => ['test' => 'arrayOfObject:'.FakeModel::class]]),  ['Items' => ['propString' => 'string']],    ['Items' => ['PropString' => 'string']]],

            [FakeModel::create(['properties' => ['test' => 'object:'.FakeModelCollectionTools::class]]),           true,                                       []],
            [FakeModel::create(['properties' => ['test' => 'object:'.FakeModelCollectionTools::class]]),           false,                                      []],
            [FakeModel::create(['properties' => ['test' => 'object:'.FakeModelCollectionTools::class]]),           null,                                       null],
            [FakeModel::create(['properties' => ['test' => 'object:'.FakeModelCollectionTools::class]]),           '',                                         []],
            [FakeModel::create(['properties' => ['test' => 'object:'.FakeModelCollectionTools::class]]),           'string',                                   []],
            [FakeModel::create(['properties' => ['test' => 'object:'.FakeModelCollectionTools::class]]),           0,                                          []],
            [FakeModel::create(['properties' => ['test' => 'object:'.FakeModelCollectionTools::class]]),           123,                                        []],
            [FakeModel::create(['properties' => ['test' => 'object:'.FakeModelCollectionTools::class]]),           [1,2,3],                                    [[],[],[]]],
            [FakeModel::create(['properties' => ['test' => 'object:'.FakeModelCollectionTools::class]]),           ['Items' => [1,2,3]],                       [[]]],
            [FakeModel::create(['properties' => ['test' => 'object:'.FakeModelCollectionTools::class]]),           ['propString' => 'string'],                 [[]]],
            [FakeModel::create(['properties' => ['test' => 'object:'.FakeModelCollectionTools::class]]),           [['propString' => 'string']],               [['PropString' => 'string']]],
            [FakeModel::create(['properties' => ['test' => 'arrayOfObject:'.FakeModelCollectionTools::class]]),    [['propString' => 'string']],               null],
            [FakeModel::create(['properties' => ['test' => 'arrayOfObject:'.FakeModelCollectionTools::class]]),    ['Items' => [['propString' => 'string']]],  ['Items' => [['PropString' => 'string']]]],

        ];
    }

    /**
     * @dataProvider dataToArray
     *
     * @param FakeModel $model
     * @param $value
     * @param $expected
     */
    public function testToArray($model, $value, $expected)
    {
        $model->insert(['test' => $value]);
        $actual = $model->toArray()['Test'];

        if (is_object($actual)){
            $this->assertEquals('object', $expected);
        } else {
            $this->assertSame($expected, $actual);
        }
    }


}