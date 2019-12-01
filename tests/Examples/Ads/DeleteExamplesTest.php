<?php

namespace YandexDirectSDKTest\Examples\Ads;

use PHPUnit\Framework\TestCase;
use UPTools\Arr;
use YandexDirectSDK\Collections\Ads;
use YandexDirectSDK\Models\Ad;
use YandexDirectSDK\Models\Campaign;
use YandexDirectSDKTest\Helpers\Checklists;
use YandexDirectSDKTest\Helpers\Env;

class DeleteExamplesTest extends TestCase
{
    /**
     * @var Ad[]
     */
    private static $ads = [];

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
        static::$ads = [];
    }

    /**
     * Destructor
     * @return void
     */
    public static function tearDownAfterClass(): void
    {
        Env::setUpSession();

        $adIds = Arr::map(static::$ads, function (Ad $ad){
            return $ad->id;
        });

        if (count($adIds) > 1){
            $campaignIds = Ads::find($adIds, ['CampaignId'])->extract('campaignId');
        } else {
            $campaignIds = Ads::find($adIds, ['CampaignId'])->campaignId;
        }

        Campaign::find($campaignIds)->delete();
        static::$ads = [];
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
     * @return void
     */
    public static function deleteModel():void
    {
        // [ Pre processing ]

        $ad = static::$ads[] = CreateExamplesTest::createTextAd();

        // [ Example ]

        $result = $ad->delete();

        // [ Post processing ]

        Checklists::checkResult($result);
    }

    /**
     * @test
     * @return void
     */
    public static function deleteModels():void
    {
        // [ Pre processing ]

        $ads =  Ads::make(
            static::$ads[] = CreateExamplesTest::createTextAd(),
            static::$ads[] = CreateExamplesTest::createDynamicTextAd()
        );

        // [ Example ]

        $result = $ads->delete();

        // [ Post processing ]

        Checklists::checkResult($result);
    }

    /**
     * @test
     * @return void
     */
    public static function deleteById():void
    {
        // [ Pre processing ]

        $adId = (static::$ads[] = CreateExamplesTest::createTextAd())->id;

        // [ Example ]

        $result = Ad::on($adId)->delete();

        // [ Post processing ]

        Checklists::checkResult($result);
    }

    /**
     * @test
     * @return void
     */
    public static function deleteByIds():void
    {
        // [ Pre processing ]

        $adIds = Ads::make(
            static::$ads[] = CreateExamplesTest::createTextAd(),
            static::$ads[] = CreateExamplesTest::createDynamicTextAd()
        )->extract('id');

        // [ Example ]

        $result = Ads::on($adIds)->delete();

        // [ Post processing ]

        Checklists::checkResult($result);
    }
}