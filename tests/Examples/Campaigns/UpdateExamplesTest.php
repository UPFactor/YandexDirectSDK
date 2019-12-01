<?php

namespace YandexDirectSDKTest\Examples\Campaigns;

use PHPUnit\Framework\TestCase;
use UPTools\Arr;
use YandexDirectSDK\Collections\Campaigns;
use YandexDirectSDK\Collections\TextCampaignSettings;
use YandexDirectSDK\Models\Campaign;
use YandexDirectSDK\Models\TextCampaignSetting;
use YandexDirectSDKTest\Helpers\Checklists;
use YandexDirectSDKTest\Helpers\Env;

class UpdateExamplesTest extends TestCase
{
    /**
     * @var Campaign[]
     */
    private static $campaigns = [];

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

        Campaign::find(Arr::map(static::$campaigns, function(Campaign $campaign){
            return $campaign->id;
        }))->delete();

        static::$campaigns = [];
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
    public static function campaignProvider()
    {
        Env::setUpSession();

        return [
            'TextCampaignHMC' => [static::$campaigns['TextCampaignHMC'] ?? static::$campaigns['TextCampaignHMC'] = CreateExamplesTest::createTextCampaign_HighestPosition_MaximumCoverage()]
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
     * @dataProvider campaignProvider
     * @param Campaign $campaign
     */
    public static function update(Campaign $campaign):void
    {
        $result = $campaign->setName('New campaign name')
            ->setStartDate('2029-11-01')
            ->setEndDate('2029-11-10')
            ->setNegativeKeywords(null)
            ->update();

        // [ Post processing ]

        Checklists::checkResource($result, Campaigns::class);
    }

    /**
     * @test
     * @dataProvider campaignProvider
     * @param Campaign $campaign
     */
    public static function updateSubModels(Campaign $campaign):void
    {
        $campaign->textCampaign->setCounterIds([1234, 4321]);
        $campaign->textCampaign->setSettings(
            TextCampaignSettings::make(
                TextCampaignSetting::addMetricaTag(true),
                TextCampaignSetting::addToFavorites(true)
            )
        );

        $result = $campaign->update();

        // [ Post processing ]

        Checklists::checkResource($result, Campaigns::class);
    }
}