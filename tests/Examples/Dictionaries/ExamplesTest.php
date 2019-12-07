<?php

namespace YandexDirectSDKTest\Examples\Dictionaries;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use UPTools\Arr;
use UPTools\Validator;
use YandexDirectSDK\Components\Data;
use YandexDirectSDK\Services\DictionariesService;
use YandexDirectSDKTest\Helpers\Env;

class ExamplesTest extends TestCase
{
    /*
     |-------------------------------------------------------------------------------
     |
     | Handlers
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * Constructor
     * @return void
     */
    public static function setUpBeforeClass(): void
    {
        Env::setUpSession();
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Examples
     |
     |-------------------------------------------------------------------------------
    */

    protected static function checkData(Data $data, array $rules)
    {
        $validator = Validator::make($data->all(), $rules);
        Assert::assertFalse($validator->fails, Arr::first($validator->failed) ?? '');
    }

    /**
     * @test
     * @return void
     */
    public static function getCurrencies():void
    {
        $data = DictionariesService::getCurrencies();

        // [ Post processing ]

        static::assertNotEmpty($data->all());
    }

    /**
     * @test
     * @return void
     */
    public static function getMetroStations():void
    {
        $data = DictionariesService::getMetroStations();

        // [ Post processing ]

        static::assertNotEmpty($data->all());
    }

    /**
     * @test
     * @return void
     */
    public static function getGeoRegions():void
    {
        $data = DictionariesService::getGeoRegions();

        // [ Post processing ]

        static::assertNotEmpty($data->all());
    }

    /**
     * @test
     * @return void
     */
    public static function getTimeZones():void
    {
        $data = DictionariesService::getTimeZones();

        // [ Post processing ]

        static::assertNotEmpty($data->all());
    }

    /**
     * @test
     * @return void
     */
    public static function getConstants():void
    {
        $data = DictionariesService::getConstants();

        // [ Post processing ]

        static::assertNotEmpty($data->all());
    }

    /**
     * @test
     * @return void
     */
    public static function getAdCategories():void
    {
        $data = DictionariesService::getAdCategories();

        // [ Post processing ]

        static::assertNotEmpty($data->all());
    }

    /**
     * @test
     * @return void
     */
    public static function getOperationSystemVersions():void
    {
        $data = DictionariesService::getOperationSystemVersions();

        // [ Post processing ]

        static::assertNotEmpty($data->all());
    }

    /**
     * @test
     * @return void
     */
    public static function getSupplySidePlatforms():void
    {
        $data = DictionariesService::getSupplySidePlatforms();

        // [ Post processing ]

        static::assertNotEmpty($data->all());
    }

    /**
     * @test
     * @return void
     */
    public static function getInterests():void
    {
        $data = DictionariesService::getInterests();

        // [ Post processing ]

        static::assertNotEmpty($data->all());
    }

    /**
     * @test
     * @return void
     */
    public static function getAudienceCriteriaTypes():void
    {
        $data = DictionariesService::getAudienceCriteriaTypes();

        // [ Post processing ]

        static::assertNotEmpty($data->all());
    }

    /**
     * @test
     * @return void
     */
    public static function getAudienceDemographicProfiles():void
    {
        $data = DictionariesService::getAudienceDemographicProfiles();

        // [ Post processing ]

        static::assertNotEmpty($data->all());
    }

    /**
     * @test
     * @return void
     */
    public static function getAudienceInterests():void
    {
        $data = DictionariesService::getAudienceInterests();

        // [ Post processing ]

        static::assertNotEmpty($data->all());
    }
}