<?php

namespace YandexDirectSDKTest\Examples\AdGroup;

use PHPUnit\Framework\TestCase;
use YandexDirectSDK\Collections\Campaigns;
use YandexDirectSDK\Models\Campaign;
use YandexDirectSDK\Models\StrategyMaximumClicks;
use YandexDirectSDK\Models\StrategyNetworkDefault;
use YandexDirectSDK\Models\TextCampaign;
use YandexDirectSDK\Models\TextCampaignNetworkStrategy;
use YandexDirectSDK\Models\TextCampaignSearchStrategy;
use YandexDirectSDK\Models\TextCampaignStrategy;
use YandexDirectSDKTest\Helpers\Checklists;
use YandexDirectSDKTest\Helpers\Env;

class ModelExamplesTest extends TestCase
{
    /*
     |-------------------------------------------------------------------------------
     |
     | Handlers
     |
     |-------------------------------------------------------------------------------
    */

    /**
     */
    public static function setUpBeforeClass(): void
    {
        Env::setUpSession();
    }

    public static function tearDownAfterClass(): void
    {
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Add
     |
     |-------------------------------------------------------------------------------
    */

    public static function testAddTextCampaigns_HighestPosition_NetworkDefault()
    {
        $campaign = Campaign::make()
            ->setName('MyTextCampaign')
            ->setStartDate('2029-10-01')
            ->setEndDate('2029-10-10')
            ->setNegativeKeywords(['set', 'negative', 'keywords'])
            ->setTextCampaign(
                TextCampaign::make()
                    ->setBiddingStrategy(
                        TextCampaignStrategy::make()
                            ->setSearch(
                                TextCampaignSearchStrategy::make()
                                    ->setBiddingStrategyType('HIGHEST_POSITION')
                            )
                            ->setNetwork(
                                TextCampaignNetworkStrategy::make()
                                    ->setBiddingStrategyType('NETWORK_DEFAULT')
                                    ->setNetworkDefault(
                                        StrategyNetworkDefault::make()->setLimitPercent(50)
                                    )
                            )
                    )
            );

        $result = $campaign->add();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        $campaign->delete();
    }

    public function testAddTextCampaigns_WbMaximumClicks_NetworkDefault()
    {
        $campaign = Campaign::make()
            ->setName('MyTextCampaign')
            ->setStartDate('2029-10-01')
            ->setEndDate('2029-10-10')
            ->setNegativeKeywords(['set', 'negative', 'keywords'])
            ->setTextCampaign(
                TextCampaign::make()
                    ->setBiddingStrategy(
                        TextCampaignStrategy::make()
                            ->setSearch(
                                TextCampaignSearchStrategy::make()
                                    ->setBiddingStrategyType('WB_MAXIMUM_CLICKS')
                                    ->setWbMaximumClicks(
                                        StrategyMaximumClicks::make()
                                            ->setWeeklySpendLimit(400000000)
                                            ->setBidCeiling(10000000)
                                    )
                            )
                            ->setNetwork(
                                TextCampaignNetworkStrategy::make()
                                    ->setBiddingStrategyType('NETWORK_DEFAULT')
                                    ->setNetworkDefault()
                            )
                    )
            );

        $campaign->add();

        // [ Post processing ] =========================================================================================

        Checklists::checkModel($campaign, ['Id' => 'required|integer']);
        $campaign->delete();
    }
}