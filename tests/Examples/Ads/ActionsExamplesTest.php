<?php

namespace YandexDirectSDKTest\Examples\Ads;

use PHPUnit\Framework\TestCase;
use UPTools\Arr;
use YandexDirectSDK\Collections\Ads;
use YandexDirectSDK\Models\Ad;
use YandexDirectSDK\Models\Campaign;
use YandexDirectSDKTest\Examples\Ads\CreateExamplesTest as AdsCreateExamplesTest;
use YandexDirectSDKTest\Helpers\Checklists;
use YandexDirectSDKTest\Helpers\Env;

class ActionsExamplesTest extends TestCase
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
     | DataProvider
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * DataProvider
     * @return array
     */
    public static function adProvider()
    {
        Env::setUpSession();

        return [
            'TextAd' => [static::$ads['TextAd'] ?? static::$ads['TextAd'] = AdsCreateExamplesTest::createTextAd()]
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
     * @dataProvider adProvider
     * @param Ad $ad
     */
    public static function moderate(Ad $ad):void
    {
        $result = $ad->moderate();

        // [ Post processing ]

        Checklists::checkResult($result);
        sleep(10);
    }

    /**
     * @test
     * @dataProvider adProvider
     * @param Ad $ad
     */
    public static function suspend(Ad $ad):void
    {
        $result = $ad->suspend();

        // [ Post processing ]

        Checklists::checkResult($result);
        sleep(10);
    }

    /**
     * @test
     * @dataProvider adProvider
     * @depends suspend
     * @param Ad $ad
     */
    public static function archive(Ad $ad):void
    {
        $result = $ad->archive();

        // [ Post processing ]

        Checklists::checkResult($result);
        sleep(10);
    }

    /**
     * @test
     * @dataProvider adProvider
     * @depends archive
     * @param Ad $ad
     */
    public static function unarchive(Ad $ad):void
    {
        $result = $ad->unarchive();

        // [ Post processing ]

        Checklists::checkResult($result);
        sleep(10);
    }

    /**
     * @test
     * @dataProvider adProvider
     * @depends unarchive
     * @param Ad $ad
     */
    public static function resume(Ad $ad):void
    {
        $result = $ad->resume();

        // [ Post processing ]

        Checklists::checkResult($result);
        sleep(10);
    }
}