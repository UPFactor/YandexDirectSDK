<?php

namespace YandexDirectSDKTest\Unit\Models;

use PHPUnit\Framework\TestCase;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Interfaces\ModelCollection as ModelCollectionInterface;
use YandexDirectSDKTest\Units\Models\DataProviders\APIDataProvider;

class ModelsTest extends TestCase
{
    use APIDataProvider;

    //todo:
    // BidModifiers.add

    /*
     |-------------------------------------------------------------------------------
     |
     | Парсинг результатов запроса на выборку данных
     |
     |-------------------------------------------------------------------------------
    */

    /*
     | Data providers
     |-------------------------------------------------------------------------------
    */

    public function apiResponseDataProvider(): array
    {
        return $this->apiDataProvider('get');
    }

    /*
     | Tests
     |-------------------------------------------------------------------------------
    */

    /**
     * @dataProvider apiResponseDataProvider
     * @param ModelCollectionInterface $collection
     * @param array $insert
     * @param string $expected
     */
    public static function testResponseParsing($collection, array $insert, string $expected):void
    {
        static::assertSame(
            $expected,
            $collection::wrap($insert)->toJson()
        );
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Создание запроса на добавление данных
     |
     |-------------------------------------------------------------------------------
    */

    /*
     | Data providers
     |-------------------------------------------------------------------------------
    */

    public function apiAddRequestDataProvider(): array
    {
        return $this->apiDataProvider('add');
    }

    /*
     | Tests
     |-------------------------------------------------------------------------------
    */

    /**
     * @dataProvider apiAddRequestDataProvider
     * @param ModelCollectionInterface $collection
     * @param array $insert
     * @param string $expected
     */
    public static function testCreatingAddRequest($collection, array $insert, string $expected):void
    {
        static::assertSame(
            $expected,
            $collection::wrap($insert)->toJson(Model::IS_ADDABLE)
        );
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Создание запроса на обновление данных
     |
     |-------------------------------------------------------------------------------
    */

    /*
     | Data providers
     |-------------------------------------------------------------------------------
    */

    public function apiUpdateRequestDataProvider(): array
    {
        return $this->apiDataProvider('update');
    }

    /*
     | Tests
     |-------------------------------------------------------------------------------
    */

    /**
     * @dataProvider apiUpdateRequestDataProvider
     * @param ModelCollectionInterface $collection
     * @param array $insert
     * @param string $expected
     */
    public static function testCreatingUpdateRequest($collection, array $insert, string $expected):void
    {
        static::assertSame(
            $expected,
            $collection::wrap($insert)->toJson(Model::IS_UPDATABLE)
        );
    }
}