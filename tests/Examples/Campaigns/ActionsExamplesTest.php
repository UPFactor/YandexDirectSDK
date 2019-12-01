<?php

namespace YandexDirectSDKTest\Examples\Campaigns;

use PHPUnit\Framework\TestCase;
use UPTools\Arr;
use YandexDirectSDK\Models\Campaign;
use YandexDirectSDKTest\Helpers\Checklists;
use YandexDirectSDKTest\Helpers\Env;

class ActionsExamplesTest extends TestCase
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
            'TextCampaignHPMC' => [static::$campaigns['TextCampaignHPMC'] ?? static::$campaigns['TextCampaignHPMC'] = CreateExamplesTest::createTextCampaign_HighestPosition_MaximumCoverage()]
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
    public static function suspend(Campaign $campaign): void
    {
        $result = $campaign->suspend();

        // [ Post processing ]

        Checklists::checkResult($result);
        sleep(10);
    }

    /**
     * @test
     * @dataProvider campaignProvider
     * @depends suspend
     * @param Campaign $campaign
     */
    public static function archive(Campaign $campaign): void
    {
        $result = $campaign->archive();

        // [ Post processing ]

        Checklists::checkResult($result);
        sleep(10);
    }

    /**
     * @test
     * @dataProvider campaignProvider
     * @depends archive
     * @param Campaign $campaign
     */
    public static function unarchive(Campaign $campaign): void
    {
        $result = $campaign->unarchive();

        // [ Post processing ]

        Checklists::checkResult($result);
        sleep(10);
    }

    /**
     * @test
     * @dataProvider campaignProvider
     * @depends unarchive
     * @param Campaign $campaign
     */
    public static function resume(Campaign $campaign): void
    {
        $result = $campaign->resume();

        // [ Post processing ]

        Checklists::checkResult($result);
        sleep(10);
    }
}