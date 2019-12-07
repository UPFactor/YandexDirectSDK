<?php

namespace YandexDirectSDKTest\Unit\Components;

use PHPUnit\Framework\TestCase;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Exceptions\ModelException;
use YandexDirectSDK\Interfaces\Model as ModelInterface;
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
    public static function insertDataProvider(): array
    {

        $childModelClass = Env::setUpModel('TestChildrenModel');
        $childCollectionClass = Env::setUpModelCollection('TestChildrenCollection', ['compatibleModel' => $childModelClass]);

        return [
            'boolean 1' => [['test' => 'boolean'],              true,                       true],
            'boolean 2' => [['test' => 'boolean'],              'true',                     true],
            'boolean 3' => [['test' => 'boolean'],              1,                          true],
            'boolean 4' => [['test' => 'boolean'],              '1',                        true],
            'boolean 5' => [['test' => 'boolean'],              false,                      false],
            'boolean 6' => [['test' => 'boolean'],              'false',                    false],
            'boolean 7' => [['test' => 'boolean'],              0,                          false],
            'boolean 8' => [['test' => 'boolean'],              '0',                        false],
            'boolean 9' => [['test' => 'boolean'],              null,                       null],
            'boolean 10' => [['test' => 'boolean'],             'string',                   null],
            'boolean 11' => [['test' => 'boolean'],             123,                        null],
            'boolean 12' => [['test' => 'boolean'],             [1,2,3],                    null],
            'boolean 13' => [['test' => 'boolean'],             ['Items' => [1,2,3]],       null],

            'string 1' => [['test' => 'string'],                true,                       '1'],
            'string 2' => [['test' => 'string'],                false,                      ''],
            'string 3' => [['test' => 'string'],                null,                       null],
            'string 4' => [['test' => 'string'],                'string',                   'string'],
            'string 5' => [['test' => 'string'],                123,                        '123'],
            'string 6' => [['test' => 'string'],                0,                          '0'],
            'string 7' => [['test' => 'string'],                [1,2,3],                    null],
            'string 8' => [['test' => 'string'],                ['Items' => [1,2,3]],       null],

            'float 1' => [['test' => 'float'],                  true,                       null],
            'float 2' => [['test' => 'float'],                  false,                      null],
            'float 3' => [['test' => 'float'],                  null,                       null],
            'float 4' => [['test' => 'float'],                  'string',                   null],
            'float 5' => [['test' => 'float'],                  123,                        123.0],
            'float 6' => [['test' => 'float'],                  0,                          0.0],
            'float 7' => [['test' => 'float'],                  2.2,                        2.2],
            'float 8' => [['test' => 'float'],                  [1,2,3],                    null],
            'float 9' => [['test' => 'float'],                  ['Items' => [1,2,3]],       null],

            'integer 1' => [['test' => 'integer'],              true,                       null],
            'integer 2' => [['test' => 'integer'],              false,                      null],
            'integer 3' => [['test' => 'integer'],              null,                       null],
            'integer 4' => [['test' => 'integer'],              'string',                   null],
            'integer 5' => [['test' => 'integer'],              123,                        123],
            'integer 6' => [['test' => 'integer'],              0,                          0],
            'integer 7' => [['test' => 'integer'],              2.2,                        2],
            'integer 8' => [['test' => 'integer'],              [1,2,3],                    null],
            'integer 9' => [['test' => 'integer'],              ['Items' => [1,2,3]],       null],

            'array:string 1' => [['test' => 'array:string'],    true,                       null],
            'array:string 2' => [['test' => 'array:string'],    false,                      null],
            'array:string 3' => [['test' => 'array:string'],    null,                       null],
            'array:string 4' => [['test' => 'array:string'],    'string',                   null],
            'array:string 5' => [['test' => 'array:string'],    123,                        null],
            'array:string 6' => [['test' => 'array:string'],    [1,2,3],                    null],
            'array:string 7' => [['test' => 'array:string'],    ['1','2','3'],              null],
            'array:string 8' => [['test' => 'array:string'],    ['Items' => ['1','2']],     ['1','2']],
            'array:string 9' => [['test' => 'array:string'],    ['Items' => [1,2,3]],       null],

            'stack:string 1' => [['test' => 'stack:string'],    true,                       null],
            'stack:string 2' => [['test' => 'stack:string'],    false,                      null],
            'stack:string 3' => [['test' => 'stack:string'],    null,                       null],
            'stack:string 4' => [['test' => 'stack:string'],    'string',                   null],
            'stack:string 5' => [['test' => 'stack:string'],    123,                        null],
            'stack:string 6' => [['test' => 'stack:string'],    [1,2,3],                    null],
            'stack:string 7' => [['test' => 'stack:string'],    ['1','2','3'],              ['1','2','3']],
            'stack:string 8' => [['test' => 'stack:string'],    ['Items' => [1,2,3]],       null],
            'stack:string 9' => [['test' => 'stack:array'],     ['key' => [1,2,3]],         ['key' => [1,2,3]]],

            'enum 1' => [['test' => 'enum:a,b'],                'a',                        'a'],
            'enum 2' => [['test' => 'enum:a,b'],                'b',                        'b'],
            'enum 3' => [['test' => 'enum:a,b'],                true,                       null],
            'enum 4' => [['test' => 'enum:a,b'],                false,                      null],
            'enum 5' => [['test' => 'enum:a,b'],                null,                       null],
            'enum 6' => [['test' => 'enum:a,b'],                'string',                   null],
            'enum 7' => [['test' => 'enum:a,b'],                123,                        null],
            'enum 8' => [['test' => 'enum:a,b'],                0,                          null],
            'enum 9' => [['test' => 'enum:a,b'],                [1,2,3],                    null],
            'enum 10' => [['test' => 'enum:a,b'],               ['Items' => [1,2,3]],       null],

            'set 1' => [['test' => 'set:a,b'],                  ['a','b'],                  ['a','b']],
            'set 2' => [['test' => 'set:a,b'],                  ['a'],                      ['a']],
            'set 3' => [['test' => 'set:a,b'],                  ['b'],                      ['b']],
            'set 4' => [['test' => 'set:a,b'],                  true,                       null],
            'set 5' => [['test' => 'set:a,b'],                  false,                      null],
            'set 6' => [['test' => 'set:a,b'],                  null,                       null],
            'set 7' => [['test' => 'set:a,b'],                  'string',                   null],
            'set 8' => [['test' => 'set:a,b'],                  123,                        null],
            'set 9' => [['test' => 'set:a,b'],                  [1,2,3],                    null],
            'set 10' => [['test' => 'set:a,b'],                 ['Items' => [1,2,3]],       null],
            'set 11' => [['test' => 'set:a,b'],                 ['Items' => ['a']],         null],
            'set 12' => [['test' => 'set:a,b'],                 ['Items' => ['b']],         null],
            'set 13' => [['test' => 'set:a,b'],                 ['Items' => ['a','b']],     null],

            'arrayOfEnum 1' => [['test' => 'arrayOfEnum:a,b'],  ['a','b'],                  null],
            'arrayOfEnum 2' => [['test' => 'arrayOfEnum:a,b'],  ['a'],                      null],
            'arrayOfEnum 3' => [['test' => 'arrayOfEnum:a,b'],  ['b'],                      null],
            'arrayOfEnum 4' => [['test' => 'arrayOfEnum:a,b'],  true,                       null],
            'arrayOfEnum 5' => [['test' => 'arrayOfEnum:a,b'],  false,                      null],
            'arrayOfEnum 6' => [['test' => 'arrayOfEnum:a,b'],  null,                       null],
            'arrayOfEnum 7' => [['test' => 'arrayOfEnum:a,b'],  'string',                   null],
            'arrayOfEnum 8' => [['test' => 'arrayOfEnum:a,b'],  123,                        null],
            'arrayOfEnum 9' => [['test' => 'arrayOfEnum:a,b'],  [1,2,3],                    null],
            'arrayOfEnum 10' => [['test' => 'arrayOfEnum:a,b'], ['Items' => [1,2,3]],       null],
            'arrayOfEnum 11' => [['test' => 'arrayOfEnum:a,b'], ['Items' => ['a']],         ['a']],
            'arrayOfEnum 12' => [['test' => 'arrayOfEnum:a,b'], ['Items' => ['b']],         ['b']],
            'arrayOfEnum 13' => [['test' => 'arrayOfEnum:a,b'], ['Items' => ['a','b']],     ['a','b']],
            'arrayOfEnum 14' => [['test' => 'arrayOfEnum:a,b'], ['Items' => ['a','b','c']], null],

            'arrayOfSet 1' => [['test' => 'arrayOfSet:a,b'],    ['a','b'],                  null],
            'arrayOfSet 2' => [['test' => 'arrayOfSet:a,b'],    ['a'],                      null],
            'arrayOfSet 3' => [['test' => 'arrayOfSet:a,b'],    ['b'],                      null],
            'arrayOfSet 4' => [['test' => 'arrayOfSet:a,b'],    true,                       null],
            'arrayOfSet 5' => [['test' => 'arrayOfSet:a,b'],    false,                      null],
            'arrayOfSet 6' => [['test' => 'arrayOfSet:a,b'],    null,                       null],
            'arrayOfSet 7' => [['test' => 'arrayOfSet:a,b'],    'string',                   null],
            'arrayOfSet 8' => [['test' => 'arrayOfSet:a,b'],    123,                        null],
            'arrayOfSet 9' => [['test' => 'arrayOfSet:a,b'],    [1,2,3],                    null],
            'arrayOfSet 10' => [['test' => 'arrayOfSet:a,b'],   ['Items' => [1,2,3]],       null],
            'arrayOfSet 11' => [['test' => 'arrayOfSet:a,b'],   ['Items' => ['a']],         ['a']],
            'arrayOfSet 12' => [['test' => 'arrayOfSet:a,b'],   ['Items' => ['b']],         ['b']],
            'arrayOfSet 13' => [['test' => 'arrayOfSet:a,b'],   ['Items' => ['a','b']],     ['a','b']],
            'arrayOfSet 14' => [['test' => 'arrayOfSet:a,b'],   ['Items' => ['a','b','c']], null],

            'object 1' => [['test' => 'object:'.$childModelClass],        true,                   $childModelClass],
            'object 2' => [['test' => 'object:'.$childModelClass],        false,                  $childModelClass],
            'object 3' => [['test' => 'object:'.$childModelClass],        null,                   null],
            'object 4' => [['test' => 'object:'.$childModelClass],        'string',               $childModelClass],
            'object 5' => [['test' => 'object:'.$childModelClass],        123,                    $childModelClass],
            'object 6' => [['test' => 'object:'.$childModelClass],        [1,2,3],                $childModelClass],
            'object 7' => [['test' => 'object:'.$childModelClass],        ['Items' => [1,2,3]],   $childModelClass],

            'collection 1' => [['test' => 'object:'.$childCollectionClass],   true,                   $childCollectionClass],
            'collection 2' => [['test' => 'object:'.$childCollectionClass],   false,                  $childCollectionClass],
            'collection 3' => [['test' => 'object:'.$childCollectionClass],  null,                   null],
            'collection 4' => [['test' => 'object:'.$childCollectionClass],  'string',               $childCollectionClass],
            'collection 5' => [['test' => 'object:'.$childCollectionClass],  123,                    $childCollectionClass],
            'collection 6' => [['test' => 'object:'.$childCollectionClass],  [1,2,3],                $childCollectionClass],
            'collection 7' => [['test' => 'object:'.$childCollectionClass],  ['Items' => [1,2,3]],   $childCollectionClass]
        ];
    }

    /**
     * @return array
     */
    public static function convertingDataProvider(): array
    {

        $childModelClass = Env::setUpModel('TestChildrenModel', [
            'properties' => [
                'propString' => 'string'
            ]
        ]);

        $childCollectionClass = Env::setUpModelCollection('TestChildrenCollection', [
            'compatibleModel' => $childModelClass
        ]);

        return [
            'boolean 1' => [['test' => 'boolean'],              true,                       true],
            'boolean 2' => [['test' => 'boolean'],              'true',                     true],
            'boolean 3' => [['test' => 'boolean'],              1,                          true],
            'boolean 4' => [['test' => 'boolean'],              '1',                        true],
            'boolean 5' => [['test' => 'boolean'],              false,                      false],
            'boolean 6' => [['test' => 'boolean'],              'false',                    false],
            'boolean 7' => [['test' => 'boolean'],              0,                          false],
            'boolean 8' => [['test' => 'boolean'],              '0',                        false],
            'boolean 9' => [['test' => 'boolean'],              null,                       null],
            'boolean 10' => [['test' => 'boolean'],             'string',                   null],
            'boolean 11' => [['test' => 'boolean'],             123,                        null],
            'boolean 12' => [['test' => 'boolean'],             [1,2,3],                    null],
            'boolean 13' => [['test' => 'boolean'],             ['Items' => [1,2,3]],       null],

            'string 1' => [['test' => 'string'],                true,                       '1'],
            'string 2' => [['test' => 'string'],                false,                      ''],
            'string 3' => [['test' => 'string'],                null,                       null],
            'string 4' => [['test' => 'string'],                'string',                   'string'],
            'string 5' => [['test' => 'string'],                123,                        '123'],
            'string 6' => [['test' => 'string'],                0,                          '0'],
            'string 7' => [['test' => 'string'],                [1,2,3],                    null],
            'string 8' => [['test' => 'string'],                ['Items' => [1,2,3]],       null],

            'float 1' => [['test' => 'float'],                  true,                       null],
            'float 2' => [['test' => 'float'],                  false,                      null],
            'float 3' => [['test' => 'float'],                  null,                       null],
            'float 4' => [['test' => 'float'],                  'string',                   null],
            'float 5' => [['test' => 'float'],                  123,                        123.0],
            'float 6' => [['test' => 'float'],                  0,                          0.0],
            'float 7' => [['test' => 'float'],                  2.2,                        2.2],
            'float 8' => [['test' => 'float'],                  [1,2,3],                    null],
            'float 9' => [['test' => 'float'],                  ['Items' => [1,2,3]],       null],

            'integer 1' => [['test' => 'integer'],              true,                       null],
            'integer 2' => [['test' => 'integer'],              false,                      null],
            'integer 3' => [['test' => 'integer'],              null,                       null],
            'integer 4' => [['test' => 'integer'],              'string',                   null],
            'integer 5' => [['test' => 'integer'],              123,                        123],
            'integer 6' => [['test' => 'integer'],              0,                          0],
            'integer 7' => [['test' => 'integer'],              2.2,                        2],
            'integer 8' => [['test' => 'integer'],              [1,2,3],                    null],
            'integer 9' => [['test' => 'integer'],              ['Items' => [1,2,3]],       null],

            'array:string 1' => [['test' => 'array:string'],    true,                       null],
            'array:string 2' => [['test' => 'array:string'],    false,                      null],
            'array:string 3' => [['test' => 'array:string'],    null,                       null],
            'array:string 4' => [['test' => 'array:string'],    'string',                   null],
            'array:string 5' => [['test' => 'array:string'],    123,                        null],
            'array:string 6' => [['test' => 'array:string'],    [1,2,3],                    null],
            'array:string 7' => [['test' => 'array:string'],    ['1','2','3'],              null],
            'array:string 8' => [['test' => 'array:string'],    ['Items' => ['1','2']],     ['Items' => ['1','2']]],
            'array:string 9' => [['test' => 'array:string'],    ['Items' => [1,2,3]],       null],

            'stack:string 1' => [['test' => 'stack:string'],    true,                       null],
            'stack:string 2' => [['test' => 'stack:string'],    false,                      null],
            'stack:string 3' => [['test' => 'stack:string'],    null,                       null],
            'stack:string 4' => [['test' => 'stack:string'],    'string',                   null],
            'stack:string 5' => [['test' => 'stack:string'],    123,                        null],
            'stack:string 6' => [['test' => 'stack:string'],    [1,2,3],                    null],
            'stack:string 7' => [['test' => 'stack:string'],    ['1','2','3'],              ['1','2','3']],
            'stack:string 8' => [['test' => 'stack:string'],    ['Items' => [1,2,3]],       null],
            'stack:string 9' => [['test' => 'stack:array'],     ['key' => [1,2,3]],         ['key' => [1,2,3]]],

            'enum 1' => [['test' => 'enum:a,b'],                'a',                        'a'],
            'enum 2' => [['test' => 'enum:a,b'],                'b',                        'b'],
            'enum 3' => [['test' => 'enum:a,b'],                true,                       null],
            'enum 4' => [['test' => 'enum:a,b'],                false,                      null],
            'enum 5' => [['test' => 'enum:a,b'],                null,                       null],
            'enum 6' => [['test' => 'enum:a,b'],                'string',                   null],
            'enum 7' => [['test' => 'enum:a,b'],                123,                        null],
            'enum 8' => [['test' => 'enum:a,b'],                0,                          null],
            'enum 9' => [['test' => 'enum:a,b'],                [1,2,3],                    null],
            'enum 10' => [['test' => 'enum:a,b'],               ['Items' => [1,2,3]],       null],

            'set 1' => [['test' => 'set:a,b'],                  ['a','b'],                  ['a','b']],
            'set 2' => [['test' => 'set:a,b'],                  ['a'],                      ['a']],
            'set 3' => [['test' => 'set:a,b'],                  ['b'],                      ['b']],
            'set 4' => [['test' => 'set:a,b'],                  true,                       null],
            'set 5' => [['test' => 'set:a,b'],                  false,                      null],
            'set 6' => [['test' => 'set:a,b'],                  null,                       null],
            'set 7' => [['test' => 'set:a,b'],                  'string',                   null],
            'set 8' => [['test' => 'set:a,b'],                  123,                        null],
            'set 9' => [['test' => 'set:a,b'],                  [1,2,3],                    null],
            'set 10' => [['test' => 'set:a,b'],                 ['Items' => [1,2,3]],       null],
            'set 11' => [['test' => 'set:a,b'],                 ['Items' => ['a']],         null],
            'set 12' => [['test' => 'set:a,b'],                 ['Items' => ['b']],         null],
            'set 13' => [['test' => 'set:a,b'],                 ['Items' => ['a','b']],     null],

            'arrayOfEnum 1' => [['test' => 'arrayOfEnum:a,b'],  ['a','b'],                  null],
            'arrayOfEnum 2' => [['test' => 'arrayOfEnum:a,b'],  ['a'],                      null],
            'arrayOfEnum 3' => [['test' => 'arrayOfEnum:a,b'],  ['b'],                      null],
            'arrayOfEnum 4' => [['test' => 'arrayOfEnum:a,b'],  true,                       null],
            'arrayOfEnum 5' => [['test' => 'arrayOfEnum:a,b'],  false,                      null],
            'arrayOfEnum 6' => [['test' => 'arrayOfEnum:a,b'],  null,                       null],
            'arrayOfEnum 7' => [['test' => 'arrayOfEnum:a,b'],  'string',                   null],
            'arrayOfEnum 8' => [['test' => 'arrayOfEnum:a,b'],  123,                        null],
            'arrayOfEnum 9' => [['test' => 'arrayOfEnum:a,b'],  [1,2,3],                    null],
            'arrayOfEnum 10' => [['test' => 'arrayOfEnum:a,b'], ['Items' => [1,2,3]],       null],
            'arrayOfEnum 11' => [['test' => 'arrayOfEnum:a,b'], ['Items' => ['a']],         ['Items' => ['a']]],
            'arrayOfEnum 12' => [['test' => 'arrayOfEnum:a,b'], ['Items' => ['b']],         ['Items' => ['b']]],
            'arrayOfEnum 13' => [['test' => 'arrayOfEnum:a,b'], ['Items' => ['a','b']],     ['Items' => ['a','b']]],
            'arrayOfEnum 14' => [['test' => 'arrayOfEnum:a,b'], ['Items' => ['a','b','c']], null],

            'arrayOfSet 1' => [['test' => 'arrayOfSet:a,b'],    ['a','b'],                  null],
            'arrayOfSet 2' => [['test' => 'arrayOfSet:a,b'],    ['a'],                      null],
            'arrayOfSet 3' => [['test' => 'arrayOfSet:a,b'],    ['b'],                      null],
            'arrayOfSet 4' => [['test' => 'arrayOfSet:a,b'],    true,                       null],
            'arrayOfSet 5' => [['test' => 'arrayOfSet:a,b'],    false,                      null],
            'arrayOfSet 6' => [['test' => 'arrayOfSet:a,b'],    null,                       null],
            'arrayOfSet 7' => [['test' => 'arrayOfSet:a,b'],    'string',                   null],
            'arrayOfSet 8' => [['test' => 'arrayOfSet:a,b'],    123,                        null],
            'arrayOfSet 9' => [['test' => 'arrayOfSet:a,b'],    [1,2,3],                    null],
            'arrayOfSet 10' => [['test' => 'arrayOfSet:a,b'],   ['Items' => [1,2,3]],       null],
            'arrayOfSet 11' => [['test' => 'arrayOfSet:a,b'],   ['Items' => ['a']],         ['Items' => ['a']]],
            'arrayOfSet 12' => [['test' => 'arrayOfSet:a,b'],   ['Items' => ['b']],         ['Items' => ['b']]],
            'arrayOfSet 13' => [['test' => 'arrayOfSet:a,b'],   ['Items' => ['a','b']],     ['Items' => ['a','b']]],
            'arrayOfSet 14' => [['test' => 'arrayOfSet:a,b'],   ['Items' => ['a','b','c']], null],

            'object 1' => [['test' => 'object:'.$childModelClass],          true,                                       'object'],
            'object 2' => [['test' => 'object:'.$childModelClass],          false,                                      'object'],
            'object 3' => [['test' => 'object:'.$childModelClass],          null,                                       null],
            'object 4' => [['test' => 'object:'.$childModelClass],          'string',                                   'object'],
            'object 5' => [['test' => 'object:'.$childModelClass],          123,                                        'object'],
            'object 6' => [['test' => 'object:'.$childModelClass],          [1,2,3],                                    'object'],
            'object 7' => [['test' => 'object:'.$childModelClass],          ['Items' => [1,2,3]],                       'object'],
            'object 8' => [['test' => 'object:'.$childModelClass],          ['propString' => 'string'],                 ['PropString' => 'string']],
            'object 9' => [['test' => 'arrayOfObject:'.$childModelClass],   ['propString' => 'string'],                 null],
            'object 10' => [['test' => 'arrayOfObject:'.$childModelClass],  ['Items' => ['propString' => 'string']],    ['Items' => ['PropString' => 'string']]],

            'collection 1' => [['test' => 'object:'.$childCollectionClass],             true,                                       []],
            'collection 2' => [['test' => 'object:'.$childCollectionClass],             false,                                      []],
            'collection 3' => [['test' => 'object:'.$childCollectionClass],             null,                                       null],
            'collection 4' => [['test' => 'object:'.$childCollectionClass],             'string',                                   []],
            'collection 5' => [['test' => 'object:'.$childCollectionClass],             123,                                        []],
            'collection 6' => [['test' => 'object:'.$childCollectionClass],             [1,2,3],                                    [[],[],[]]],
            'collection 7' => [['test' => 'object:'.$childCollectionClass],             ['Items' => [1,2,3]],                       [[]]],
            'collection 8' => [['test' => 'object:'.$childCollectionClass],             ['propString' => 'string'],                 [[]]],
            'collection 9' => [['test' => 'object:'.$childCollectionClass],             [['propString' => 'string']],               [['PropString' => 'string']]],
            'collection 10' => [['test' => 'arrayOfObject:'.$childCollectionClass],     [['propString' => 'string']],               null],
            'collection 11' => [['test' => 'arrayOfObject:'.$childCollectionClass],     ['Items' => [['propString' => 'string']]],  ['Items' => [['PropString' => 'string']]]]
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
     * @param array $properties
     * @param $value
     * @param $expected
     */
    public static function insertProperties(array $properties, $value, $expected):void
    {
        $model = Env::setUpModel('ModelTest', ['properties' => $properties]);
        $model = $model::make(['test' => $value]);
        $actual = $model->getPropertyValue('test');

        if (is_object($actual)){
            static::assertSame($expected, get_class($actual));
        } else {
            static::assertSame($expected, $actual);
        }
    }

    /**
     * @test
     * @dataProvider convertingDataProvider
     *
     * @param array $properties
     * @param $value
     * @param $expected
     */
    public static function convertingProperties(array $properties, $value, $expected):void
    {
        $model = Env::setUpModel('ModelTest', ['properties' => $properties]);
        $model = $model::make(['test' => $value]);
        $actual = $model->toArray()['Test'];

        if (is_object($actual)){
            static::assertEquals('object', $expected);
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