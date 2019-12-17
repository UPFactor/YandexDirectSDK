<?php

namespace YandexDirectSDKTest\Units\Components;

use PHPUnit\Framework\TestCase;
use YandexDirectSDK\Components\Data;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\ModelException;
use YandexDirectSDK\Interfaces\Model as ModelInterface;
use YandexDirectSDK\Interfaces\ModelCollection as ModelCollectionInterface;
use YandexDirectSDKTest\Helpers\Env;

class ModelCollectionTest extends TestCase
{
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

    public function testGetClassName()
    {
        $collection = Env::setUpModelCollection('TestCollection', [
            'compatibleModel' => Env::setUpModel('TestModel')
        ])::make();

        $this->assertEquals('TestCollection', $collection::getClassName());
    }

    public function testGetMethodsMeta()
    {
        $collection = Env::setUpModelCollection('TestCollection', [
            'compatibleModel' => Env::setUpModel('TestModel'),
            'methods' => [
                'create' => 'create\service\name',
                'update' => 'update\service\name'
            ]
        ])::make();

        $this->assertEquals(
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
            $collection::getMethodsMeta()
        );
    }

    public function testGetStaticMethodsMeta()
    {
        $collection = Env::setUpModelCollection('TestCollection', [
            'compatibleModel' => Env::setUpModel('TestModel'),
            'staticMethods' => [
                'create' => 'create\service\name',
                'update' => 'update\service\name'
            ]
        ])::make();

        $this->assertEquals(
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
            $collection::getStaticMethodsMeta()
        );
    }

    public function testGetCompatibleModelClass()
    {
        $collection = Env::setUpModelCollection('TestCollection', [
            'compatibleModel' => Env::setUpModel('TestModel')
        ])::make();

        $this->assertEquals(
            'YandexDirectSDK\FakeModels\TestModel',
            $collection::getCompatibleModelClass()
        );
    }

