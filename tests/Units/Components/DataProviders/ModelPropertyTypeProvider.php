<?php


namespace YandexDirectSDKTest\Units\Components\DataProviders;


use Exception;
use UPTools\Arr;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\ModelException;
use YandexDirectSDKTest\Helpers\Env;

trait ModelPropertyTypeProvider
{
    /**
     * Структуры данных для тестирования:
     *
     *  [
     *      propertyType => string|array,
     *      tests => [
     *          [
     *              values => mixed|mixed[],
     *              expected => [
     *                  toInsert => mixed|mixed[],
     *                  toSet => mixed|mixed[],
     *                  toGet => mixed|mixed[],
     *                  toConvert => mixed|mixed[]
     *              ]
     *          ]
     *  ]
     *
     * propertyType:                тип/типы свойства модели для которого выполняется тестирование;
     *
     * tests:                       набор тестов;
     *
     * tests.*.values:              значение или набор значение для выполнения тестирования
     *
     * tests.*.expected:            ожиданые результаты тестирования
     *
     * tests.*.expected.toInsert:   если значение из установленного набора (values) будет вставленно в модель с использование метода
     *                              insert(), то текущая модель должна содержать соотвествующее значение из набора toInsert
     *
     * tests.*.expected.toSet:      если значение из установленного набора (values) будет вставленно в модель с использование метода
     *                              setPropertyValue(), то текущая модель должна содержать соотвествующее значение из набора toSet
     *
     * tests.*.expected.toGet:      если модель содержит значение из установленного набора (values), то метод getPropertyValue()
     *                              должен возвращать значение соответствующее элементу набора toGet.
     *
     * tests.*.expected.toConvert:  если модель содержит значение из установленного набора (values), то метод toArray()
     *                              должен возвращать значение соответствующее элементу набора toConvert
     *
     * @param string $forSet
     * @return array
     */
    public function modelPropertyTypeProvider(string $forSet): array
    {
        $collectionClass = Env::setUpModelCollection('PropertyTypeProviderCollection', [
            'compatibleModel' => $modelClass = Env::setUpModel('PropertyTypeProviderModel',[
                'properties' => [
                    'i' => 'integer',
                    's' => 'string',
                    'f' => 'float',
                    'b' => 'boolean'
                ]
            ])
        ]);
        $altCollectionClass = Env::setUpModelCollection('PropertyTypeProviderAltCollection', [
            'compatibleModel' => $altModelClass = Env::setUpModel('PropertyTypeProviderAltModel',[
                'properties' => [
                    'i' => 'integer',
                    's' => 'string',
                    'f' => 'float',
                    'b' => 'boolean'
                ]
            ])
        ]);

        $model1 = $modelClass::make(['i'=>12, 's'=>'text', 'f'=>3.14, 'b'=>true]);
        $model2 = $modelClass::make(['i'=>12, 's'=>'text', 'f'=>3.14, 'b'=>true]);
        $collection1 = $collectionClass::make($model1, $model2);
        $collection2 = $collectionClass::make($model1, $model2);

        $emptyModel = $modelClass::make();
        $emptyCollection = $collectionClass::make();

        $altModel = $altModelClass::make(['i'=>12, 's'=>'text', 'f'=>3.14, 'b'=>true]);
        $altCollection = $altCollectionClass::make($altModel);

        $testData = [];
        $testSets = [
            // bool, bool
            // --------------------------------
            [
                'propertyType' => ['boolean','bool'],
                'tests' => [
                    [
                        'values' => [null, true, 'true', 1, '1', false, 'false', 0, '0'],
                        'expected' => [
                            'toInsert' => [null, true, true, true, true, false, false, false, false],
                            'toSet' => [null, true, true, true, true, false, false, false, false]
                        ]
                    ],
                    [
                        'values' => [true, false],
                        'expected' => [
                            'toGet' => [true, false],
                            'toConvert' => [true, false]
                        ]
                    ],
                    [
                        'values' => ['string', 123, 2.5, 0.0, [1,2,3]],
                        'expected' => [
                            'toInsert' => InvalidArgumentException::class,
                            'toSet' => InvalidArgumentException::class,
                        ]
                    ]
                ],
            ],

            // string
            // --------------------------------
            [
                'propertyType' => 'string',
                'tests' => [
                    [
                        'values' => [null, true, false, 'str', 123, 12.5, 0],
                        'expected' => [
                            'toInsert' => [null, '1', '', 'str', '123', '12.5', '0'],
                            'toSet' => [null, '1', '', 'str', '123', '12.5', '0'],
                        ]
                    ],
                    [
                        'values' => ['1', '', 'str', '123', '12.5', '0'],
                        'expected' => [
                            'toGet' => ['1', '', 'str', '123', '12.5', '0'],
                            'toConvert' => ['1', '', 'str', '123', '12.5', '0']
                        ]
                    ],
                    [
                        'values' => [[1,2,3], ['str1','str2']],
                        'expected' => [
                            'toInsert' => InvalidArgumentException::class,
                            'toSet' => InvalidArgumentException::class,
                        ]
                    ],
                ],
            ],

            // float, double
            // --------------------------------
            [
                'propertyType' => ['float','double'],
                'tests' => [
                    [
                        'values' => [null, 123, '123', 12.5, '12.5', 0, '0'],
                        'expected' => [
                            'toInsert' => [null, 123.0, 123.0, 12.5, 12.5, 0.0, 0.0],
                            'toSet' => [null, 123.0, 123.0, 12.5, 12.5, 0.0, 0.0]
                        ]
                    ],
                    [
                        'values' => [123.0, 123.0, 12.5, 12.5, 0.0, 0.0],
                        'expected' => [
                            'toGet' => [123.0, 123.0, 12.5, 12.5, 0.0, 0.0],
                            'toConvert' => [123.0, 123.0, 12.5, 12.5, 0.0, 0.0]
                        ]
                    ],
                    [
                        'values' => [true, false, 'str', [1,2,3], ['str1','str2']],
                        'expected' => [
                            'toInsert' => InvalidArgumentException::class,
                            'toSet' => InvalidArgumentException::class
                        ]
                    ],
                ],
            ],

            // integer, int
            // --------------------------------
            [
                'propertyType' => ['integer','int'],
                'tests' => [
                    [
                        'values' => [null, 123, '123', 12.5, '12.5', 0, '0'],
                        'expected' => [
                            'toInsert' => [null, 123, 123, 12, 12, 0, 0],
                            'toSet' => [null, 123, 123, 12, 12, 0, 0],
                        ]
                    ],
                    [
                        'values' => [123, 123, 12, 12, 0, 0],
                        'expected' => [
                            'toGet' => [123, 123, 12, 12, 0, 0],
                            'toConvert' => [123, 123, 12, 12, 0, 0]
                        ]
                    ],
                    [
                        'values' => [true, false, 'str', [1,2,3], ['str1','str2']],
                        'expected' => [
                            'toInsert' => InvalidArgumentException::class,
                            'toSet' => InvalidArgumentException::class,
                        ]
                    ],
                ],
            ],

            // array:[string|float|integer]
            // --------------------------------
            // Данный тип свойства и все его производные (arrayOfSet, arrayOfEnum, arrayOfObject)
            // в качестве базовой структуры данных предполагает массив, в котором все элементы объеденены
            // единственным ключем [Items].
            [
                'propertyType' => 'array',
                'tests' => [

                    // Если осуществляется импорт данных с использованием метода insert или make, то структура
                    // входного массива должна содержать ключ объединения [Items], в противном случае будет вызванно
                    // исключение YandexDirectSDK\Exceptions\InvalidArgumentException. При этом значение свойства в
                    // составе данных модели сохраняется без ключа [Items].

                    // При установки данных в свойство с использованием метода setPropertyValue и его производных,
                    // ключ [Items] не обрабытывается, данные сохраняются в свойство как есть.
                    [
                        'values' => [
                            null,
                            [],
                            [1,2,3],
                            ['str1','str2'],
                            [$model1,$model2],
                            [$collection1,$collection2],
                            ['Items' => []],
                            ['Items' => [1,2,3]],
                            ['Items' => ['str1','str2']],
                            ['Items' => [$model1,$model2]],
                            ['Items' => [$collection1,$collection2]]
                        ],
                        'expected' => [
                            'toInsert' => [
                                null,
                                InvalidArgumentException::class,
                                InvalidArgumentException::class,
                                InvalidArgumentException::class,
                                InvalidArgumentException::class,
                                InvalidArgumentException::class,
                                [],
                                [1,2,3],
                                ['str1','str2'],
                                [$model1,$model2],
                                [$collection1,$collection2],
                            ],
                            'toSet' => [
                                null,
                                [],
                                [1,2,3],
                                ['str1','str2'],
                                [$model1,$model2],
                                [$collection1,$collection2],
                                ['Items' => []],
                                ['Items' => [1,2,3]],
                                ['Items' => ['str1','str2']],
                                ['Items' => [$model1,$model2]],
                                ['Items' => [$collection1,$collection2]]
                            ]
                        ]
                    ],

                    // Если выполняется экспорт данных из свойства с использвованием метода toArray и его производных
                    // (toData, toJson), то производится обратных процесс импорта. Формируется массив с единственным
                    // ключем [Items] к которому присваивается текущее значение свойства.

                    // При получении данных с использованием метода getPropertyValue и его производных, значение
                    // свойства возвращается как есть (без изменений).
                    [
                        'values' => [
                            null,
                            [],
                            [1,2,3],
                            ['str1','str2'],
                            [$model1,$model2],
                            [$collection1,$collection2],
                            ['Items' => []],
                            ['Items' => [1,2,3]],
                            ['Items' => ['str1','str2']],
                            ['Items' => [$model1,$model2]],
                            ['Items' => [$collection1,$collection2]]
                        ],
                        'expected' => [
                            'toGet' => [
                                null,
                                [],
                                [1,2,3],
                                ['str1','str2'],
                                [$model1,$model2],
                                [$collection1,$collection2],
                                ['Items' => []],
                                ['Items' => [1,2,3]],
                                ['Items' => ['str1','str2']],
                                ['Items' => [$model1,$model2]],
                                ['Items' => [$collection1,$collection2]]
                            ],
                            'toConvert' => [
                                null,
                                ['Items' => []],
                                ['Items' => [1,2,3]],
                                ['Items' => ['str1','str2']],
                                ['Items' => [$model1,$model2]],
                                ['Items' => [$collection1,$collection2]],
                                ['Items' => [
                                    'Items' => []
                                ]],
                                ['Items' => [
                                    'Items' => [1,2,3]
                                ]],
                                ['Items' => [
                                    'Items' => ['str1','str2']
                                ]],
                                ['Items' => [
                                    'Items' => [$model1,$model2]
                                ]],
                                ['Items' => [
                                    'Items' => [$collection1,$collection2]
                                ]]
                            ]
                        ]
                    ],

                    // Попытка передать в свойство значение отличное от массива, вызовет исключение
                    // YandexDirectSDK\Exceptions\InvalidArgumentException
                    [
                        'values' => [true, false, 'str', 123, 12.5, 0],
                        'expected' => [
                            'toInsert' => InvalidArgumentException::class,
                            'toSet' => InvalidArgumentException::class,
                        ]
                    ]
                ]
            ],
            [
                'propertyType' => 'array:string',
                'tests' => [
                    [
                        'values' => [
                            null,
                            [1.2,1.2],
                            ['str1','str2'],
                            [1,2,3]
                        ],
                        'expected' => [
                            'toInsert' => [
                                null,
                                InvalidArgumentException::class,
                                InvalidArgumentException::class,
                                InvalidArgumentException::class
                            ],
                            'toSet' => [
                                null,
                                InvalidArgumentException::class,
                                ['str1','str2'],
                                InvalidArgumentException::class
                            ]
                        ]
                    ],
                    [
                        'values' => [
                            null,
                            ['Items' => [1.1,1.2]],
                            ['Items' => ['str1','str2']],
                            ['Items' => [1,2,3]]
                        ],
                        'expected' => [
                            'toInsert' => [
                                null,
                                InvalidArgumentException::class,
                                ['str1','str2'],
                                InvalidArgumentException::class
                            ],
                            'toSet' => [
                                null,
                                InvalidArgumentException::class,
                                InvalidArgumentException::class,
                                InvalidArgumentException::class
                            ]
                        ]
                    ],
                    [
                        'values' => [
                            null,
                            ['str1','str2'],
                        ],
                        'expected' => [
                            'toGet' => [
                                null,
                                ['str1','str2'],
                            ],
                            'toConvert' => [
                                null,
                                ['Items' => ['str1','str2']],
                            ]
                        ]
                    ],
                    [
                        'values' => [true, false, 'str', 123, 12.5, 0],
                        'expected' => [
                            'toInsert' => InvalidArgumentException::class,
                            'toSet' => InvalidArgumentException::class,
                        ]
                    ]
                ]
            ],
            [
                'propertyType' => ['array:float','array:double'],
                'tests' => [
                    [
                        'values' => [
                            null,
                            [1.1,1.2],
                            ['str1','str2'],
                            [1,2,3]
                        ],
                        'expected' => [
                            'toInsert' => [
                                null,
                                InvalidArgumentException::class,
                                InvalidArgumentException::class,
                                InvalidArgumentException::class
                            ],
                            'toSet' => [
                                null,
                                [1.1,1.2],
                                InvalidArgumentException::class,
                                InvalidArgumentException::class
                            ]
                        ]
                    ],
                    [
                        'values' => [
                            null,
                            ['Items' => [1.1,1.2]],
                            ['Items' => ['str1','str2']],
                            ['Items' => [1,2,3]]
                        ],
                        'expected' => [
                            'toInsert' => [
                                null,
                                [1.1,1.2],
                                InvalidArgumentException::class,
                                InvalidArgumentException::class
                            ],
                            'toSet' => [
                                null,
                                InvalidArgumentException::class,
                                InvalidArgumentException::class,
                                InvalidArgumentException::class
                            ]
                        ]
                    ],
                    [
                        'values' => [
                            null,
                            [1.1,1.2],
                        ],
                        'expected' => [
                            'toGet' => [
                                null,
                                [1.1,1.2],
                            ],
                            'toConvert' => [
                                null,
                                ['Items' => [1.1,1.2]],
                            ]
                        ]
                    ],
                    [
                        'values' => [true, false, 'str', 123, 12.5, 0],
                        'expected' => [
                            'toInsert' => InvalidArgumentException::class,
                            'toSet' => InvalidArgumentException::class,
                        ]
                    ]
                ]
            ],
            [
                'propertyType' => ['array:integer','array:int'],
                'tests' => [
                    [
                        'values' => [
                            null,
                            [1.2,1.2],
                            ['str1','str2'],
                            [1,2,3]
                        ],
                        'expected' => [
                            'toInsert' => [
                                null,
                                InvalidArgumentException::class,
                                InvalidArgumentException::class,
                                InvalidArgumentException::class
                            ],
                            'toSet' => [
                                null,
                                InvalidArgumentException::class,
                                InvalidArgumentException::class,
                                [1,2,3]
                            ]
                        ]
                    ],
                    [
                        'values' => [
                            null,
                            ['Items' => [1.1,1.2]],
                            ['Items' => ['str1','str2']],
                            ['Items' => [1,2,3]]
                        ],
                        'expected' => [
                            'toInsert' => [
                                null,
                                InvalidArgumentException::class,
                                InvalidArgumentException::class,
                                [1,2,3]
                            ],
                            'toSet' => [
                                null,
                                InvalidArgumentException::class,
                                InvalidArgumentException::class,
                                InvalidArgumentException::class
                            ]
                        ]
                    ],
                    [
                        'values' => [
                            null,
                            [1,2,3],
                        ],
                        'expected' => [
                            'toGet' => [
                                null,
                                [1,2,3],
                            ],
                            'toConvert' => [
                                null,
                                ['Items' => [1,2,3]],
                            ]
                        ]
                    ],
                    [
                        'values' => [true, false, 'str', 123, 12.5, 0],
                        'expected' => [
                            'toInsert' => InvalidArgumentException::class,
                            'toSet' => InvalidArgumentException::class,
                        ]
                    ]
                ]
            ],

            // stack:[string|float|integer|array]
            // --------------------------------
            // Данный тип свойства в качестве базовой структуры данных предполагает массив без использования
            // ключа объединения элементов [Items].
            [
                'propertyType' => 'stack',
                'tests' => [

                    // Методы импорта (import, make) и установки данных (setPropertyValue и его производные),
                    // ожидают массив стуктура которого не имеет индивидуальных отличий для каждого типа методов.
                    [
                        'values' => [
                            null,
                            [],
                            [1,2,3],
                            ['str1','str2'],
                            [$model1,$model2],
                            [$collection1,$collection2],
                            ['Items' => [1,2,3]],
                            ['Items' => ['str1','str2']]
                        ],
                        'expected' => [
                            'toInsert' => [
                                null,
                                [],
                                [1,2,3],
                                ['str1','str2'],
                                [$model1,$model2],
                                [$collection1,$collection2],
                                ['Items' => [1,2,3]],
                                ['Items' => ['str1','str2']]
                            ],
                            'toSet' => [
                                null,
                                [],
                                [1,2,3],
                                ['str1','str2'],
                                [$model1,$model2],
                                [$collection1,$collection2],
                                ['Items' => [1,2,3]],
                                ['Items' => ['str1','str2']]
                            ]
                        ]
                    ],

                    // Методы экспорта данные (toArray и его производных) и получения данных
                    // (getPropertyValue и его производныз).
                    [
                        'values' => [
                            null,
                            [],
                            [1,2,3],
                            ['str1','str2'],
                            [$model1,$model2],
                            [$collection1,$collection2],
                            ['Items' => [1,2,3]],
                            ['Items' => ['str1','str2']]
                        ],
                        'expected' => [
                            'toGet' => [
                                null,
                                [],
                                [1,2,3],
                                ['str1','str2'],
                                [$model1,$model2],
                                [$collection1,$collection2],
                                ['Items' => [1,2,3]],
                                ['Items' => ['str1','str2']]
                            ],
                            'toConvert' => [
                                null,
                                [],
                                [1,2,3],
                                ['str1','str2'],
                                [$model1,$model2],
                                [$collection1,$collection2],
                                ['Items' => [1,2,3]],
                                ['Items' => ['str1','str2']]
                            ]
                        ]
                    ],

                    // Попытка передать в свойство значение отличное от массива, вызовет исключение
                    // YandexDirectSDK\Exceptions\InvalidArgumentException
                    [
                        'values' => [true, false, 'str', 123, 12.5, 0],
                        'expected' => [
                            'toInsert' => InvalidArgumentException::class,
                            'toSet' => InvalidArgumentException::class,
                        ]
                    ]
                ]
            ],
            [
                'propertyType' => 'stack:string',
                'tests' => [
                    [
                        'values' => [
                            null,
                            [],
                            [1.2,1.2],
                            ['str1','str2'],
                            [1,2,3],
                            ['Items' => [1.1,1.2]],
                            ['Items' => ['str1','str2']],
                            ['Items' => [1,2,3]]
                        ],
                        'expected' => [
                            'toInsert' => [
                                null,
                                [],
                                InvalidArgumentException::class,
                                ['str1','str2'],
                                InvalidArgumentException::class,
                                InvalidArgumentException::class,
                                InvalidArgumentException::class,
                                InvalidArgumentException::class
                            ],
                            'toSet' => [
                                null,
                                [],
                                InvalidArgumentException::class,
                                ['str1','str2'],
                                InvalidArgumentException::class,
                                InvalidArgumentException::class,
                                InvalidArgumentException::class,
                                InvalidArgumentException::class
                            ]
                        ]
                    ],
                    [
                        'values' => [
                            null,
                            [],
                            ['str1','str2'],
                        ],
                        'expected' => [
                            'toGet' => [
                                null,
                                [],
                                ['str1','str2'],
                            ],
                            'toConvert' => [
                                null,
                                [],
                                ['str1','str2'],
                            ]
                        ]
                    ],
                    [
                        'values' => [true, false, 'str', 123, 12.5, 0],
                        'expected' => [
                            'toInsert' => InvalidArgumentException::class,
                            'toSet' => InvalidArgumentException::class,
                        ]
                    ]
                ]
            ],
            [
                'propertyType' => ['stack:float','stack:double'],
                'tests' => [
                    [
                        'values' => [
                            null,
                            [],
                            [1.2,1.2],
                            ['str1','str2'],
                            [1,2,3],
                            ['Items' => [1.1,1.2]],
                            ['Items' => ['str1','str2']],
                            ['Items' => [1,2,3]]
                        ],
                        'expected' => [
                            'toInsert' => [
                                null,
                                [],
                                [1.2,1.2],
                                InvalidArgumentException::class,
                                InvalidArgumentException::class,
                                InvalidArgumentException::class,
                                InvalidArgumentException::class,
                                InvalidArgumentException::class
                            ],
                            'toSet' => [
                                null,
                                [],
                                [1.2,1.2],
                                InvalidArgumentException::class,
                                InvalidArgumentException::class,
                                InvalidArgumentException::class,
                                InvalidArgumentException::class,
                                InvalidArgumentException::class
                            ]
                        ]
                    ],
                    [
                        'values' => [
                            null,
                            [],
                            [1.2,1.2],
                        ],
                        'expected' => [
                            'toGet' => [
                                null,
                                [],
                                [1.2,1.2],
                            ],
                            'toConvert' => [
                                null,
                                [],
                                [1.2,1.2],
                            ]
                        ]
                    ],
                    [
                        'values' => [true, false, 'str', 123, 12.5, 0],
                        'expected' => [
                            'toInsert' => InvalidArgumentException::class,
                            'toSet' => InvalidArgumentException::class,
                        ]
                    ]
                ]
            ],
            [
                'propertyType' => ['stack:integer','stack:int'],
                'tests' => [
                    [
                        'values' => [
                            null,
                            [],
                            [1.2,1.2],
                            ['str1','str2'],
                            [1,2,3],
                            ['Items' => [1.1,1.2]],
                            ['Items' => ['str1','str2']],
                            ['Items' => [1,2,3]]
                        ],
                        'expected' => [
                            'toInsert' => [
                                null,
                                [],
                                InvalidArgumentException::class,
                                InvalidArgumentException::class,
                                [1,2,3],
                                InvalidArgumentException::class,
                                InvalidArgumentException::class,
                                InvalidArgumentException::class
                            ],
                            'toSet' => [
                                null,
                                [],
                                InvalidArgumentException::class,
                                InvalidArgumentException::class,
                                [1,2,3],
                                InvalidArgumentException::class,
                                InvalidArgumentException::class,
                                InvalidArgumentException::class
                            ]
                        ]
                    ],
                    [
                        'values' => [
                            null,
                            [],
                            [1,2,3],
                        ],
                        'expected' => [
                            'toGet' => [
                                null,
                                [],
                                [1,2,3],
                            ],
                            'toConvert' => [
                                null,
                                [],
                                [1,2,3],
                            ]
                        ]
                    ],
                    [
                        'values' => [true, false, 'str', 123, 12.5, 0],
                        'expected' => [
                            'toInsert' => InvalidArgumentException::class,
                            'toSet' => InvalidArgumentException::class,
                        ]
                    ]
                ]
            ],
            [
                'propertyType' => 'stack:array',
                'tests' => [
                    [
                        'values' => [
                            null,
                            [],
                            [[1,2,3],[4,5,6]],
                            [[1.1,1.2],[2.1,2.2]],
                            [['str1','str2'],['str3','str4']],
                            [[$model1,$model2],[$collection1,$collection2]],
                            ['Items' => ['str1','str2']],
                            ['Items' => [1,2,3]]
                        ],
                        'expected' => [
                            'toInsert' => [
                                null,
                                [],
                                [[1,2,3],[4,5,6]],
                                [[1.1,1.2],[2.1,2.2]],
                                [['str1','str2'],['str3','str4']],
                                [[$model1,$model2],[$collection1,$collection2]],
                                ['Items' => ['str1','str2']],
                                ['Items' => [1,2,3]]
                            ],
                            'toSet' => [
                                null,
                                [],
                                [[1,2,3],[4,5,6]],
                                [[1.1,1.2],[2.1,2.2]],
                                [['str1','str2'],['str3','str4']],
                                [[$model1,$model2],[$collection1,$collection2]],
                                ['Items' => ['str1','str2']],
                                ['Items' => [1,2,3]]
                            ],
                            'toGet' => [
                                null,
                                [],
                                [[1,2,3],[4,5,6]],
                                [[1.1,1.2],[2.1,2.2]],
                                [['str1','str2'],['str3','str4']],
                                [[$model1,$model2],[$collection1,$collection2]],
                                ['Items' => ['str1','str2']],
                                ['Items' => [1,2,3]]
                            ],
                            'toConvert' => [
                                null,
                                [],
                                [[1,2,3],[4,5,6]],
                                [[1.1,1.2],[2.1,2.2]],
                                [['str1','str2'],['str3','str4']],
                                [[$model1,$model2],[$collection1,$collection2]],
                                ['Items' => ['str1','str2']],
                                ['Items' => [1,2,3]]
                            ]
                        ]
                    ],
                    [
                        'values' => [true, false, 'str', 123, 12.5, 0, ['str1','str2'], [1,2,3], [1.2,1.2]],
                        'expected' => [
                            'toInsert' => InvalidArgumentException::class,
                            'toSet' => InvalidArgumentException::class,
                        ]
                    ]
                ]
            ],

            // enum:val, ..., val
            // --------------------------------
            // Это свойство, которое может принимать одно значение из списка допустимых, явно перечисленных в его
            // специцикации на уровне класса модели.
            [
                'propertyType' => 'enum:a,b',
                'tests' => [
                    [
                        'values' => ['a','b'],
                        'expected' => [
                            'toInsert' => ['a','b'],
                            'toSet' => ['a','b'],
                            'toGet' => ['a','b'],
                            'toConvert' => ['a','b']
                        ]
                    ],
                    [
                        'values' => [
                            true,
                            false,
                            'str',
                            123,
                            12.5,
                            0,
                            ['a'],
                            ['a','b'],
                            ['Items' => ['a']],
                            ['Items' => ['a','b']]
                        ],
                        'expected' => [
                            'toInsert' => InvalidArgumentException::class,
                            'toSet' => InvalidArgumentException::class,
                        ]
                    ]
                ]
            ],

            // set:val, ..., val
            // --------------------------------
            // Это свойство, которое может принимать массив с одним или несколькими значениями из списка допустимых,
            // явно перечисленных в его специцикации на уровне класса модели.
            [
                'propertyType' => 'set:a,b',
                'tests' => [
                    [
                        'values' => [['a'],['b'],['a','b'],['key1' => 'a','key2' => 'b']],
                        'expected' => [
                            'toInsert' => [['a'],['b'],['a','b'],['a','b']],
                            'toSet' => [['a'],['b'],['a','b'],['a','b']],
                        ]
                    ],
                    [
                        'values' => [['a'],['b'],['a','b']],
                        'expected' => [
                            'toGet' => [['a'],['b'],['a','b']],
                            'toConvert' => [['a'],['b'],['a','b']]
                        ]
                    ],
                    [
                        'values' => [
                            true,
                            false,
                            'str',
                            123,
                            12.5,
                            0,
                            'a',
                            ['str1','str2'],
                            ['Items' => ['a']],
                            ['Items' => ['a','b']]
                        ],
                        'expected' => [
                            'toInsert' => InvalidArgumentException::class,
                            'toSet' => InvalidArgumentException::class,
                        ]
                    ]
                ]
            ],


            // arrayOfSet:val, ..., val
            // arrayOfEnum:val, ..., val
            // --------------------------------
            // Это свойства, которое могут принимать массив с одним или несколькими значениями из списка допустимых,
            // явно перечисленных в его специцикации на уровне класса модели.
            // Данныее типы свойства в качестве базовой структуры данных предполагает массив, в котором все
            // элементы объеденены единственным ключем [Items].
            [
                'propertyType' => ['arrayOfEnum:a,b','arrayOfSet:a,b'],
                'tests' => [

                    // Если осуществляется импорт данных с использованием метода insert или make, то структура
                    // входного массива должна содержать ключ объединения [Items], в противном случае будет вызванно
                    // исключение YandexDirectSDK\Exceptions\InvalidArgumentException. При этом значение свойства в
                    // составе данных модели сохраняется без ключа [Items].

                    // При установки данных в свойство с использованием метода setPropertyValue и его производных,
                    // ключ [Items] не обрабытывается, данные сохраняются в свойство как есть.
                    [
                        'values' => [
                            ['Items' => ['a']],
                            ['Items' => ['b']],
                            ['Items' => ['a','b']],
                            ['Items' => ['key1' => 'a', 'key2' => 'b']],
                            ['a'],
                            ['b'],
                            ['a','b'],
                            ['key1' => 'a', 'key2' => 'b']
                        ],
                        'expected' => [
                            'toInsert' => [
                                ['a'],
                                ['b'],
                                ['a','b'],
                                ['a','b'],
                                InvalidArgumentException::class,
                                InvalidArgumentException::class,
                                InvalidArgumentException::class
                            ],
                            'toSet' => [
                                InvalidArgumentException::class,
                                InvalidArgumentException::class,
                                InvalidArgumentException::class,
                                InvalidArgumentException::class,
                                ['a'],
                                ['b'],
                                ['a','b'],
                                ['a','b']
                            ]
                        ]
                    ],

                    // Если выполняется экспорт данных из свойства с использвованием метода toArray и его производных
                    // (toData, toJson), то производится обратных процесс импорта. Формируется массив с единственным
                    // ключем [Items] к которому присваивается текущее значение свойства.

                    // При получении данных с использованием метода getPropertyValue и его производных, значение
                    // свойства возвращается как есть (без изменений).
                    [
                        'values' => [
                            ['a'],
                            ['b'],
                            ['a','b']
                        ],
                        'expected' => [
                            'toGet' => [
                                ['a'],
                                ['b'],
                                ['a','b']
                            ],
                            'toConvert' => [
                                ['Items' => ['a']],
                                ['Items' => ['b']],
                                ['Items' => ['a','b']]
                            ]
                        ]
                    ],

                    // Попытка передать в свойство значение отличное от допустимых, вызовет исключение
                    // YandexDirectSDK\Exceptions\InvalidArgumentException
                    [
                        'values' => [true, false, 'str', 123, 12.5, 0, ['str1','str2'], ['Items' => ['str1','str2']]],
                        'expected' => [
                            'toInsert' => InvalidArgumentException::class,
                            'toSet' => InvalidArgumentException::class,
                        ]
                    ]
                ]
            ],

            // object:class
            // --------------------------------
            // Это свойство, которое может принимать объект (или массив описывающий структуру ожидаемого объекта),
            // класс которого указан в его спецификации. Объект так же должен реализовывать интерфейсы:
            // YandexDirectSDK\Interfaces\Model или YandexDirectSDK\Interfaces\ModelCollection.
            [
                'propertyType' => "object:{$modelClass}",
                'tests' => [

                    // Для совйства с типом object:[class] могут быть установленны следующие значения:
                    // 1. NULL;
                    // 2. Объект реализующий интерфейс YandexDirectSDK\Interfaces\Model и являющимся наследником класса,
                    //    указанного в качестве допустимого значения [class].
                    // 3. Массив, структура котого описывает значения свойст объекта, класс которого указан в
                    //    качестве допустимого значения [class]
                    [
                        'values' => [
                            null,
                            $model1,
                            $emptyModel,
                            [],
                            ['i'=>12,'s'=>'text']
                        ],
                        'expected' => [
                            'toInsert' => [
                                null,
                                ['i'=>12, 's'=>'text', 'f'=>3.14, 'b'=>true],
                                [],
                                [],
                                ['i'=>12,'s'=>'text']
                            ],
                            'toSet' => [
                                null,
                                ['i'=>12, 's'=>'text', 'f'=>3.14, 'b'=>true],
                                [],
                                [],
                                ['i'=>12,'s'=>'text']
                            ]
                        ]
                    ],

                    // Попытка передать массив, структура которого полностью или частично не соответствует
                    // свойствам ожидаемой модели вызовет исключение YandexDirectSDK\Exceptions\ModelException.
                    [
                        'values' => [
                            ['miss'=>'text'],
                            ['i'=>12,'s'=>'text','miss'=>'text'],
                            [1,2,3],
                            ['str1', 'str2']
                        ],
                        'expected' => [
                            'toInsert' => ModelException::class,
                            'toSet' => ModelException::class
                        ]
                    ],

                    // Попытка передать в свойство значение отличное от допустимых вызовит исключение
                    // YandexDirectSDK\Exceptions\InvalidArgumentException
                    [
                        'values' => [
                            true,
                            false,
                            0,
                            123,
                            2.5,
                            0.0,
                            'str',
                            $altModel, //Модель наследующая класс отличный от допустимого [class]
                        ],
                        'expected' => [
                            'toInsert' => InvalidArgumentException::class,
                            'toSet' => InvalidArgumentException::class,
                        ]
                    ],

                    // Методы экспорта данные (toArray и его производных) и получения данных
                    // (getPropertyValue и его производныз).
                    [
                        'values' => [
                            null,
                            $model1,
                            $emptyModel
                        ],
                        'expected' => [
                            'toGet' => [
                                null,
                                $model1,
                                $emptyModel
                            ],
                            'toConvert' => [
                                null,
                                ['I'=>12, 'S'=>'text', 'F'=>3.14, 'B'=>true],
                                []
                            ]
                        ]
                    ]
                ]
            ],
            [
                'propertyType' => "object:{$collectionClass}",
                'tests' => [

                    // Для совйства с типом object:[class] могут быть установленны следующие значения:
                    // 1. NULL;
                    // 2. Объект реализующий интерфейс YandexDirectSDK\Interfaces\Collection и являющимся наследником класса,
                    //    указанного в качестве допустимого значения [class].
                    // 3. Массив моделей
                    // 4. Массив, структура котого описывает коллекцию, класс которой указан в
                    //    качестве допустимого значения [class]
                    [
                        'values' => [
                            null,
                            $collection1,
                            $emptyCollection, // пустая коллекция
                            [],
                            [$model1,$model2],
                            [
                                ['i'=>12,'s'=>'text'],
                                ['i'=>12, 's'=>'text', 'f'=>3.14, 'b'=>true]
                            ],
                            [
                                ['i'=>12,'s'=>'text'], // комбинированный вариант передачи значения
                                $model1
                            ]
                        ],
                        'expected' => [
                            'toInsert' => [
                                null,
                                [
                                    ['i'=>12, 's'=>'text', 'f'=>3.14, 'b'=>true],
                                    ['i'=>12, 's'=>'text', 'f'=>3.14, 'b'=>true]
                                ],
                                [],
                                [],
                                [
                                    ['i'=>12, 's'=>'text', 'f'=>3.14, 'b'=>true],
                                    ['i'=>12, 's'=>'text', 'f'=>3.14, 'b'=>true]
                                ],
                                [
                                    ['i'=>12,'s'=>'text'],
                                    ['i'=>12, 's'=>'text', 'f'=>3.14, 'b'=>true]
                                ],
                                [
                                    ['i'=>12,'s'=>'text'],
                                    ['i'=>12, 's'=>'text', 'f'=>3.14, 'b'=>true]
                                ]
                            ],
                            'toSet' => [
                                null,
                                [
                                    ['i'=>12, 's'=>'text', 'f'=>3.14, 'b'=>true],
                                    ['i'=>12, 's'=>'text', 'f'=>3.14, 'b'=>true]
                                ],
                                [],
                                [],
                                [
                                    ['i'=>12, 's'=>'text', 'f'=>3.14, 'b'=>true],
                                    ['i'=>12, 's'=>'text', 'f'=>3.14, 'b'=>true]
                                ],
                                [
                                    ['i'=>12,'s'=>'text'],
                                    ['i'=>12, 's'=>'text', 'f'=>3.14, 'b'=>true]
                                ],
                                [
                                    ['i'=>12,'s'=>'text'],
                                    ['i'=>12, 's'=>'text', 'f'=>3.14, 'b'=>true]
                                ]
                            ]
                        ]
                    ],

                    // При описании структуры коллекции, недопускается использование ключей отличных от целочисленных.
                    // В противном случае будет вызванно исключени YandexDirectSDK\Exceptions\InvalidArgumentException.
                    [
                        'values' => [
                            [
                                'key1' => $model1,
                                'key2' => $model2
                            ],
                            [
                                'key1' => ['i'=>12, 's'=>'text', 'f'=>3.14, 'b'=>true],
                                'key2' => ['i'=>12, 's'=>'text', 'f'=>3.14, 'b'=>true]
                            ],
                        ],
                        'expected' => [
                            'toInsert' => InvalidArgumentException::class,
                            'toSet' => InvalidArgumentException::class
                        ]
                    ],

                    // Попытка передать массив, структура которого полностью или частично не соответствует
                    // ожидаемой колекции вызовет исключение YandexDirectSDK\Exceptions\ModelException.
                    [
                        'values' => [
                            [
                                ['miss'=>'text']
                            ],
                            [
                                ['i'=>12,'s'=>'text','miss'=>'text']
                            ],
                            [
                                [1,2,3]
                            ],
                            [
                                ['str1', 'str2']
                            ]
                        ],
                        'expected' => [
                            'toInsert' => ModelException::class,
                            'toSet' => ModelException::class
                        ]
                    ],

                    // Попытка передать в свойство значение отличное от допустимых вызовит исключение
                    // YandexDirectSDK\Exceptions\InvalidArgumentException
                    [
                        'values' => [
                            true,
                            false,
                            0,
                            123,
                            2.5,
                            0.0,
                            'str',
                            $altCollection, //Коллекция наследующая класс отличный от допустимого [class]
                            [$altModel] //Массив моделей, который наследуют класс не соответствующий требуемой коллекции
                        ],
                        'expected' => [
                            'toInsert' => InvalidArgumentException::class,
                            'toSet' => InvalidArgumentException::class,
                        ]
                    ],

                    // Методы экспорта данные (toArray и его производных) и получения данных
                    // (getPropertyValue и его производныз).
                    [
                        'values' => [
                            null,
                            $collection1,
                            $emptyCollection // Пустая коллекция
                        ],
                        'expected' => [
                            'toGet' => [
                                null,
                                $collection1,
                                $emptyCollection
                            ],
                            'toConvert' => [
                                null,
                                [
                                    ['I'=>12, 'S'=>'text', 'F'=>3.14, 'B'=>true],
                                    ['I'=>12, 'S'=>'text', 'F'=>3.14, 'B'=>true]
                                ],
                                []
                            ]
                        ]
                    ]
                ]
            ],

            // arrayOfObject:class
            // --------------------------------
            // Это свойство, которое может принимать объект (или массив описывающий структуру ожидаемого объекта),
            // класс которого указан в его спецификации. Объект так же должен реализовывать интерфейс -
            // YandexDirectSDK\Interfaces\ModelCollection.
            // Данныее типы свойства в качестве базовой структуры данных предполагает массив, в котором все
            // элементы объеденены единственным ключем [Items].
            [
                'propertyType' => "arrayOfObject:{$collectionClass}",
                'tests' => [

                    // Для совйства с типом arrayOfObject:[class] могут быть установленны следующие значения:
                    // 1. NULL;
                    // 2. Объект реализующий интерфейс YandexDirectSDK\Interfaces\Collection и являющимся наследником класса,
                    //    указанного в качестве допустимого значения [class].
                    // 3. Массив моделей.
                    // 4. Массив, структура котого описывает коллекцию, класс которой указан в
                    //    качестве допустимого значения [class]

                    // Если осуществляется импорт данных с использованием метода insert или make, то структура
                    // входного массива должна содержать ключ объединения [Items], в противном случае будет вызванно
                    // исключение YandexDirectSDK\Exceptions\InvalidArgumentException. При этом значение свойства в
                    // составе данных модели сохраняется без ключа [Items].

                    // При установке данных в свойство с использованием метода setPropertyValue и его производных,
                    // ключ [Items] не обрабытывается. Метод предпримит попытку конвертировать переданный массив в
                    // коллекцию. Такая ситуация вызовет исключение YandexDirectSDK\Exceptions\InvalidArgumentException,
                    // которое связанно с невозможность использовать текстовые ключи для элементов коллекции.
                    [
                        'values' => [
                            null,
                            $collection1,
                            $emptyCollection,
                            ['Items' => []],
                            ['Items' => [$model1,$model2]],
                            [
                                'Items' => [
                                    ['i'=>12,'s'=>'text'],
                                    ['i'=>12, 's'=>'text', 'f'=>3.14, 'b'=>true]
                                ]
                            ],
                            [
                                'Items' => [
                                    ['i'=>12,'s'=>'text'],
                                    $model1
                                ]
                            ]
                        ],
                        'expected' => [
                            'toInsert' => [
                                null,
                                [
                                    ['i'=>12, 's'=>'text', 'f'=>3.14, 'b'=>true],
                                    ['i'=>12, 's'=>'text', 'f'=>3.14, 'b'=>true]
                                ],
                                [],
                                [],
                                [
                                    ['i'=>12, 's'=>'text', 'f'=>3.14, 'b'=>true],
                                    ['i'=>12, 's'=>'text', 'f'=>3.14, 'b'=>true]
                                ],
                                [
                                    ['i'=>12,'s'=>'text'],
                                    ['i'=>12, 's'=>'text', 'f'=>3.14, 'b'=>true]
                                ],
                                [
                                    ['i'=>12,'s'=>'text'],
                                    ['i'=>12, 's'=>'text', 'f'=>3.14, 'b'=>true]
                                ]
                            ],
                            'toSet' => [
                                null,
                                [
                                    ['i'=>12, 's'=>'text', 'f'=>3.14, 'b'=>true],
                                    ['i'=>12, 's'=>'text', 'f'=>3.14, 'b'=>true]
                                ],
                                [],
                                InvalidArgumentException::class,
                                InvalidArgumentException::class,
                                InvalidArgumentException::class,
                                InvalidArgumentException::class
                            ]
                        ]
                    ],
                    [
                        'values' => [
                            null,
                            $collection1,
                            $emptyCollection,
                            [],
                            [
                                $model1,
                                $model2
                            ],
                            [
                                ['i'=>12,'s'=>'text'],
                                ['i'=>12, 's'=>'text', 'f'=>3.14, 'b'=>true]
                            ],
                            [
                                ['i'=>12,'s'=>'text'],
                                $model1
                            ]
                        ],
                        'expected' => [
                            'toInsert' => [
                                null,
                                [
                                    ['i'=>12, 's'=>'text', 'f'=>3.14, 'b'=>true],
                                    ['i'=>12, 's'=>'text', 'f'=>3.14, 'b'=>true]
                                ],
                                [],
                                InvalidArgumentException::class,
                                InvalidArgumentException::class,
                                InvalidArgumentException::class,
                                InvalidArgumentException::class
                            ],
                            'toSet' => [
                                null,
                                [
                                    ['i'=>12, 's'=>'text', 'f'=>3.14, 'b'=>true],
                                    ['i'=>12, 's'=>'text', 'f'=>3.14, 'b'=>true]
                                ],
                                [],
                                [],
                                [
                                    ['i'=>12, 's'=>'text', 'f'=>3.14, 'b'=>true],
                                    ['i'=>12, 's'=>'text', 'f'=>3.14, 'b'=>true]
                                ],
                                [
                                    ['i'=>12,'s'=>'text'],
                                    ['i'=>12, 's'=>'text', 'f'=>3.14, 'b'=>true]
                                ],
                                [
                                    ['i'=>12,'s'=>'text'],
                                    ['i'=>12, 's'=>'text', 'f'=>3.14, 'b'=>true]
                                ]
                            ]
                        ]
                    ],

                    // При описании структуры коллекции, недопускается использование ключей отличных от целочисленных.
                    // В противном случае будет вызванно исключение YandexDirectSDK\Exceptions\InvalidArgumentException.
                    [
                        'values' => [
                            [
                                'Items' => [
                                    'key1' => $model1,
                                    'key2' => $model2
                                ]
                            ],
                            [
                                'Items' => [
                                    'key1' => ['i'=>12,'s'=>'text'],
                                    'key2' => ['i'=>12, 's'=>'text', 'f'=>3.14, 'b'=>true]
                                ]
                            ]
                        ],
                        'expected' => [
                            'toInsert' => InvalidArgumentException::class
                        ]
                    ],
                    [
                        'values' => [
                            [
                                'key1' => $model1,
                                'key2' => $model2
                            ],
                            [
                                'key1' => ['i'=>12,'s'=>'text'],
                                'key2' => ['i'=>12, 's'=>'text', 'f'=>3.14, 'b'=>true]
                            ]
                        ],
                        'expected' => [
                            'toSet' => InvalidArgumentException::class
                        ]
                    ],

                    // Попытка передать массив, структура которого полностью или частично не соответствует
                    // базовой структуре данных коллекции вызовет исключение YandexDirectSDK\Exceptions\ModelException.
                    [
                        'values' => [
                            [
                                'Items' => [
                                    ['miss'=>'text']
                                ]
                            ],
                            [
                                'Items' => [
                                    ['i'=>12,'s'=>'text','miss'=>'text']
                                ]
                            ],
                            [
                                'Items' => [
                                    [1,2,3]
                                ]
                            ],
                            [
                                'Items' => [
                                    ['str1', 'str2']
                                ]
                            ]
                        ],
                        'expected' => [
                            'toInsert' => ModelException::class
                        ]
                    ],
                    [
                        'values' => [
                            [
                                ['miss'=>'text']
                            ],
                            [
                                ['i'=>12,'s'=>'text','miss'=>'text']
                            ],
                            [
                                [1,2,3]
                            ],
                            [
                                ['str1', 'str2']
                            ]
                        ],
                        'expected' => [
                            'toSet' => ModelException::class
                        ]
                    ],

                    // Попытка передать в свойство значение отличное от допустимых вызовит исключение
                    // YandexDirectSDK\Exceptions\InvalidArgumentException
                    [
                        'values' => [
                            true,
                            false,
                            0,
                            123,
                            2.5,
                            0.0,
                            'str',
                            $altCollection
                        ],
                        'expected' => [
                            'toInsert' => InvalidArgumentException::class,
                            'toSet' => InvalidArgumentException::class,
                        ]
                    ],

                    // Если выполняется экспорт данных из свойства с использвованием метода toArray и его производных
                    // (toData, toJson), то производится обратных процесс импорта. Формируется массив с единственным
                    // ключем [Items] к которому присваивается текущее значение свойства.

                    // При получении данных с использованием метода getPropertyValue и его производных, значение
                    // свойства возвращается как есть (без изменений).
                    [
                        'values' => [
                            null,
                            $collection1,
                            $emptyCollection
                        ],
                        'expected' => [
                            'toGet' => [
                                null,
                                $collection1,
                                $emptyCollection
                            ],
                            'toConvert' => [
                                null,
                                [
                                    'Items' => [
                                        ['I'=>12, 'S'=>'text', 'F'=>3.14, 'B'=>true],
                                        ['I'=>12, 'S'=>'text', 'F'=>3.14, 'B'=>true]
                                    ]
                                ],
                                [
                                    'Items' => []
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        foreach ($testSets as $testSet){
            foreach (Arr::wrap($testSet['propertyType']) as $type){
                foreach ($testSet['tests'] as $numTest => $test){
                    if (!array_key_exists($forSet, $test['expected'])){
                        continue;
                    }

                    $values = Arr::wrap($test['values']);
                    $expected = $test['expected'][$forSet];

                    if (!is_array($expected)){
                        $expected = array_pad([],count($values),$expected);
                    } else {
                        if (count($expected) < count($values)){
                            $expected = array_pad($expected, count($values), Arr::last($expected));
                        }
                    }

                    foreach ($values as $numValue => $value){
                        if (is_string($expected[$numValue]) and is_subclass_of($expected[$numValue], Exception::class)){
                            $exception = $expected[$numValue];
                            $expected[$numValue] = null;
                        } else {
                            $exception = null;
                        }

                        $testData["{$type}: {$numTest}.{$numValue}"] = [
                            [
                                'type' => $type,
                                'value' => $value,
                                'expected' => $expected[$numValue],
                                'exception' => $exception
                            ]
                        ];
                    }
                }
            }
        }

        return $testData;
    }
}