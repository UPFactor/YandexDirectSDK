<?php

namespace YandexDirectSDKTest\Examples\Ads;

use PHPUnit\Framework\TestCase;
use UPTools\Arr;
use YandexDirectSDK\Collections\Ads;
use YandexDirectSDK\Models\Ad;
use YandexDirectSDK\Models\Campaign;
use YandexDirectSDKTest\Helpers\Checklists;
use YandexDirectSDKTest\Helpers\Env;

class UpdateExamplesTest extends TestCase
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
            'TextAdd' => [static::$ads['TextAdd'] ?? static::$ads['TextAdd'] = CreateExamplesTest::createTextAd()]
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
    public static function update(Ad $ad):void
    {
        $ad->textAd
                ->setTitle('New title')
                ->setTitle2('New title2')
                ->setText('New text')
                ->setMobile('YES');

        $result = $ad->update();

        // [ Post processing ]

        Checklists::checkResource($result, Ads::class);
    }
}