    public function testMakeCompatibleModel()
    {
        $modelClass = Env::setUpModel('TestModel');
        $collection = Env::setUpModelCollection('TestCollection', [
            'compatibleModel' => $modelClass
        ])::make();

        $this->assertInstanceOf(
            $modelClass,
            $collection::makeCompatibleModel()
        );
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Создание коллекции:
     |
     |  1. Коллекция может быть созданна пустой (без элементов);
     |  2. Коллекция может быть создана с предустановленнм массивом моделей или многомерным массивом,
     |     который описывает структуру добавляемых моделей. При этом ключи этих массивов должны
     |     содержать целочисленные значения;
     |  3. Коллекция не может быть созданна с несовместимыми с ней моделями;
     |
     |-------------------------------------------------------------------------------
    */

    /*
     | Data providers
     |-------------------------------------------------------------------------------
    */

    public function providerToCreateCollection()
    {
        $collectionClass = Env::setUpModelCollection('TestCreateCollection', [
            'compatibleModel' => $modelClass = Env::setUpModel('TestCreateModel', [
                'properties' => [
                    'name' => 'string',
                    'phone' => 'integer',
                    'mail' => 'string',
                ]
            ])
        ]);

        return [
            'empty' => [
                'collection' => $collectionClass,
                'constructor' => [],
                'expected' => []
            ],
            'models' => [
                'collection' => $collectionClass,
                'constructor' => [
                    $modelClass::make(['Name' => 'Alex', 'Phone' => '79631111111', 'Mail' => 'alex@mail.com']),
                    $modelClass::make(['name' => 'Daniel', 'phone' => '79632222222', 'mail' => 'daniel@mail.com']),
                    $modelClass::make(['name' => 'Harry', 'phone' => '79634444444', 'mail' => 'harry@mail.com'])
                ],
                'expected' => [
                    ['Name' => 'Alex', 'Phone' => 79631111111, 'Mail' => 'alex@mail.com'],
                    ['Name' => 'Daniel', 'Phone' => 79632222222, 'Mail' => 'daniel@mail.com'],
                    ['Name' => 'Harry', 'Phone' => 79634444444, 'Mail' => 'harry@mail.com']
                ]
            ],
            'array' => [
                'collection' => $collectionClass,
                'constructor' => [
                    ['Name' => 'Alex', 'Phone' => '79631111111', 'Mail' => 'alex@mail.com'],
                    ['name' => 'Daniel', 'phone' => '79632222222', 'mail' => 'daniel@mail.com'],
                    ['name' => 'Harry', 'phone' => '79634444444', 'mail' => 'harry@mail.com']
                ],
                'expected' => [
                    ['Name' => 'Alex', 'Phone' => 79631111111, 'Mail' => 'alex@mail.com'],
                    ['Name' => 'Daniel', 'Phone' => 79632222222, 'Mail' => 'daniel@mail.com'],
                    ['Name' => 'Harry', 'Phone' => 79634444444, 'Mail' => 'harry@mail.com']
                ]
            ],
            'incompatibleKeys' => [
                'collection' => $collectionClass,
                'constructor' => [
                    'key1' => $modelClass::make(['Name' => 'Alex', 'Phone' => '79631111111', 'Mail' => 'alex@mail.com']),
                    'key2' => $modelClass::make(['name' => 'Daniel', 'phone' => '79632222222', 'mail' => 'daniel@mail.com']),
                    'key3' => $modelClass::make(['name' => 'Harry', 'phone' => '79634444444', 'mail' => 'harry@mail.com'])
                ],
                'expected' => InvalidArgumentException::class
            ],
            'incompatibleItems' => [
                'collection' => $collectionClass,
                'constructor' => ['string instead of array'],
                'expected' => InvalidArgumentException::class
            ],
            'incompatibleModels' => [
                'collection' => $collectionClass,
                'constructor' => [
                    Env::setUpModel('IncompatibleTestModel')::make()
                ],
                'expected' => InvalidArgumentException::class
            ]
        ];
    }

    public function providerToMakeCollection()
    {
        $data = $this->providerToCreateCollection();
        unset($data['incompatibleKeys']);
        return $data;
    }

    /*
     | Tests
     |-------------------------------------------------------------------------------
    */

    /**
     * @dataProvider providerToCreateCollection
     * @param ModelCollectionInterface $collectionClass
     * @param ModelInterface[]|array[] $constructorArray
     * @param array[]|string $expectedArray
     */
    public function testNew($collectionClass, $constructorArray, $expectedArray)
    {
        if (is_string($expectedArray)){
            $this->expectException($expectedArray);
            new $collectionClass($constructorArray);
        } else {
            /** @var ModelCollectionInterface $collection */
            $collection = new $collectionClass($constructorArray);
            $this->assertEquals(
                $expectedArray,
                $collection->toArray()
            );
        }
    }

    /**
     * @dataProvider providerToCreateCollection
     * @param ModelCollectionInterface $collectionClass
     * @param ModelInterface[]|array[] $constructorArray
     * @param array[] $expectedArray
     */
    public function testWrap($collectionClass, $constructorArray, $expectedArray)
    {
        if (is_string($expectedArray)){
            $this->expectException($expectedArray);
            $collectionClass::wrap($constructorArray);
        } else {
            $this->assertEquals(
                $expectedArray,
                $collectionClass::wrap($constructorArray)->toArray()
            );
        }
    }

    /**
     * @dataProvider providerToMakeCollection
     * @param ModelCollectionInterface $collectionClass
     * @param ModelInterface[]|array[] $constructorArray
     * @param array[] $expectedArray
     */
    public function testMake($collectionClass, $constructorArray, $expectedArray)
    {
        if (is_string($expectedArray)){
            $this->expectException($expectedArray);
            $collectionClass::make(...$constructorArray);
        } else {
            $this->assertEquals(
                $expectedArray,
                $collectionClass::make(...$constructorArray)->toArray()
            );
        }
    }

    /**
     * @dataProvider providerToCreateCollection
     * @param ModelCollectionInterface $collectionClass
     * @param ModelInterface[]|array[] $constructorArray
     * @param array[] $expectedArray
     */
    public function testReset($collectionClass, $constructorArray, $expectedArray)
    {
        if (is_string($expectedArray)){
            $this->expectException($expectedArray);
            $collectionClass::make()->reset($constructorArray);
        } else {
            $this->assertEquals(
                $expectedArray,
                $collectionClass::make()->reset($constructorArray)->toArray()
            );
        }
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Вставка данных в коллекцию
     | 1. В качестве источника данных может быть использован PHP-массив или объект Data
     | 2. Объедиение данных выполняется по ключу
     | 3. После объединения данных элементы коллекции сортируются по ключу в восрастающем порядке
     | 4. Если в процессе объединения данных, за ключом уже закрепленна модель, то пересоздание
     |    объекта данной модели не выполняется, соответствующие данные объединяются с данными
     |    существующей модели.
     | 5. Имена свойст модели могут начинаться как с заглавной буквы, так и со строчной.
     |    На входе, все именна свойств получат заглавную первую букву
     |
     |-------------------------------------------------------------------------------
    */

    /*
     | Data providers
     |-------------------------------------------------------------------------------
    */

    public function providerToInsertCollection()
    {
        $collectionClass = Env::setUpModelCollection('TestInsertCollection', [
            'compatibleModel' => $modelClass = Env::setUpModel('TestInsertModel', [
                'properties' => [
                    'name' => 'string',
                    'phone' => 'integer',
                    'mail' => 'string',
                ]
            ])
        ]);

        return [
            'emptyToEmpty' => [
                'collection' => $collectionClass::wrap([]),
                'inserted' => [],
                'expectedModel' => [],
                'expectedData' => []
            ],
            'arrayToEmpty' => [
                'collection' => $collectionClass::wrap([]),
                'inserted' => [
                    ['Name'=> 'NewHarry', 'Mail' => 'new-harry@mail.com'],
                    ['Phone' => '79630000000'],
                    ['Name' => 'NoName', 'Mail' => 'no-name@mail.com']
                ],
                'expectedModel' => [
                    ['Name'=> 'NewHarry', 'Mail' => 'new-harry@mail.com'],
                    ['Phone' => 79630000000],
                    ['Name' => 'NoName', 'Mail' => 'no-name@mail.com']
                ],
                'expectedData' => [
                    ['Name'=> 'NewHarry', 'Mail' => 'new-harry@mail.com'],
                    ['Phone' => 79630000000],
                    ['Name' => 'NoName', 'Mail' => 'no-name@mail.com']
                ]
            ],
            'updateModelsByArray' => [
                'collection' => $collectionClass::wrap([
                    $model1 = $modelClass::make(['Name' => 'Alex', 'Phone' => '79631111111', 'Mail' => 'alex@mail.com']),
                    $model2 = $modelClass::make(['Name' => 'Daniel', 'Phone' => '79632222222', 'Mail' => 'daniel@mail.com']),
                    $model3 = $modelClass::make(['Name' => 'Harry', 'Phone' => '79634444444', 'Mail' => 'harry@mail.com'])
                ]),
                'inserted' => [
                    ['Phone' => '79630000000'],
                    ['Name'=> 'NewDaniel', 'Mail' => 'new-daniel@mail.com'],
                    ['Phone' => '79635556667', 'Mail' => 'new-harry@mail.com']
                ],
                'expectedModel' => [
                    $model1,
                    $model2,
                    $model3
                ],
                'expectedData' => [
                    ['Name' => 'Alex', 'Phone' => 79630000000, 'Mail' => 'alex@mail.com'],
                    ['Name' => 'NewDaniel', 'Phone' => 79632222222, 'Mail' => 'new-daniel@mail.com'],
                    ['Name' => 'Harry', 'Phone' => 79635556667, 'Mail' => 'new-harry@mail.com'],
                 ]
            ],
            'updateModelsByModels' => [
                'collection' => $collectionClass::wrap([
                    $model1 = $modelClass::make(['Name' => 'Alex', 'Phone' => '79631111111', 'Mail' => 'alex@mail.com']),
                    $model2 = $modelClass::make(['Name' => 'Daniel', 'Phone' => '79632222222', 'Mail' => 'daniel@mail.com']),
                    $model3 = $modelClass::make(['Name' => 'Harry', 'Phone' => '79634444444', 'Mail' => 'harry@mail.com'])
                ]),
                'inserted' => [
                    $model4 = $modelClass::make(['Phone' => '79630000000']),
                    $model5 = $modelClass::make(['Name'=> 'NewDaniel', 'Mail' => 'new-daniel@mail.com']),
                    $model6 = $modelClass::make(['Phone' => '79635556667', 'Mail' => 'new-harry@mail.com'])
                ],
                'expectedModel' => [
                    $model4,
                    $model5,
                    $model6
                ],
                'expectedData' => [
                    ['Phone' => 79630000000],
                    ['Name'=> 'NewDaniel', 'Mail' => 'new-daniel@mail.com'],
                    ['Phone' => 79635556667, 'Mail' => 'new-harry@mail.com'],
                ]
            ],
            'addModelsByArray' => [
                'collection' => $collectionClass::wrap([
                    $model1 = $modelClass::make(['Name' => 'Alex', 'Phone' => '79631111111', 'Mail' => 'alex@mail.com']),
                    $model2 = $modelClass::make(['Name' => 'Daniel', 'Phone' => '79632222222', 'Mail' => 'daniel@mail.com']),
                    $model3 = $modelClass::make(['Name' => 'Harry', 'Phone' => '79634444444', 'Mail' => 'harry@mail.com'])
                ]),
                'inserted' => [
                    [],
                    [],
                    [],
                    ['Name' => 'User1', 'Mail' => 'user1@mail.com'],
                    ['Name' => 'User2', 'Phone' => '79630000000', 'Mail' => 'user2@mail.com']
                ],
                'expectedModel' => [
                    $model1,
                    $model2,
                    $model3,
                    ['Name' => 'User1', 'Mail' => 'user1@mail.com'],
                    ['Name' => 'User2', 'Phone' => 79630000000, 'Mail' => 'user2@mail.com']
                ],
                'expectedData' => [
                    ['Name' => 'Alex', 'Phone' => 79631111111, 'Mail' => 'alex@mail.com'],
                    ['Name' => 'Daniel', 'Phone' => 79632222222, 'Mail' => 'daniel@mail.com'],
                    ['Name' => 'Harry', 'Phone' => 79634444444, 'Mail' => 'harry@mail.com'],
                    ['Name' => 'User1', 'Mail' => 'user1@mail.com'],
                    ['Name' => 'User2', 'Phone' => 79630000000, 'Mail' => 'user2@mail.com']
                ]
            ],
            'addModelsByModels' => [
                'collection' => $collectionClass::wrap([
                    $model1 = $modelClass::make(['Name' => 'Alex', 'Phone' => '79631111111', 'Mail' => 'alex@mail.com']),
                    $model2 = $modelClass::make(['Name' => 'Daniel', 'Phone' => '79632222222', 'Mail' => 'daniel@mail.com']),
                    $model3 = $modelClass::make(['Name' => 'Harry', 'Phone' => '79634444444', 'Mail' => 'harry@mail.com'])
                ]),
                'inserted' => [
                    [],
                    [],
                    [],
                    $model4 = $modelClass::make(['Name' => 'User1', 'Mail' => 'user1@mail.com']),
                    $model5 = $modelClass::make(['Name' => 'User2', 'Phone' => '79630000000', 'Mail' => 'user2@mail.com'])
                ],
                'expectedModel' => [
                    $model1,
                    $model2,
                    $model3,
                    $model4,
                    $model5
                ],
                'expectedData' => [
                    ['Name' => 'Alex', 'Phone' => 79631111111, 'Mail' => 'alex@mail.com'],
                    ['Name' => 'Daniel', 'Phone' => 79632222222, 'Mail' => 'daniel@mail.com'],
                    ['Name' => 'Harry', 'Phone' => 79634444444, 'Mail' => 'harry@mail.com'],
                    ['Name' => 'User1', 'Mail' => 'user1@mail.com'],
                    ['Name' => 'User2', 'Phone' => 79630000000, 'Mail' => 'user2@mail.com']
                ]
            ],
            'notSequentialAddModels' => [
                'collection' => $collectionClass::wrap([
                    1 => $model1 = $modelClass::make(['Name' => 'Alex', 'Phone' => '79631111111', 'Mail' => 'alex@mail.com']),
                    2 => $model2 = $modelClass::make(['Name' => 'Daniel', 'Phone' => '79632222222', 'Mail' => 'daniel@mail.com']),
                    3 => $model3 = $modelClass::make(['Name' => 'Harry', 'Phone' => '79634444444', 'Mail' => 'harry@mail.com'])
                ]),
                'inserted' => [
                    ['Name' => 'User1', 'Mail' => 'user1@mail.com'],
                    ['Phone' => '79630000000'],
                    ['Name'=> 'NewDaniel', 'Mail' => 'new-daniel@mail.com'],
                    ['Phone' => '79635556667', 'Mail' => 'new-harry@mail.com'],
                    $model4 = $modelClass::make(['Name' => 'User2', 'Phone' => '79630000000', 'Mail' => 'user2@mail.com'])
                ],
                'expectedModel' => [
                    ['Name' => 'User1', 'Mail' => 'user1@mail.com'],
                    $model1,
                    $model2,
                    $model3,
                    $model4
                ],
                'expectedData' => [
                    ['Name' => 'User1', 'Mail' => 'user1@mail.com'],
                    ['Name' => 'Alex', 'Phone' => 79630000000, 'Mail' => 'alex@mail.com'],
                    ['Name' => 'NewDaniel', 'Phone' => 79632222222, 'Mail' => 'new-daniel@mail.com'],
                    ['Name' => 'Harry', 'Phone' => 79635556667, 'Mail' => 'new-harry@mail.com'],
                    ['Name' => 'User2', 'Phone' => 79630000000, 'Mail' => 'user2@mail.com']
                ]
            ],
            'incompatibleKeys' => [
                'collection' => $collectionClass::wrap([]),
                'inserted' => [
                    'key1' => ['Name'=> 'NewHarry', 'Mail' => 'new-harry@mail.com'],
                    'key2' => ['Phone' => '79630000000'],
                    'key3' => ['Name' => 'NoName', 'Mail' => 'no-name@mail.com']
                ],
                'expectedModel' => InvalidArgumentException::class,
                'expectedData' => null
            ],
            'incompatibleItems' => [
                'collection' => $collectionClass::wrap([]),
                'inserted' => [
                    'item1',
                    'item2',
                    'item3'
                ],
                'expectedModel' => InvalidArgumentException::class,
                'expectedData' => null
            ],
            'incompatibleModels' => [
                'collection' => $collectionClass::wrap([]),
                'inserted' => [
                    Env::setUpModel('IncompatibleTestInsertModel')::make()
                ],
                'expectedModel' => InvalidArgumentException::class,
                'expectedData' => null
            ]
        ];
    }

    /*
     | Tests
     |-------------------------------------------------------------------------------
    */

    /**
     * @dataProvider providerToInsertCollection
     * @depends testAll
     * @depends testToArray
     * @param ModelCollectionInterface $collection
     * @param ModelInterface[]|array[] $inserted
     * @param ModelInterface[]|array[]|string $expectedModels
     * @param array[]|null $expectedData
     */
    public function testInsert(ModelCollectionInterface $collection, array $inserted, $expectedModels, $expectedData = null)
    {
        if (is_string($expectedModels)){
            $this->expectException($expectedModels);
            $collection->insert($inserted);
            return;
        }

        $models = $collection
            ->insert($inserted)
            ->all();

        if (empty($expectedModels)){
            $this->assertEmpty($models);
        } else {
            foreach ($expectedModels as $index => $expectedModel){
                if ($expectedModel instanceof ModelInterface){
                    $this->assertSame($expectedModel, $models[$index]);
                } else {
                    $this->assertSame(
                        $expectedModel,
                        $collection[$index]->toArray()
                    );
                }
            }
        }

        $this->assertSame(
            $expectedData,
            $collection->toArray()
        );
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Итерация коллекции
     |
     |-------------------------------------------------------------------------------
    */

    /*
     | Data providers
     |-------------------------------------------------------------------------------
    */

    public function providerToIterationCollection()
    {
        $collectionClass = Env::setUpModelCollection('TestIterationCollection', [
            'compatibleModel' => $modelClass = Env::setUpModel('TestIterationModel')
        ]);

        return [
            'collection' => [
                $collectionClass::wrap([$modelClass::make(), $modelClass::make(), $modelClass::make()])
            ]
        ];
    }

    /*
     | Tests
     |-------------------------------------------------------------------------------
    */

    /**
     * @dataProvider providerToIterationCollection
     * @param ModelCollectionInterface $collection
     */
    public function testIteratorAggregate(ModelCollectionInterface $collection)
    {
        foreach ($collection as $index => $model){
            $this->assertIsNumeric($index);
            $this->assertInstanceOf(ModelInterface::class, $model);
        }
    }

    /**
     * @dataProvider providerToIterationCollection
     * @param ModelCollectionInterface $collection
     */
    public function testEach(ModelCollectionInterface $collection)
    {
        $collection->each(function($model, $index){
            $this->assertIsNumeric($index);
            $this->assertInstanceOf(ModelInterface::class, $model);
        });
    }

    /**
     * @dataProvider providerToIterationCollection
     * @param ModelCollectionInterface $collection
     */
    public function testMap(ModelCollectionInterface $collection)
    {
        $new = $collection->map(function($model, $index){
            $this->assertIsNumeric($index);
            $this->assertInstanceOf(ModelInterface::class, $model);
            return $model;
        });

        $this->assertInstanceOf(ModelCollectionInterface::class, $new);
        $this->assertNotSame($collection, $new);

        $new = $collection->map(function(ModelInterface $model){
            return $model->toArray();
        });

        $this->assertInstanceOf(ModelCollectionInterface::class, $new);
        $this->assertNotSame($collection, $new);

        $this->expectException(InvalidArgumentException::class);
        $collection->map(function(){
            return 'not model';
        });
    }

    /**
     * @dataProvider providerToIterationCollection
     * @depends testIsEmpty
     * @param ModelCollectionInterface $collection
     */
    public function testFilter(ModelCollectionInterface $collection)
    {
        $new = $collection->filter(function($model, $index){
            $this->assertIsNumeric($index);
            $this->assertInstanceOf(ModelInterface::class, $model);
            return true;
        });

        $this->assertInstanceOf(ModelCollectionInterface::class, $new);
        $this->assertNotSame($collection, $new);

        $new = $collection->filter(function(){
            return false;
        });

        $this->assertInstanceOf(ModelCollectionInterface::class, $new);
        $this->assertNotSame($collection, $new);
        $this->assertTrue($new->isEmpty());
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Получения количества элементов в коллекции
     |
     |-------------------------------------------------------------------------------
    */

    /*
     | Data providers
     |-------------------------------------------------------------------------------
    */

    public function providerToCounted()
    {
        $collectionClass = Env::setUpModelCollection('TestCountedCollection', [
            'compatibleModel' => $modelClass = Env::setUpModel('TestCountedModel')
        ]);

        return [
            'empty' => [
                'collection' => $collectionClass::make(),
                'count' => 0
            ],
            'notEmpty' => [
                'collection' => $collectionClass::wrap([$modelClass::make(), $modelClass::make(), $modelClass::make()]),
                'count' => 3
            ]
        ];
    }

    /*
     | Tests
     |-------------------------------------------------------------------------------
    */

    /**
     * @dataProvider providerToCounted
     * @param ModelCollectionInterface $collection
     * @param int $count
     */
    public function testCountable(ModelCollectionInterface $collection, int $count)
    {
        $this->assertEquals(
            $count,
            count($collection)
        );
    }

    /**
     * @dataProvider providerToCounted
     * @param ModelCollectionInterface $collection
     * @param int $count
     */
    public function testCount(ModelCollectionInterface $collection, int $count)
    {
        $this->assertEquals(
            $count,
            $collection->count()
        );
    }

    /**
     * @dataProvider providerToCounted
     * @param ModelCollectionInterface $collection
     * @param int $count
     */
    public function testIsEmpty(ModelCollectionInterface $collection, int $count)
    {
        $this->assertEquals(
            ($count < 1),
            $collection->isEmpty()
        );
    }

    /**
     * @dataProvider providerToCounted
     * @param ModelCollectionInterface $collection
     * @param int $count
     */
    public function testIsNotEmpty(ModelCollectionInterface $collection, int $count)
    {
        $this->assertEquals(
            ($count > 1),
            $collection->isNotEmpty()
        );
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Получение элемента коллекции
     |
     |-------------------------------------------------------------------------------
    */

    /*
     | Data providers
     |-------------------------------------------------------------------------------
    */

    public function providerToGettingItems()
    {
        $collectionClass = Env::setUpModelCollection('TestGettingCollection', [
            'compatibleModel' => $modelClass = Env::setUpModel('TestGettingModel')
        ]);

        return [
            'collection-1' => [
                'collection' => $collectionClass::wrap([
                    $model1 = $modelClass::make(),
                    $model2 = $modelClass::make(),
                    $model3 = $modelClass::make()
                ]),
                'valueMap' => [$model1, $model2, $model3]
            ],
            'collection-2' => [
                'collection' => $collectionClass::wrap([
                    '3' => $model1 = $modelClass::make(),
                    '2' => $model2 = $modelClass::make(),
                    '1' => $model3 = $modelClass::make()
                ]),
                'valueMap' => ['3' => $model1, '2' => $model2, '1' => $model3]
            ],
            'collection-3' => [
                'collection' => $collectionClass::wrap([
                    10 => $model1 = $modelClass::make(),
                    5 => $model2 = $modelClass::make(),
                    15 => $model3 = $modelClass::make()
                ]),
                'valueMap' => [10 => $model1, 5 => $model2, 15 => $model3]
            ]
        ];
    }

    /*
     | Tests
     |-------------------------------------------------------------------------------
    */

    /**
     * @dataProvider providerToGettingItems
     * @param ModelCollectionInterface $collection
     * @param array $valueMap
     */
    public function testArrayAccessGet(ModelCollectionInterface $collection, array $valueMap)
    {
        foreach ($valueMap as $key => $value){
            $this->assertSame(
                $value,
                $collection[$key]
            );
        }
    }

    /**
     * @dataProvider providerToGettingItems
     * @depends testIsEmpty
     * @param ModelCollectionInterface $collection
     * @param array $valueMap
     */
    public function testShift(ModelCollectionInterface $collection, array $valueMap)
    {
        foreach ($valueMap as $value){
            $this->assertSame(
                $value,
                $collection->shift()
            );
        }

        $this->assertTrue(
            $collection->isEmpty()
        );

        $this->assertNull(
            $collection->shift()
        );

        $this->assertEquals(
            'defaultValue',
            $collection->shift('defaultValue')
        );
    }

    /**
     * @dataProvider providerToGettingItems
     * @depends testIsEmpty
     * @param ModelCollectionInterface $collection
     * @param array $valueMap
     */
    public function testPop(ModelCollectionInterface $collection, array $valueMap)
    {
        foreach (array_reverse($valueMap, true) as $value){
            $this->assertSame(
                $value,
                $collection->pop()
            );
        }

        $this->assertTrue(
            $collection->isEmpty()
        );

        $this->assertNull(
            $collection->pop()
        );

        $this->assertEquals(
            'defaultValue',
            $collection->pop('defaultValue')
        );
    }

    /**
     * @dataProvider providerToGettingItems
     * @depends testShift
     * @param ModelCollectionInterface $collection
     * @param array $valueMap
     */
    public function testFirst(ModelCollectionInterface $collection, array $valueMap)
    {
        foreach ($valueMap as $value){
            $this->assertSame(
                $value,
                $collection->first()
            );
            $collection->shift();
        }

        $this->assertNull(
            $collection->first()
        );

        $this->assertEquals(
            'defaultValue',
            $collection->last('defaultValue')
        );
    }

    /**
     * @dataProvider providerToGettingItems
     * @depends testPop
     * @param ModelCollectionInterface $collection
     * @param array $valueMap
     */
    public function testLast(ModelCollectionInterface $collection, array $valueMap)
    {
        foreach (array_reverse($valueMap, true) as $value){
            $this->assertSame(
                $value,
                $collection->last()
            );
            $collection->pop();
        }

        $this->assertNull(
            $collection->last()
        );

        $this->assertEquals(
            'defaultValue',
            $collection->last('defaultValue')
        );
    }

    /**
     * @dataProvider providerToGettingItems
     * @param ModelCollectionInterface $collection
     * @param array $valueMap
     */
    public function testGet(ModelCollectionInterface $collection, array $valueMap)
    {
        foreach ($valueMap as $key => $value){
            $this->assertSame(
                $value,
                $collection->get($key)
            );
        }

        $this->assertNull(
            $collection->get('nonexistentKey')
        );

        $this->assertEquals(
            'defaultValue',
            $collection->get('nonexistentKey', 'defaultValue')
        );
    }

    /**
     * @dataProvider providerToGettingItems
     * @depends testIsEmpty
     * @param ModelCollectionInterface $collection
     * @param array $valueMap
     */
    public function testPull(ModelCollectionInterface $collection, array $valueMap)
    {
        foreach ($valueMap as $key => $value){
            $this->assertSame(
                $value,
                $collection->pull($key)
            );
        }

        $this->assertTrue(
            $collection->isEmpty()
        );

        $this->assertNull(
            $collection->pull('nonexistentKey')
        );

        $this->assertEquals(
            'defaultValue',
            $collection->pull('nonexistentKey', 'defaultValue')
        );
    }

    /**
     * @dataProvider providerToGettingItems
     * @depends testAll
     * @depends testIsEmpty
     * @param ModelCollectionInterface $collection
     * @param array $valueMap
     */
    public function testOnly(ModelCollectionInterface $collection, array $valueMap)
    {
        foreach (array_chunk($valueMap, 2, true) as $chunk){
            $collectionChunk = $collection->only(array_keys($chunk));
            $this->assertInstanceOf(
                ModelCollectionInterface::class,
                $collectionChunk
            );
            $this->assertSame(
                $chunk,
                $collectionChunk->all()
            );
        }

        $this->assertTrue(
            $collection->only(['nonexistentKey'])->isEmpty()
        );
    }

    /**
     * @dataProvider providerToGettingItems
     * @depends testAll
     * @param ModelCollectionInterface $collection
     * @param array $valueMap
     */
    public function testNot(ModelCollectionInterface $collection, array $valueMap)
    {
        foreach (array_chunk($valueMap, 2, true) as $chunk){
            $collectionChunk = $collection->not(array_keys($chunk));
            $this->assertInstanceOf(
                ModelCollectionInterface::class,
                $collectionChunk
            );
            $this->assertSame(
                array_diff_key($valueMap, $chunk),
                $collectionChunk->all()
            );
        }

        $this->assertSame(
            $valueMap,
            $collection->not(['nonexistentKey'])->all()
        );
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Добавление элемента в коллекцию
     |
     |-------------------------------------------------------------------------------
    */

    /*
     | Data providers
     |-------------------------------------------------------------------------------
    */

    public function providerToAddModel()
    {
        $collectionClass = Env::setUpModelCollection('TestAddCollection', [
            'compatibleModel' => $modelClass = Env::setUpModel('TestAddModel', [
                'properties' => ['name' => 'string', 'mail' => 'string']
            ])
        ]);

        return [
            'models' => [
                'collection' => $collectionClass::make(),
                'added' => [
                    $model1 = $modelClass::make(['Name' => 'User1', 'Mail' => 'user1@mail.com']),
                    $model2 = $modelClass::make(['Name' => 'User2', 'Mail' => 'user2@mail.com']),
                    $model3 = $modelClass::make(['Name' => 'User3', 'Mail' => 'user3@mail.com'])
                ],
                'expectedModels' => [
                    $model1,
                    $model2,
                    $model3
                ],
                'expectedData' => [
                    ['Name' => 'User1', 'Mail' => 'user1@mail.com'],
                    ['Name' => 'User2', 'Mail' => 'user2@mail.com'],
                    ['Name' => 'User3', 'Mail' => 'user3@mail.com']
                ],
            ],
            'array' => [
                'collection' => $collectionClass::make(),
                'added' => [
                    ['Name' => 'User1', 'Mail' => 'user1@mail.com'],
                    ['Name' => 'User2', 'Mail' => 'user2@mail.com'],
                    ['Name' => 'User3', 'Mail' => 'user3@mail.com']
                ],
                'expectedModels' => [
                    ['Name' => 'User1', 'Mail' => 'user1@mail.com'],
                    ['Name' => 'User2', 'Mail' => 'user2@mail.com'],
                    ['Name' => 'User3', 'Mail' => 'user3@mail.com']
                ],
                'expectedData' => [
                    ['Name' => 'User1', 'Mail' => 'user1@mail.com'],
                    ['Name' => 'User2', 'Mail' => 'user2@mail.com'],
                    ['Name' => 'User3', 'Mail' => 'user3@mail.com']
                ]
            ],
            'incompatibleKeys' => [
                'collection' => $collectionClass::make(),
                'added' => ['key1' => $modelClass::make()],
                'expectedModels' => InvalidArgumentException::class,
                'expectedData' => null
            ],
            'incompatibleItems' => [
                'collection' => $collectionClass::make(),
                'added' => ['string instead of array'],
                'expectedModels' => InvalidArgumentException::class,
                'expectedData' => null
            ],
            'incompatibleModels' => [
                'collection' => $collectionClass::make(),
                'added' => [Env::setUpModel('IncompatibleTestModel')::make()],
                'expectedModels' => InvalidArgumentException::class,
                'expectedData' => null
            ]
        ];
    }

    public function providerToPushModel()
    {
        $data = $this->providerToAddModel();
        unset($data['incompatibleKeys']);
        return $data;
    }

    /*
     | Tests
     |-------------------------------------------------------------------------------
    */

    /**
     * @dataProvider providerToAddModel
     * @depends testAll
     * @depends testToArray
     * @param ModelCollectionInterface $collection
     * @param ModelInterface[]|array[] $added
     * @param ModelInterface[]|array[]|string $expectedModels
     * @param array[]|null $expectedData
     */
    public function testArrayAccessSet(ModelCollectionInterface $collection, array $added, $expectedModels, $expectedData = null)
    {
        if (is_string($expectedModels)){
            $this->expectException($expectedModels);
        }

        foreach ($added as $key => $value){
            $collection[$key] = $value;
        }

        $models = $collection->all();
        foreach ($expectedModels as $index => $expectedModel){
            if (is_array($expectedModel)){
                $this->assertSame(
                    $expectedModel,
                    $models[$index]->toArray()
                );
            } else {
                $this->assertSame(
                    $expectedModel,
                    $models[$index]
                );
            }
        }

        $this->assertSame(
            $expectedData,
            $collection->toArray()
        );
    }

    /**
     * @dataProvider providerToAddModel
     * @depends testAll
     * @depends testToArray
     * @param ModelCollectionInterface $collection
     * @param ModelInterface[]|array[] $added
     * @param ModelInterface[]|array[]|string $expectedModels
     * @param array[]|null $expectedData
     */
    public function testSet(ModelCollectionInterface $collection, array $added, $expectedModels, $expectedData = null)
    {
        if (is_string($expectedModels)){
            $this->expectException($expectedModels);
        }

        foreach ($added as $key => $value){
            $collection->set($key, $value);
        }

        $models = $collection->all();
        foreach ($expectedModels as $index => $expectedModel){
            if (is_array($expectedModel)){
                $this->assertSame(
                    $expectedModel,
                    $models[$index]->toArray()
                );
            } else {
                $this->assertSame(
                    $expectedModel,
                    $models[$index]
                );
            }
        }

        $this->assertSame(
            $expectedData,
            $collection->toArray()
        );
    }

    /**
     * @dataProvider providerToAddModel
     * @depends testAll
     * @depends testToArray
     * @param ModelCollectionInterface $collection
     * @param ModelInterface[]|array[] $added
     * @param ModelInterface[]|array[]|string $expectedModels
     * @param array[]|null $expectedData
     */
    public function testAdd(ModelCollectionInterface $collection, array $added, $expectedModels, $expectedData = null)
    {
        if (is_string($expectedModels)){
            $this->expectException($expectedModels);
        }

        foreach ($added as $key => $value){
            $collection->add($key, $value);
        }

        $models = $collection->all();
        foreach ($expectedModels as $index => $expectedModel){
            if (is_array($expectedModel)){
                $this->assertSame(
                    $expectedModel,
                    $models[$index]->toArray()
                );
            } else {
                $this->assertSame(
                    $expectedModel,
                    $models[$index]
                );
            }
        }

        $this->assertSame(
            $expectedData,
            $collection->toArray()
        );
    }

    /**
     * @dataProvider providerToPushModel
     * @depends testAll
     * @depends testToArray
     * @param ModelCollectionInterface $collection
     * @param ModelInterface[]|array[] $added
     * @param ModelInterface[]|array[]|string $expectedModels
     * @param array[]|null $expectedData
     */
    public function testPush(ModelCollectionInterface $collection, array $added, $expectedModels, $expectedData = null)
    {
        if (is_string($expectedModels)){
            $this->expectException($expectedModels);
        }

        foreach ($added as $value){
            $collection->push($value);
        }

        $models = $collection->all();
        foreach ($expectedModels as $index => $expectedModel){
            if (is_array($expectedModel)){
                $this->assertSame(
                    $expectedModel,
                    $models[$index]->toArray()
                );
            } else {
                $this->assertSame(
                    $expectedModel,
                    $models[$index]
                );
            }
        }

        $this->assertSame(
            $expectedData,
            $collection->toArray()
        );
    }


    /*
     |-------------------------------------------------------------------------------
     |
     | Проверка наличия элемента в коллекции по его ключу
     |
     |-------------------------------------------------------------------------------
    */

    /*
     | Data providers
     |-------------------------------------------------------------------------------
    */

    public function providerToCheckExist()
    {
        $collectionClass = Env::setUpModelCollection('TestCheckExistCollection', [
            'compatibleModel' => $modelClass = Env::setUpModel('TestCheckExistModel')
        ]);

        return [
            'trueAndFalse' => [
                'collection' => $collectionClass::make($modelClass::make(),$modelClass::make(),$modelClass::make()),
                'check' => [0,'0',1,'1',2,'2',3,'3'],
                'expected' => [true,true,true,true,true,true,false,false]
            ],
            'onlyTrue' => [
                'collection' => $collectionClass::make($modelClass::make(),$modelClass::make(),$modelClass::make()),
                'check' => [0,'0',1,'1',2,'2'],
                'expected' => [true,true,true,true,true,true]
            ],
            'onlyFalse' => [
                'collection' => $collectionClass::make($modelClass::make(),$modelClass::make(),$modelClass::make()),
                'check' => ['string key', '123'],
                'expected' => [false,false]
            ]
        ];
    }

    /*
     | Tests
     |-------------------------------------------------------------------------------
    */

    /**
     * @dataProvider providerToCheckExist
     * @param ModelCollectionInterface $collection
     * @param array $check
     * @param array $expected
     */
    public function testArrayAccessExists(ModelCollectionInterface $collection, array $check, array $expected)
    {
        foreach ($check as $index => $key){
            $this->assertEquals(
                $expected[$index],
                isset($collection[$key])
            );
        }
    }

    /**
     * @dataProvider providerToCheckExist
     * @param ModelCollectionInterface $collection
     * @param array $check
     * @param array $expected
     */
    public function testHas(ModelCollectionInterface $collection, array $check, array $expected)
    {
        foreach ($check as $index => $key){
            $this->assertEquals(
                $expected[$index],
                $collection->has($key)
            );
        }

        $this->assertEquals(
            min($expected),
            $collection->has($check)
        );
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Удаление элементов из коллекции
     |
     |-------------------------------------------------------------------------------
    */

    /*
     | Data providers
     |-------------------------------------------------------------------------------
    */

    public function providerToRemove()
    {
        $collectionClass = Env::setUpModelCollection('TestRemoveCollection', [
            'compatibleModel' => $modelClass = Env::setUpModel('TestRemoveModel')
        ]);

        return [
            'collection-1' => [
                'collection' => $collectionClass::wrap([
                    $model1 = $modelClass::make(),
                    $model2 = $modelClass::make(),
                    $model3 = $modelClass::make()
                ]),
                'remove' => [0,2],
                'expected' => [1 => $model2]
            ],
            'collection-2' => [
                'collection' => $collectionClass::wrap([
                    '3' => $model1 = $modelClass::make(),
                    '2' => $model2 = $modelClass::make(),
                    '1' => $model3 = $modelClass::make(),
                    '10' => $model4 = $modelClass::make()
                ]),
                'remove' => ['2', '1'],
                'expected' => ['3' => $model1, '10' => $model4]
            ],
            'collection-3' => [
                'collection' => $collectionClass::wrap([
                    $model1 = $modelClass::make(),
                    $model2 = $modelClass::make(),
                    $model3 = $modelClass::make()
                ]),
                'remove' => ['3', 'key', 'key2'],
                'expected' => [$model1, $model2, $model3]
            ]
        ];
    }

    /*
     | Tests
     |-------------------------------------------------------------------------------
    */

    /**
     * @dataProvider providerToRemove
     * @depends testAll
     * @param ModelCollectionInterface $collection
     * @param array $remove
     * @param array $expected
     */
    public function testArrayAccessUnset(ModelCollectionInterface $collection, array $remove, array $expected)
    {
        foreach ($remove as $key){
            unset($collection[$key]);
        }

        $this->assertSame(
            $expected,
            $collection->all()
        );
    }

    /**
     * @dataProvider providerToRemove
     * @depends testAll
     * @param ModelCollectionInterface $collection
     * @param array $remove
     * @param array $expected
     */
    public function testRemoveByKey(ModelCollectionInterface $collection, array $remove, array $expected)
    {
        foreach ($remove as $key){
            $collection->remove($key);
        }

        $this->assertSame(
            $expected,
            $collection->all()
        );
    }

    /**
     * @dataProvider providerToRemove
     * @depends testAll
     * @param ModelCollectionInterface $collection
     * @param array $remove
     * @param array $expected
     */
    public function testRemoveByKeys(ModelCollectionInterface $collection, array $remove, array $expected)
    {
        $this->assertSame(
            $expected,
            $collection->remove($remove)->all()
        );
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Получение среза коллекции
     |
     |-------------------------------------------------------------------------------
    */

    /*
     | Tests
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAll
     */
    public function testInitial()
    {
        $collection = Env::setUpModelCollection('TestCollection', ['compatibleModel' => $modelClass = Env::setUpModel('TestModel')])::wrap([
            $model1 = $modelClass::make(),
            $model2 = $modelClass::make(),
            $model3 = $modelClass::make(),
            $model4 = $modelClass::make()
        ]);

        $this->assertSame(
            [$model1,$model2,$model3],
            $collection->initial()->all()
        );

        $this->assertSame(
            [$model1,$model2],
            $collection->initial(2)->all()
        );
    }

    /**
     * @depends testAll
     */
    public function testTail()
    {
        $collection = Env::setUpModelCollection('TestCollection', ['compatibleModel' => $modelClass = Env::setUpModel('TestModel')])::wrap([
            $model1 = $modelClass::make(),
            $model2 = $modelClass::make(),
            $model3 = $modelClass::make(),
            $model4 = $modelClass::make()
        ]);

        $this->assertSame(
            [1 => $model2, 2 => $model3, 3 => $model4],
            $collection->tail()->all()
        );

        $this->assertSame(
            [2 => $model3, 3 => $model4],
            $collection->tail(2)->all()
        );
    }

    /**
     * @depends testAll
     */
    public function testSlice()
    {

        $collection = Env::setUpModelCollection('TestCollection', ['compatibleModel' => $modelClass = Env::setUpModel('TestModel')])::wrap($models = [
            $modelClass::make(),
            $modelClass::make(),
            $modelClass::make(),
            $modelClass::make()
        ]);

        $this->assertSame(
            array_slice($models, 0, null, true),
            $collection->slice(0)->all()
        );

        $this->assertSame(
            array_slice($models, 1, 2, true),
            $collection->slice(1, 2)->all()
        );
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Конвертация коллекции
     |
     |-------------------------------------------------------------------------------
    */

    /*
     | Data providers
     |-------------------------------------------------------------------------------
    */

    public function providerToConversionCollection()
    {
        $collectionClass = Env::setUpModelCollection('TestConversionCollection', [
            'compatibleModel' => $modelClass = Env::setUpModel('TestConversionModel', [
                'properties' => [
                    'name' => 'string',
                    'phone' => 'integer',
                    'mail' => 'string',
                ]
            ])
        ]);

        return [
            'empty' => [
                'collection' => $collectionClass::make(),
                'constructor' => [],
                'expected' => []
            ],
            'collection-1' => [
                'collection' => $collectionClass::wrap([
                    $modelClass::make(['Name' => 'Alex', 'Phone' => '79631111111', 'Mail' => 'alex@mail.com']),
                    $modelClass::make(['name' => 'Daniel', 'phone' => '79632222222', 'mail' => 'daniel@mail.com']),
                    $modelClass::make(['name' => 'Harry', 'phone' => '79634444444', 'mail' => 'harry@mail.com'])
                ]),
                'source' => [
                    ['Name' => 'Alex', 'Phone' => 79631111111, 'Mail' => 'alex@mail.com'],
                    ['Name' => 'Daniel', 'Phone' => 79632222222, 'Mail' => 'daniel@mail.com'],
                    ['Name' => 'Harry', 'Phone' => 79634444444, 'Mail' => 'harry@mail.com']
                ]
            ],
            'collection-2' => [
                'collection' => $collectionClass::wrap([
                    '5' => $modelClass::make(['Name' => 'Alex', 'Phone' => '79631111111', 'Mail' => 'alex@mail.com']),
                    '11' => $modelClass::make(['name' => 'Daniel', 'phone' => '79632222222', 'mail' => 'daniel@mail.com']),
                    '2' => $modelClass::make(['name' => 'Harry', 'phone' => '79634444444', 'mail' => 'harry@mail.com'])
                ]),
                'source' => [
                    '5' => ['Name' => 'Alex', 'Phone' => 79631111111, 'Mail' => 'alex@mail.com'],
                    '11' => ['Name' => 'Daniel', 'Phone' => 79632222222, 'Mail' => 'daniel@mail.com'],
                    '2' => ['Name' => 'Harry', 'Phone' => 79634444444, 'Mail' => 'harry@mail.com']
                ]
            ]
        ];
    }

    /*
     | Tests
     |-------------------------------------------------------------------------------
    */

    /**
     * @dataProvider providerToConversionCollection
     * @param ModelCollectionInterface $collection
     * @param array $source
     */
    public function testAll(ModelCollectionInterface $collection, array $source)
    {
        $models = $collection->all();
        $array = [];

        $this->assertIsArray($models);

        foreach ($models as $key => $model){
            $this->assertInstanceOf(ModelInterface::class, $model);
            $array[$key] = $model->toArray();
        }

        $this->assertEquals(
            $source,
            $array
        );
    }

    /**
     * @dataProvider providerToConversionCollection
     * @param ModelCollectionInterface $collection
     * @param array $source
     */
    public function testUnwrap(ModelCollectionInterface $collection, array $source)
    {
        $models = $collection->unwrap();
        $array = [];

        $this->assertIsArray($models);

        foreach ($models as $key => $model){
            $this->assertInstanceOf(ModelInterface::class, $model);
            $array[$key] = $model->toArray();
        }

        $this->assertEquals(
            $source,
            $array
        );
    }

    /**
     * @dataProvider providerToConversionCollection
     * @param ModelCollectionInterface $collection
     * @param array $source
     */
    public function testToArray(ModelCollectionInterface $collection, array $source)
    {
        $this->assertEquals(
            $source,
            $collection->toArray()
        );
    }

    /**
     * @dataProvider providerToConversionCollection
     * @param ModelCollectionInterface $collection
     * @param array $source
     */
    public function testToData(ModelCollectionInterface $collection, array $source)
    {
        $this->assertEquals(
            Data::wrap($source)->toArray(),
            $collection->toData()->toArray()
        );
    }

    /**
     * @dataProvider providerToConversionCollection
     * @param ModelCollectionInterface $collection
     * @param array $source
     */
    public function testToJson(ModelCollectionInterface $collection, array $source)
    {
        $this->assertEquals(
            json_encode($source, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
            $collection->toJson()
        );
    }

    /**
     * @dataProvider providerToConversionCollection
     * @param ModelCollectionInterface $collection
     * @param array $source
     */
    public function testToString(ModelCollectionInterface $collection, array $source)
    {
        $this->assertEquals(
            json_encode($source, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
            (string) $collection
        );
    }

    /**
     * @dataProvider providerToConversionCollection
     * @param ModelCollectionInterface $collection
     * @param array $source
     */
    public function testHash(ModelCollectionInterface $collection, array $source)
    {
        $this->assertEquals(
            sha1(json_encode($source, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)),
            $collection->hash()
        );
    }

    /**
     * @dataProvider providerToConversionCollection
     * @param ModelCollectionInterface $collection
     * @param array $source
     */
    public function testKeys(ModelCollectionInterface $collection, array $source)
    {
        $this->assertEquals(
            array_keys($source),
            $collection->keys()
        );
    }

    /**
     * @dataProvider providerToConversionCollection
     * @param ModelCollectionInterface $collection
     * @param array $source
     */
    public function testValues(ModelCollectionInterface $collection, array $source)
    {
        $models = $collection->values();
        $array = [];

        $this->assertIsArray($models);

        foreach ($models as $key => $model){
            $this->assertInstanceOf(ModelInterface::class, $model);
            $array[$key] = $model->toArray();
        }

        $this->assertEquals(
            array_values($source),
            $array
        );
    }

    /**
     * @dataProvider providerToConversionCollection
     * @param ModelCollectionInterface $collection
     * @param array $source
     */
    public function testDivide(ModelCollectionInterface $collection, array $source)
    {
        list($keys, $models) = $collection->divide();

        $this->assertEquals(
            array_keys($source),
            $keys
        );

        $array = [];
        $this->assertIsArray($models);

        foreach ($models as $key => $model){
            $this->assertInstanceOf(ModelInterface::class, $model);
            $array[$key] = $model->toArray();
        }

        $this->assertEquals(
            array_values($source),
            $array
        );
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Клонирование коллекции
     |
     |-------------------------------------------------------------------------------
    */

    /*
     | Data providers
     |-------------------------------------------------------------------------------
    */

    public function providerToCloningCollection()
    {
        $collectionClass = Env::setUpModelCollection('TestCloningCollection', [
            'compatibleModel' => $modelClass = Env::setUpModel('TestCloningModel', [
                'properties' => [
                    'name' => 'string',
                    'phone' => 'integer',
                    'mail' => 'string',
                ]
            ])
        ]);

        return [
            'empty' => [
                $collectionClass::make()
            ],
            'collection' => [
                $collectionClass::wrap([
                    $modelClass::make(['Name' => 'Alex', 'Phone' => '79631111111', 'Mail' => 'alex@mail.com']),
                    $modelClass::make(['name' => 'Daniel', 'phone' => '79632222222', 'mail' => 'daniel@mail.com']),
                    $modelClass::make(['name' => 'Harry', 'phone' => '79634444444', 'mail' => 'harry@mail.com'])
                ])
            ]
        ];
    }

    /*
     | Tests
     |-------------------------------------------------------------------------------
    */

    /**
     * @dataProvider providerToCloningCollection
     * @depends testIteratorAggregate
     * @depends testArrayAccessGet
     * @depends testToArray
     * @param ModelCollectionInterface $originalCollection
     */
    public function testCopy(ModelCollectionInterface $originalCollection)
    {
        $this->assertNotSame(
            $originalCollection,
            $cloneCollection = $originalCollection->copy()
        );

        $this->assertInstanceOf(
            ModelCollectionInterface::class,
            $cloneCollection
        );

        foreach ($originalCollection as $index => $originalModel){
            $cloneModel = $cloneCollection[$index];

            $this->assertNotSame(
                $originalModel,
                $cloneModel
            );

            $this->assertInstanceOf(
                ModelInterface::class,
                $cloneModel
            );
        }

        $this->assertSame(
            $originalCollection->toArray(),
            $cloneCollection->toArray()
        );
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Выборка значений свойст моделей из коллекции
     |
     |-------------------------------------------------------------------------------
    */

    /*
     | Data providers
     |-------------------------------------------------------------------------------
    */

    public function providerToExtractingCollection()
    {
        $collectionClass = Env::setUpModelCollection('TestExtractingCollection', [
            'compatibleModel' => $modelClass = Env::setUpModel('TestExtractingModel', [
                'properties' => [
                    'name' => 'string',
                    'phone' => 'integer',
                    'mail' => 'string',
                ]
            ])
        ]);

        return [
            'propertyFromEmptyCollection' => [
                'collection' => $collectionClass::make(),
                'extract' => 'name',
                'expected' => []
            ],
            'propertiesFromEmptyCollection' => [
                'collection' => $collectionClass::make(),
                'extract' => ['Name', 'phone'],
                'expected' => []
            ],
            'propertyFromFullCollection' => [
                'collection' => $collectionClass::wrap([
                    $modelClass::make(['Name' => 'Alex', 'Phone' => '79631111111', 'Mail' => 'alex@mail.com']),
                    $modelClass::make(['name' => 'Daniel', 'phone' => '79632222222', 'mail' => 'daniel@mail.com']),
                    $modelClass::make(['name' => 'Harry', 'phone' => '79634444444', 'mail' => 'harry@mail.com'])
                ]),
                'extract' => 'name',
                'expected' => ['Alex','Daniel','Harry']
            ],
            'propertiesFromFullCollection' => [
                'collection' => $collectionClass::wrap([
                    $modelClass::make(['Name' => 'Alex', 'Phone' => '79631111111', 'Mail' => 'alex@mail.com']),
                    $modelClass::make(['name' => 'Daniel', 'phone' => '79632222222', 'mail' => 'daniel@mail.com']),
                    $modelClass::make(['name' => 'Harry', 'phone' => '79634444444', 'mail' => 'harry@mail.com'])
                ]),
                'extract' => ['Name','phone'],
                'expected' => [
                    ['Name' => 'Alex', 'phone' => 79631111111],
                    ['Name' => 'Daniel', 'phone' => 79632222222],
                    ['Name' => 'Harry', 'phone' => 79634444444],
                ]
            ],
            'unsetProperty' => [
                'collection' => $collectionClass::wrap([
                    $modelClass::make(['Name' => 'Alex', 'Phone' => 79631111111, 'Mail' => 'alex@mail.com']),
                    $modelClass::make(['name' => 'Daniel', 'mail' => 'daniel@mail.com']),
                    $modelClass::make(['name' => 'Harry', 'mail' => 'harry@mail.com'])
                ]),
                'extract' => 'phone',
                'expected' => [79631111111,null,null]
            ],
            'nonexistentProperty' => [
                'collection' => $collectionClass::wrap([
                    $modelClass::make(['Name' => 'Alex', 'Phone' => '79631111111', 'Mail' => 'alex@mail.com']),
                    $modelClass::make(['name' => 'Daniel', 'phone' => '79632222222', 'mail' => 'daniel@mail.com']),
                    $modelClass::make(['name' => 'Harry', 'phone' => '79634444444', 'mail' => 'harry@mail.com'])
                ]),
                'extract' => ['Name','Phone','TEST'],
                'expected' => ModelException::class
            ]
        ];
    }

    /*
     | Tests
     |-------------------------------------------------------------------------------
    */

    /**
     * @dataProvider providerToExtractingCollection
     * @param ModelCollectionInterface $collection
     * @param string|array $extract
     * @param array $expected
     */
    public function testExtract(ModelCollectionInterface $collection, $extract, $expected)
    {
        if (is_string($expected)){
            $this->expectException($expected);
            $collection->extract($extract);
        } else {
            $this->assertSame(
                $expected,
                $collection->extract($extract)
            );
        }
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Вызов перезагружаемых методов коллекции
     |
     |-------------------------------------------------------------------------------
    */

    /*
     | Tests
     |-------------------------------------------------------------------------------
    */

    public function testCall()
    {
        $collectionClass = Env::setUpModelCollection('TestExtractingCollection', [
            'compatibleModel' => $modelClass = Env::setUpModel('TestExtractingModel'),
            'methods' => ['checkMethod' => static::class],
            'staticMethods' => ['checkMethod' => static::class]
        ]);

        $this->assertSame(
            ['arg-1','arg-2','arg-3'],
            $collectionClass::{'checkMethod'}('arg-1','arg-2','arg-3')
        );

        $collection = $collectionClass::make();
        $this->assertSame(
            [$collection, 'arg-1','arg-2','arg-3'],
            $collection->{'checkMethod'}('arg-1','arg-2','arg-3')
        );
    }

    public static function checkMethod(...$arguments)
    {
        return $arguments;
    }
}