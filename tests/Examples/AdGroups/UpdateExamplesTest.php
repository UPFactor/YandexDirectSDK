<?php

namespace YandexDirectSDKTest\Examples\AdGroups;

use PHPUnit\Framework\TestCase;
use UPTools\Arr;
use YandexDirectSDK\Collections\AdGroups;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\Campaign;
use YandexDirectSDKTest\Helpers\Checklists;
use YandexDirectSDKTest\Helpers\Env;

class UpdateExamplesTest extends TestCase
{
    /**
     * @var AdGroup[]
     */
    private static $adGroups = [];

    /*
     |-------------------------------------------------------------------------------
     |
     | Handlers
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * Destructor
     * @return void
     */
    public static function tearDownAfterClass(): void
    {
        Env::setUpSession();

        Campaign::find(Arr::map(static::$adGroups, function(AdGroup $adGroup){
            return $adGroup->campaignId;
        }))->delete();

        static::$adGroups = [];
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | DataProvider
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * DataProvider
     * @return array
     */
    public static function adGroupProvider()
    {
        Env::setUpSession();

        return [
            'MobileAppAdGroupHPND' => [static::$adGroups['MobileAppAdGroupHPND'] ?? static::$adGroups['MobileAppAdGroupHPND'] = CreateExamplesTest::createMobileAppAdGroup_HighestPosition_NetworkDefault()]
        ];
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Examples
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @test
     * @dataProvider adGroupProvider
     * @param AdGroup $adGroup
     */
    public static function update(AdGroup $adGroup):void
    {
        $result = $adGroup
            ->setName('New group name ')
            ->setNegativeKeywords(['new','negative','keyword'])
            ->setTrackingParams('from=yandex-direct&ad={ad_id}')
            ->update();

        // [ Post processing ]

        Checklists::checkResource($result, AdGroups::class);
    }

    /**
     * @test
     * @dataProvider adGroupProvider
     * @param AdGroup $adGroup
     */
    public static function updateSubModels(AdGroup $adGroup):void
    {
        $adGroup
            ->setName('MyAdGroup')
            ->setNegativeKeywords(['new','negative','keyword'])
            ->setTrackingParams('from=yandex-direct&ad={ad_id}')
            ->mobileAppAdGroup
                ->setTargetDeviceType(['DEVICE_TYPE_MOBILE'])
                ->setTargetCarrier('WI_FI_ONLY');

        $result = $adGroup->update();

        // [ Post processing ]

        Checklists::checkResource($result, AdGroups::class);
    }
}