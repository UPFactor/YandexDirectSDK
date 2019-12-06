<?php

namespace YandexDirectSDKTest\Examples\Campaigns;

use PHPUnit\Framework\TestCase;
use UPTools\Arr;
use YandexDirectSDK\Collections\Campaigns;
use YandexDirectSDK\Models\Campaign;
use YandexDirectSDKTest\Helpers\Checklists;
use YandexDirectSDKTest\Helpers\Env;

class DeleteExamplesTest extends TestCase
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
     * Constructor
     * @return void
     */
    public static function setUpBeforeClass(): void
    {
        Env::setUpSession();
        static::$campaigns = [];
    }

    /**
     * Destructor
     * @return void
     */
    public static function tearDownAfterClass(): void
    {
        Env::setUpSession();

        Campaigns::find(
            Arr::map(static::$campaigns, function(Campaign $campaign){
                return $campaign->id;
            })
        )->isNotEmpty(function(Campaigns $campaigns){
            $campaigns->delete();
        });

        static::$campaigns = [];
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

        static::$campaigns[] = $campaign = CreateExamplesTest::createTextCampaign_HighestPosition_MaximumCoverage();

        // [ Example ]

        $result = $campaign->delete();

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

        $campaigns = Campaigns::make(
            static::$campaigns[] = CreateExamplesTest::createTextCampaign_HighestPosition_MaximumCoverage(),
            static::$campaigns[] = CreateExamplesTest::createDynamicTextCampaign_HighestPosition_ServingOff()
        );

        // [ Example ]

        $result = $campaigns->delete();

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

        $campaignId = (static::$campaigns[] = CreateExamplesTest::createTextCampaign_HighestPosition_MaximumCoverage())->id;

        // [ Example ]

        $result = Campaign::to($campaignId)->delete();

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

        $campaignsIds = Campaigns::make(
            static::$campaigns[] = CreateExamplesTest::createTextCampaign_HighestPosition_MaximumCoverage(),
            static::$campaigns[] = CreateExamplesTest::createDynamicTextCampaign_HighestPosition_ServingOff()
        )->extract('id');

        // [ Example ]

        $result = Campaigns::to($campaignsIds)->delete();

        // [ Post processing ]

        Checklists::checkResult($result);
    }
}