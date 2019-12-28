<?php

namespace YandexDirectSDKTest\Unit\Components;

use PHPUnit\Framework\TestCase;
use YandexDirectSDK\Components\Data;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Exceptions\ModelException;
use YandexDirectSDK\Interfaces\Model as ModelInterface;
use YandexDirectSDKTest\Helpers\Env;
use YandexDirectSDKTest\Units\Components\DataProviders\ModelPropertyAccessProvider;
use YandexDirectSDKTest\Units\Components\DataProviders\ModelPropertyTypeProvider;
use YandexDirectSDKTest\Units\Components\Foundation\GetOriginalValue;

class ModelTest extends TestCase
{
    use GetOriginalValue,
        ModelPropertyTypeProvider,
        ModelPropertyAccessProvider;

    /*
     |-------------------------------------------------------------------------------
     |
     | Получение мета-данных коллекции
     |
     |-------------------------------------------------------------------------------
    */

    /*
     | Tests
     |-------------------------------------------------------------------------------
    */

    public function testGetClassName():void
    {
        $this->assertSame(
            'TestModel',
            Env::setUpModel('TestModel')::getClassName()
        );
    }

    public function testGetPropertiesMeta():void
    {
        $childCollectionClass = Env::setUpModelCollection('TestChildCollection',[
            'compatibleModel' => $childModelClass = Env::setUpModel('TestChildModel')
        ]);

        $modelClass = Env::setUpModel('TestModel', [
            'properties' => [
                'propertyString' => 'string',
                'propertyBool' => 'bool',
                'propertyFloat' => 'float',
                'propertyInt' => 'int',
                'propertyStack' => 'stack',
                'propertyArray' => 'array',
                'propertyEnum' => 'enum:a,b',
                'propertyAEnum' => 'arrayOfEnum:a,b',
                'propertySet' => 'set:a,b',
                'propertyASet' => 'arrayOfSet:a,b',
                'propertyObject' => 'object:'.$childModelClass,
                'propertyAObject' => 'arrayOfObject:'.$childCollectionClass,
                'propertyCustom' => 'custom',
                'propertyACustom' => 'arrayOfCustom',
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

        $expected = [
            'propertyString' => [
                'name' => 'propertyString',
                'type' => 'string',
                'permissibleValues' => [],
                'itemTag' => false,
                'readable' => true,
                'writable' => true,
                'addable' => true,
                'updatable' => true
            ],
            'propertyBool' => [
                'name' => 'propertyBool',
                'type' => 'boolean',
                'permissibleValues' => [],
                'itemTag' => false,
                'readable' => true,
                'writable' => true,
                'addable' => true,
                'updatable' => true
            ],
            'propertyFloat' => [
                'name' => 'propertyFloat',
                'type' => 'double',
                'permissibleValues' => [],
                'itemTag' => false,
                'readable' => true,
                'writable' => true,
                'addable' => true,
                'updatable' => true
            ],
            'propertyInt' => [
                'name' => 'propertyInt',
                'type' => 'integer',
                'permissibleValues' => [],
                'itemTag' => false,
                'readable' => true,
                'writable' => true,
                'addable' => true,
                'updatable' => true
            ],
            'propertyStack' => [
                'name' => 'propertyStack',
                'type' => 'array',
                'permissibleValues' => [],
                'itemTag' => false,
                'readable' => true,
                'writable' => true,
                'addable' => true,
                'updatable' => true
            ],
            'propertyArray' => [
                'name' => 'propertyArray',
                'type' => 'array',
                'permissibleValues' => [],
                'itemTag' => true,
                'readable' => true,
                'writable' => true,
                'addable' => true,
                'updatable' => true
            ],
            'propertyEnum' => [
                'name' => 'propertyEnum',
                'type' => 'enum',
                'permissibleValues' => ['a','b'],
                'itemTag' => false,
                'readable' => true,
                'writable' => true,
                'addable' => true,
                'updatable' => true
            ],
            'propertyAEnum' => [
                'name' => 'propertyAEnum',
                'type' => 'set',
                'permissibleValues' => ['a','b'],
                'itemTag' => true,
                'readable' => true,
                'writable' => true,
                'addable' => true,
                'updatable' => true
            ],
            'propertySet' => [
                'name' => 'propertySet',
                'type' => 'set',
                'permissibleValues' => ['a','b'],
                'itemTag' => false,
                'readable' => true,
                'writable' => true,
                'addable' => true,
                'updatable' => true
            ],
            'propertyASet' => [
                'name' => 'propertyASet',
                'type' => 'set',
                'permissibleValues' => ['a','b'],
                'itemTag' => true,
                'readable' => true,
                'writable' => true,
                'addable' => true,
                'updatable' => true
            ],
            'propertyObject' => [
                'name' => 'propertyObject',
                'type' => 'object',
                'permissibleValues' => ['YandexDirectSDK\FakeModels\TestChildModel'],
                'itemTag' => false,
                'readable' => true,
                'writable' => true,
                'addable' => true,
                'updatable' => true
            ],
            'propertyAObject' => [
                'name' => 'propertyAObject',
                'type' => 'object',
                'permissibleValues' => ['YandexDirectSDK\FakeCollections\TestChildCollection'],
                'itemTag' => true,
                'readable' => true,
                'writable' => true,
                'addable' => true,
                'updatable' => true
            ],
            'propertyCustom' => [
                'name' => 'propertyCustom',
                'type' => 'custom',
                'permissibleValues' => [],
                'itemTag' => false,
                'readable' => true,
                'writable' => true,
                'addable' => true,
                'updatable' => true
            ],
            'propertyACustom' => [
                'name' => 'propertyACustom',
                'type' => 'custom',
                'permissibleValues' => [],
                'itemTag' => true,
                'readable' => true,
                'writable' => true,
                'addable' => true,
                'updatable' => true
            ],
            'nonAddable' => [
                'name' => 'nonAddable',
                'type' => 'string',
                'permissibleValues' => [],
                'itemTag' => false,
                'readable' => true,
                'writable' => true,
                'addable' => false,
                'updatable' => true
            ],
            'nonUpdatable' => [
                'name' => 'nonUpdatable',
                'type' => 'string',
                'permissibleValues' => [],
                'itemTag' => false,
                'readable' => true,
                'writable' => true,
                'addable' => true,
                'updatable' => false
            ],
            'nonReadable' => [
                'name' => 'nonReadable',
                'type' => 'string',
                'permissibleValues' => [],
                'itemTag' => false,
                'readable' => false,
                'writable' => true,
                'addable' => true,
                'updatable' => true
            ],
            'nonWritable' => [
                'name' => 'nonWritable',
                'type' => 'string',
                'permissibleValues' => [],
                'itemTag' => false,
                'readable' => true,
                'writable' => false,
                'addable' => false,
                'updatable' => false
            ],
        ];

        $this->assertSame(
            $expected,
            $modelClass::getPropertiesMeta()
        );
    }

    public function testGetMethodsMeta():void
    {
        $modelClass = Env::setUpModel('TestModel',[
            'methods' => [
                'create' => 'create\service\name',
                'update' => 'update\service\name'
            ]
        ]);

        $this->assertSame(
            [
                'create' => [
                    'name' => 'create',
                    'service' => 'create\service\name'
                ],
                'update' => [
                    'name' => 'update',
                    'service' => 'update\service\name'
                ]
            ],
            $modelClass::getMethodsMeta()
        );

    }

    public function testGetStaticMethodsMeta():void
    {
        $modelClass = Env::setUpModel('TestModel',[
            'staticMethods' => [
                'create' => 'create\service\name',
                'update' => 'update\service\name'
            ]
        ]);

        $this->assertSame(
            [
                'create' => [
                    'name' => 'create',
                    'service' => 'create\service\name'
                ],
                'update' => [
                    'name' => 'update',
                    'service' => 'update\service\name'
                ]
            ],
            $modelClass::getStaticMethodsMeta()
        );
    }

    public function testGetCompatibleCollectionClass():void
    {
        $collectionClass = Env::setUpModelCollection('TestCollection',[
            'compatibleModel' => $modelClass = Env::setUpModel('TestModel')
        ]);

        /** @noinspection PhpUndefinedMethodInspection */
        $modelClass::reboot([
            'compatibleCollection' => $collectionClass
        ]);

        $this->assertSame(
            'YandexDirectSDK\FakeCollections\TestCollection',
            $modelClass::getCompatibleCollectionClass()
        );
    }

    public function testMakeCompatibleCollection():void
    {
        $collectionClass = Env::setUpModelCollection('TestCollection',[
            'compatibleModel' => $modelClass = Env::setUpModel('TestModel')
        ]);

        /** @noinspection PhpUndefinedMethodInspection */
        $modelClass::reboot([
            'compatibleCollection' => $collectionClass
        ]);

        $this->assertInstanceOf(
            $collectionClass,
            $modelClass::makeCompatibleCollection()
        );
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | Создание модели
    |
    |-------------------------------------------------------------------------------
   */

    /*
     | Data providers
     |-------------------------------------------------------------------------------
    */

    public function providerToCreateModel(): array
    {
        return $this->modelPropertyTypeProvider('toInsert');
    }

    /*
     | Helpers
     |-------------------------------------------------------------------------------
    */

    /**
     * @param callable $builder
     * @param array $meta
     */
    protected function checkCreation(callable $builder, array $meta):void
    {
        if(!is_null($meta['exception'])){
            $this->expectException($meta['exception']);
        }

        $modelClass = Env::setUpModel('ModelTest', [
            'properties' => ['test' => $meta['type']]
        ]);

        $model = $builder($modelClass, 'test', $meta['value']);

        if(is_null($meta['exception'])){
            if (!is_null($meta['value']) and preg_match('/^(?:object|arrayOfObject):(.*?)$/', $meta['type'], $propertyType)){
                $propertyType = $propertyType[1];
                static::assertInstanceOf(
                    $propertyType,
                    (function(){return $this->{'data'}['test'];})->bindTo($model,$model)()
                );
            }
            static::assertSame(
                $meta['expected'],
                $this->getOriginalValue($model)['test']
            );
        }
    }

    /*
     | Tests
     |-------------------------------------------------------------------------------
    */

    /**
     * @dataProvider providerToCreateModel
     * @param array $meta
     */
    public function testNew(array $meta):void
    {
        $this->checkCreation(function($modelClass, $propertyName, $value){
            return new $modelClass([$propertyName => $value]);
        }, $meta);
    }

    /**
     * @dataProvider providerToCreateModel
     * @param array $meta
     */
    public function testMake(array $meta):void
    {
        $this->checkCreation(function($modelClass, $propertyName, $value){
            /** @var ModelInterface $modelClass */
            return $modelClass::make([$propertyName => $value]);
        }, $meta);
    }

    /**
     * @dataProvider providerToCreateModel
     * @param array $meta
     */
    public function testInsert(array $meta):void
    {
        $this->checkCreation(function($modelClass, $propertyName, $value){
            /** @var ModelInterface $modelClass */
            return $modelClass::make()->insert([$propertyName => $value]);
        }, $meta);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    | Установка значения для свойства модели
    |
    |-------------------------------------------------------------------------------
   */

    /*
     | Data providers
     |-------------------------------------------------------------------------------
    */

    public function providerToSetProperty(): array
    {
        return $this->modelPropertyTypeProvider('toSet');
    }

    /*
     | Helpers
     |-------------------------------------------------------------------------------
    */

    /**
     * @param callable $setter
     * @param array $meta
     */
    protected function checkSetting(callable $setter, array $meta):void
    {
        if(!is_null($meta['exception'])){
            $this->expectException($meta['exception']);
        }

        $model = Env::setUpModel('ModelTest', [
            'properties' => ['test' => $meta['type']]
        ])::make();

        $setter($model, 'test', $meta['value']);

        if(is_null($meta['exception'])){
            if (!is_null($meta['value']) and preg_match('/^(?:object|arrayOfObject):(.*?)$/', $meta['type'], $propertyType)){
                $propertyType = $propertyType[1];
                static::assertInstanceOf(
                    $propertyType,
                    (function(){return $this->{'data'}['test'];})->bindTo($model,$model)()
                );
            }
            static::assertSame(
                $meta['expected'],
                $this->getOriginalValue($model)['test']
            );
        }
    }

    /*
     | Tests
     |-------------------------------------------------------------------------------
    */

    /**
     * @dataProvider providerToSetProperty
     * @param array $meta
     */
    public function testSet(array $meta):void
    {
        $this->checkSetting(function(ModelInterface $model, string $propertyName, $value){
            $propertyName = 'set'.ucfirst($propertyName);
            static::assertSame(
                $model,
                $model->{$propertyName}($value)
            );
        }, $meta);
    }

    /**
     * @dataProvider providerToSetProperty
     * @param array $meta
     */
    public function testSetByProperty(array $meta):void
    {
        $this->checkSetting(function(ModelInterface $model, string $propertyName, $value){
            $model->{$propertyName} = $value;
        }, $meta);
    }

    /**
     * @dataProvider providerToSetProperty
     * @param array $meta
     */
    public function testSetPropertyValue(array $meta):void
    {
        $this->checkSetting(function(ModelInterface $model, string $propertyName, $value){
            $propertyName = 'set'.ucfirst($propertyName);
            static::assertSame(
                $model,
                $model->{$propertyName}($value)
            );
        }, $meta);
    }

    /*
    |-------------------------------------------------------------------------------
    |
    | Получение значений свойств модели
    |
    |-------------------------------------------------------------------------------
   */

    /*
     | Data providers
     |-------------------------------------------------------------------------------
    */

    public function providerToGetProperty(): array
    {
        return $this->modelPropertyTypeProvider('toGet');
    }

    /*
     | Helpers
     |-------------------------------------------------------------------------------
    */

    /**
     * @param callable $getter
     * @param array $meta
     */
    protected function checkGetting(callable $getter, array $meta):void
    {
        $model = $modelClass = Env::setUpModel('ModelTest', [
            'properties' => ['test' => $meta['type']]
        ])::make();

        (function($value){
            $this->{'data'}['test'] = $value;
        })->bindTo($model,$model)($meta['value']);

        static::assertSame(
            $meta['expected'],
            $getter($model, 'test')
        );
    }

    /*
     | Tests
     |-------------------------------------------------------------------------------
    */

    /**
     * @dataProvider providerToGetProperty
     * @param array $meta
     */
    public function testGet(array $meta):void
    {
        $this->checkGetting(function(ModelInterface $model, string $propertyName){
            $propertyName = 'get'.ucfirst($propertyName);
            return $model->{$propertyName}();
        }, $meta);
    }

    /**
     * @dataProvider providerToGetProperty
     * @param array $meta
     */
    public function testGetByProperty(array $meta):void
    {
        $this->checkGetting(function(ModelInterface $model, string $propertyName){
            return $model->{$propertyName};
        }, $meta);
    }

    /**
     * @dataProvider providerToGetProperty
     * @param array $meta
     */
    public function testGetPropertyValue(array $meta):void
    {
        $this->checkGetting(function(ModelInterface $model, string $propertyName){
            return $model->getPropertyValue($propertyName);
        }, $meta);
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Конвертация модели
     |
     |-------------------------------------------------------------------------------
    */

    /*
     | Data providers
     |-------------------------------------------------------------------------------
    */

    public function providerToConversionModel(): array
    {
        return $this->modelPropertyTypeProvider('toConvert');
    }

    /*
     | Helpers
     |-------------------------------------------------------------------------------
    */

    /**
     * @param callable $converter
     * @param array $meta
     */
    protected function checkConverting(callable $converter, array $meta):void
    {
        $model = $modelClass = Env::setUpModel('ModelTest', [
            'properties' => ['test' => $meta['type']]
        ])::make();

        (function($value){
            $this->{'data'}['test'] = $value;
        })->bindTo($model,$model)($meta['value']);

        $converter($model, ['Test' => $meta['expected']]);
    }

    /*
     | Tests
     |-------------------------------------------------------------------------------
    */

    /**
     * @dataProvider providerToConversionModel
     * @param array $meta
     */
    public function testToArray(array $meta):void
    {
        $this->checkConverting(function(ModelInterface $model, $expected){
            static::assertSame(
                $expected,
                $model->toArray()
            );
        }, $meta);
    }

    /**
     * @dataProvider providerToConversionModel
     * @depends testToArray
     * @param array $meta
     */
    public function testToJson(array $meta):void
    {
        $this->checkConverting(function(ModelInterface $model, $expected){
            static::assertSame(
                json_encode($expected, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE),
                $model->toJson()
            );
        }, $meta);
    }

    /**
     * @dataProvider providerToConversionModel
     * @depends testToArray
     * @param array $meta
     */
    public function testToString(array $meta):void
    {
        $this->checkConverting(function(ModelInterface $model, $expected){
            static::assertSame(
                json_encode($expected, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE),
                (string) $model
            );
        }, $meta);
    }

    /**
     * @dataProvider providerToConversionModel
     * @depends testToArray
     * @param array $meta
     */
    public function testToData(array $meta):void
    {
        $this->checkConverting(function(ModelInterface $model, $expected){
            static::assertInstanceOf(
                Data::class,
                $model->toData()
            );
            static::assertSame(
                $expected,
                $model->toData()->toArray()
            );
        }, $meta);
    }

    /**
     * @depends testToArray
     * @return void
     */
    public function testToCollection():void
    {
        $collectionClass = Env::setUpModelCollection('CollectionTest', [
            'compatibleModel' => $modelClass = Env::setUpModel('ModelTest')
        ]);

        $modelClass = Env::setUpModel('ModelTest', [
            'compatibleCollection' => $collectionClass
        ]);

        $model = $modelClass::make();
        $collection = $model->toCollection();

        $this->assertSame(
            [$model],
            $collection->all()
        );
    }

    /**
     * @depends testToArray
     * @return void
     */
    public function testToCollection_NotSupport():void
    {
        $model = Env::setUpModel('ModelTest')::make();

        $this->expectException(ModelException::class);
        $model->toCollection();
    }

    /**
     * @dataProvider providerToConversionModel
     * @depends testToArray
     * @param array $meta
     */
    public function testHash(array $meta):void
    {
        $this->checkConverting(function(ModelInterface $model, $expected){
            static::assertSame(
                sha1(json_encode($expected, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE)),
                $model->hash()
            );
        }, $meta);
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Клонирование коллекции
     |
     |-------------------------------------------------------------------------------
    */

    /*
     | Tests
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testToArray
     * @return void
     */
    public function testCopy():void
    {
        $this->assertNotSame(
            $originalModel = Env::setUpModel('ModelTest')::make(),
            $cloneModel = $originalModel->copy()
        );

        $this->assertInstanceOf(
            ModelInterface::class,
            $cloneModel
        );
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Вызов перезагружаемых методов коллекции
     |
     |-------------------------------------------------------------------------------
    */

    /*
     | Helpers
     |-------------------------------------------------------------------------------
    */

    public static function checkMethod(...$arguments)
    {
        return $arguments;
    }

    /*
     | Tests
     |-------------------------------------------------------------------------------
    */

    public function testCall():void
    {
        $modelClass = Env::setUpModel('ModelTest', [
            'methods' => ['checkMethod' => static::class],
            'staticMethods' => ['checkMethod' => static::class]
        ]);

        $this->assertSame(
            ['arg-1','arg-2','arg-3'],
            $modelClass::{'checkMethod'}('arg-1','arg-2','arg-3')
        );

        $model = $modelClass::make();
        $this->assertSame(
            [$model, 'arg-1','arg-2','arg-3'],
            $model->{'checkMethod'}('arg-1','arg-2','arg-3')
        );
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Уровни доступа к свойствам модели
     |
     |-------------------------------------------------------------------------------
    */

    /*
     | Tests
     |-------------------------------------------------------------------------------
    */

    /**
     * @dataProvider modelPropertyAccessProvider
     * @param ModelInterface $model
     */
    public static function testNonAddableProperties(ModelInterface $model):void
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
     * @dataProvider modelPropertyAccessProvider
     * @param ModelInterface $model
     */
    public static function testNonUpdatableProperties(ModelInterface $model):void
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
     * @dataProvider modelPropertyAccessProvider
     * @param ModelInterface $model
     */
    public static function testNonReadableProperties(ModelInterface $model):void
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
     * @dataProvider modelPropertyAccessProvider
     * @param ModelInterface $model
     */
    public static function testNonWritableProperties(ModelInterface $model):void
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
     * @dataProvider modelPropertyAccessProvider
     * @param ModelInterface $model
     */
    public function testAccessToNonReadableProperties(ModelInterface $model):void
    {
        $this->expectException(ModelException::class);
        $model->getPropertyValue('nonReadable');
    }

    /**
     * @dataProvider modelPropertyAccessProvider
     * @param ModelInterface $model
     */
    public function testAccessToNonWritableProperties(ModelInterface $model):void
    {
        $this->expectException(ModelException::class);
        $model->setPropertyValue('nonWritable', 'new value');
    }

    /**
     * @dataProvider modelPropertyAccessProvider
     * @param ModelInterface $model
     */
    public function testAccessToNonExistentProperties(ModelInterface $model):void
    {
        $this->expectException(ModelException::class);
        $model->getPropertyValue('nonexistentProperties');
    }
}