<?php

namespace YandexDirectSDKTest\Examples\Campaigns;

use PHPUnit\Framework\TestCase;
use UPTools\Arr;
use YandexDirectSDK\Collections\AdGroups;
use YandexDirectSDK\Collections\Ads;
use YandexDirectSDK\Collections\AudienceTargets;
use YandexDirectSDK\Collections\BidModifiers;
use YandexDirectSDK\Collections\BidModifierToggles;
use YandexDirectSDK\Collections\Bids;
use YandexDirectSDK\Collections\BidsAuto;
use YandexDirectSDK\Collections\Campaigns;
use YandexDirectSDK\Collections\Keywords;
use YandexDirectSDK\Collections\TextCampaignSettings;
use YandexDirectSDK\Collections\Webpages;
use YandexDirectSDK\Models\Ad;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\BidAuto;
use YandexDirectSDK\Models\BidModifier;
use YandexDirectSDK\Models\Campaign;
use YandexDirectSDK\Models\CpmBannerCampaign;
use YandexDirectSDK\Models\CpmBannerCampaignNetworkStrategy;
use YandexDirectSDK\Models\CpmBannerCampaignSearchStrategy;
use YandexDirectSDK\Models\CpmBannerCampaignStrategy;
use YandexDirectSDK\Models\DynamicTextAdGroup;
use YandexDirectSDK\Models\DynamicTextCampaign;
use YandexDirectSDK\Models\DynamicTextCampaignNetworkStrategy;
use YandexDirectSDK\Models\DynamicTextCampaignSearchStrategy;
use YandexDirectSDK\Models\DynamicTextCampaignStrategy;
use YandexDirectSDK\Models\Keyword;
use YandexDirectSDK\Models\MobileAppAdGroup;
use YandexDirectSDK\Models\MobileAppCampaign;
use YandexDirectSDK\Models\MobileAppCampaignNetworkStrategy;
use YandexDirectSDK\Models\MobileAppCampaignSearchStrategy;
use YandexDirectSDK\Models\MobileAppCampaignStrategy;
use YandexDirectSDK\Models\RegionalAdjustment;
use YandexDirectSDK\Models\StrategyAverageCpa;
use YandexDirectSDK\Models\StrategyAverageCpc;
use YandexDirectSDK\Models\StrategyAverageCpi;
use YandexDirectSDK\Models\StrategyAverageRoi;
use YandexDirectSDK\Models\StrategyCpDecreasedPriceForRepeatedImpressions;
use YandexDirectSDK\Models\StrategyCpMaximumImpressions;
use YandexDirectSDK\Models\StrategyMaximumAppInstalls;
use YandexDirectSDK\Models\StrategyMaximumClicks;
use YandexDirectSDK\Models\StrategyMaximumConversionRate;
use YandexDirectSDK\Models\StrategyNetworkDefault;
use YandexDirectSDK\Models\StrategyWbDecreasedPriceForRepeatedImpressions;
use YandexDirectSDK\Models\StrategyWbMaximumImpressions;
use YandexDirectSDK\Models\StrategyWeeklyClickPackage;
use YandexDirectSDK\Models\TextAd;
use YandexDirectSDK\Models\TextCampaign;
use YandexDirectSDK\Models\TextCampaignNetworkStrategy;
use YandexDirectSDK\Models\TextCampaignSearchStrategy;
use YandexDirectSDK\Models\TextCampaignSetting;
use YandexDirectSDK\Models\TextCampaignStrategy;
use YandexDirectSDKTest\Helpers\Checklists;
use YandexDirectSDKTest\Helpers\Env;

class ModelExamplesTest extends TestCase
{
    protected static $buffer = [];

    /*
     |-------------------------------------------------------------------------------
     |
     | Handlers
     |
     |-------------------------------------------------------------------------------
    */

    public static function setUpBeforeClass(): void
    {
        Env::setUpSession();
        static::$buffer = [];
    }

    public static function tearDownAfterClass(): void
    {
        $ids = Arr::map(static::$buffer, function(Campaign $campaign){
            return $campaign->id;
        });

        $campaigns = Campaign::query()
            ->select('Id')
            ->whereIn('Ids', $ids)
            ->get()
            ->getResource();

        $campaigns->delete();

        static::$buffer = [];
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Add
     |
     |-------------------------------------------------------------------------------
    */

    public static function testMakeAndAdd_TextCampaign_HighestPosition_NetworkDefault(): void
    {
        $campaign = Campaign::make([
            'Name' => 'TextCampaign_HighestPosition_NetworkDefault',
            'StartDate' => '2029-10-01',
            'EndDate' => '2029-10-10',
            'NegativeKeywords' => [
                'Items' => ['set', 'negative', 'keywords']
            ],
            'TextCampaign' => [
                'BiddingStrategy' => [
                    'Search' => [
                        'BiddingStrategyType' => 'HIGHEST_POSITION'
                    ],
                    'Network' => [
                        'BiddingStrategyType' => 'NETWORK_DEFAULT',
                        'NetworkDefault' => [
                            'LimitPercent' => 50
                        ]
                    ]
                ]
            ]
        ]);

        $result = $campaign->add();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        $campaign->delete();
    }

    public static function testMakeAndAdd_TextCampaign_WbMaximumClicks_NetworkDefault(): void
    {
        $campaign = Campaign::make([
            'Name' => 'TextCampaign_WbMaximumClicks_NetworkDefault',
            'StartDate' => '2029-10-01',
            'EndDate' => '2029-10-10',
            'NegativeKeywords' => [
                'Items' => ['set', 'negative', 'keywords']
            ],
            'TextCampaign' => [
                'BiddingStrategy' => [
                    'Search' => [
                        'BiddingStrategyType' => 'WB_MAXIMUM_CLICKS',
                        'WbMaximumClicks' => [
                            'WeeklySpendLimit' => 400000000,
                            'BidCeiling' => 10000000
                        ]
                    ],
                    'Network' => [
                        'BiddingStrategyType' => 'NETWORK_DEFAULT',
                        'NetworkDefault' => []
                    ]
                ]
            ]
        ]);

        $result = $campaign->add();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        $campaign->delete();
    }

    public static function testMakeAndAdd_TextCampaign_ServingOff_WbMaximumClicks(): void
    {
        $campaign = Campaign::make([
            'Name' => 'TextCampaign_ServingOff_WbMaximumClicks',
            'StartDate' => '2029-10-01',
            'EndDate' => '2029-10-10',
            'NegativeKeywords' => [
                'Items' => ['set', 'negative', 'keywords']
            ],
            'TextCampaign' => [
                'BiddingStrategy' => [
                    'Search' => [
                        'BiddingStrategyType' => 'SERVING_OFF'
                    ],
                    'Network' => [
                        'BiddingStrategyType' => 'WB_MAXIMUM_CLICKS',
                        'WbMaximumClicks' => [
                            'WeeklySpendLimit' => 400000000,
                            'BidCeiling' => 10000000
                        ]
                    ]
                ]
            ]
        ]);

        $result = $campaign->add();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        $campaign->delete();
    }


    public static function testAdd_TextCampaign_HighestPosition_MaximumCoverage(): Campaign
    {
        $campaign = Campaign::make()
            ->setName('TextCampaign_HighestPosition_MaximumCoverage')
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
                                    ->setBiddingStrategyType('MAXIMUM_COVERAGE')
                            )
                    )
            );

        $result = $campaign->add();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$buffer[] = $campaign;
    }

    public static function testAdd_TextCampaign_WbMaximumClicks_NetworkDefault(): Campaign
    {
        $campaign = Campaign::make()
            ->setName('TextCampaign_WbMaximumClicks_NetworkDefault')
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

        $result = $campaign->add();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$buffer[] = $campaign;
    }

    public static function testAdd_TextCampaign_WbMaximumConversionRate_NetworkDefault(): Campaign
    {
        $campaign = Campaign::make()
            ->setName('TextCampaign_WbMaximumConversionRate_NetworkDefault')
            ->setStartDate('2029-10-01')
            ->setEndDate('2029-10-10')
            ->setNegativeKeywords(['set', 'negative', 'keywords'])
            ->setTextCampaign(
                TextCampaign::make()
                    ->setBiddingStrategy(
                        TextCampaignStrategy::make()
                            ->setSearch(
                                TextCampaignSearchStrategy::make()
                                    ->setBiddingStrategyType('WB_MAXIMUM_CONVERSION_RATE')
                                    ->setWbMaximumConversionRate(
                                        StrategyMaximumConversionRate::make()
                                            ->setWeeklySpendLimit(400000000)
                                            ->setBidCeiling(10000000)
                                            ->setGoalId(0)
                                    )
                            )
                            ->setNetwork(
                                TextCampaignNetworkStrategy::make()
                                    ->setBiddingStrategyType('NETWORK_DEFAULT')
                                    ->setNetworkDefault()
                            )
                    )
            );

        $result = $campaign->add();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$buffer[] = $campaign;
    }

    public static function testAdd_TextCampaign_AverageCpc_NetworkDefault(): Campaign
    {
        $campaign = Campaign::make()
            ->setName('TextCampaign_AverageCpc_NetworkDefault')
            ->setStartDate('2029-10-01')
            ->setEndDate('2029-10-10')
            ->setNegativeKeywords(['set', 'negative', 'keywords'])
            ->setTextCampaign(
                TextCampaign::make()
                    ->setBiddingStrategy(
                        TextCampaignStrategy::make()
                            ->setSearch(
                                TextCampaignSearchStrategy::make()
                                    ->setBiddingStrategyType('AVERAGE_CPC')
                                    ->setAverageCpc(
                                        StrategyAverageCpc::make()
                                            ->setAverageCpc(10000000)
                                            ->setWeeklySpendLimit(400000000)
                                    )
                            )
                            ->setNetwork(
                                TextCampaignNetworkStrategy::make()
                                    ->setBiddingStrategyType('NETWORK_DEFAULT')
                                    ->setNetworkDefault()
                            )
                    )
            );

        $result = $campaign->add();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$buffer[] = $campaign;
    }

    public static function testAdd_TextCampaign_AverageCpa_NetworkDefault(): Campaign
    {
        $campaign = Campaign::make()
            ->setName('TextCampaign_AverageCpa_NetworkDefault')
            ->setStartDate('2029-10-01')
            ->setEndDate('2029-10-10')
            ->setNegativeKeywords(['set', 'negative', 'keywords'])
            ->setTextCampaign(
                TextCampaign::make()
                    ->setBiddingStrategy(
                        TextCampaignStrategy::make()
                            ->setSearch(
                                TextCampaignSearchStrategy::make()
                                    ->setBiddingStrategyType('AVERAGE_CPA')
                                    ->setAverageCpa(
                                        StrategyAverageCpa::make()
                                            ->setAverageCpa(10000000)
                                            ->setWeeklySpendLimit(400000000)
                                            ->setBidCeiling(20000000)
                                            ->setGoalId(0)
                                    )
                            )
                            ->setNetwork(
                                TextCampaignNetworkStrategy::make()
                                    ->setBiddingStrategyType('NETWORK_DEFAULT')
                                    ->setNetworkDefault()
                            )
                    )
            );

        $result = $campaign->add();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$buffer[] = $campaign;
    }

    public static function testAdd_TextCampaign_AverageRoi_NetworkDefault(): Campaign
    {
        $campaign = Campaign::make()
            ->setName('TextCampaign_AverageRoi_NetworkDefault')
            ->setStartDate('2029-10-01')
            ->setEndDate('2029-10-10')
            ->setNegativeKeywords(['set', 'negative', 'keywords'])
            ->setTextCampaign(
                TextCampaign::make()
                    ->setBiddingStrategy(
                        TextCampaignStrategy::make()
                            ->setSearch(
                                TextCampaignSearchStrategy::make()
                                    ->setBiddingStrategyType('AVERAGE_ROI')
                                    ->setAverageRoi(
                                        StrategyAverageRoi::make()
                                            ->setReserveReturn(80)
                                            ->setRoiCoef(400000000)
                                            ->setGoalId(0)
                                            ->setWeeklySpendLimit(400000000)
                                            ->setBidCeiling(10000000)
                                            ->setProfitability(50000000)
                                    )
                            )
                            ->setNetwork(
                                TextCampaignNetworkStrategy::make()
                                    ->setBiddingStrategyType('NETWORK_DEFAULT')
                                    ->setNetworkDefault()
                            )
                    )
            );

        $result = $campaign->add();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$buffer[] = $campaign;
    }

    public static function testAdd_TextCampaign_WeeklyClickPackage_NetworkDefault(): Campaign
    {
        $campaign = Campaign::make()
            ->setName('TextCampaign_WeeklyClickPackage_NetworkDefault')
            ->setStartDate('2029-10-01')
            ->setEndDate('2029-10-10')
            ->setNegativeKeywords(['set', 'negative', 'keywords'])
            ->setTextCampaign(
                TextCampaign::make()
                    ->setBiddingStrategy(
                        TextCampaignStrategy::make()
                            ->setSearch(
                                TextCampaignSearchStrategy::make()
                                    ->setBiddingStrategyType('WEEKLY_CLICK_PACKAGE')
                                    ->setWeeklyClickPackage(
                                        StrategyWeeklyClickPackage::make()
                                            ->setClicksPerWeek(100)
                                            ->setAverageCpc(10000000)
                                    )
                            )
                            ->setNetwork(
                                TextCampaignNetworkStrategy::make()
                                    ->setBiddingStrategyType('NETWORK_DEFAULT')
                                    ->setNetworkDefault()
                            )
                    )
            );

        $result = $campaign->add();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$buffer[] = $campaign;
    }

    public static function testAdd_TextCampaign_ServingOff_WbMaximumClicks(): Campaign
    {
        $campaign = Campaign::make()
            ->setName('TextCampaign_ServingOff_WbMaximumClicks')
            ->setStartDate('2029-10-01')
            ->setEndDate('2029-10-10')
            ->setNegativeKeywords(['set', 'negative', 'keywords'])
            ->setTextCampaign(
                TextCampaign::make()
                    ->setBiddingStrategy(
                        TextCampaignStrategy::make()
                            ->setSearch(
                                TextCampaignSearchStrategy::make()
                                    ->setBiddingStrategyType('SERVING_OFF')
                            )
                            ->setNetwork(
                                TextCampaignNetworkStrategy::make()
                                    ->setBiddingStrategyType('WB_MAXIMUM_CLICKS')
                                    ->setWbMaximumClicks(
                                        StrategyMaximumClicks::make()
                                            ->setWeeklySpendLimit(400000000)
                                            ->setBidCeiling(10000000)
                                    )
                            )
                    )
            );

        $result = $campaign->add();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$buffer[] = $campaign;
    }


    public static function testAdd_DynamicTextCampaign_HighestPosition_ServingOff(): Campaign
    {
        $campaign = Campaign::make()
            ->setName('DynamicTextCampaign_HighestPosition_ServingOff')
            ->setStartDate('2029-10-01')
            ->setEndDate('2029-10-10')
            ->setNegativeKeywords(['set', 'negative', 'keywords'])
            ->setDynamicTextCampaign(
                DynamicTextCampaign::make()
                    ->setBiddingStrategy(
                        DynamicTextCampaignStrategy::make()
                            ->setSearch(
                                DynamicTextCampaignSearchStrategy::make()
                                    ->setBiddingStrategyType('HIGHEST_POSITION')
                            )
                            ->setNetwork(
                                DynamicTextCampaignNetworkStrategy::make()
                                    ->setBiddingStrategyType('SERVING_OFF')
                            )
                    )
            );

        $result = $campaign->add();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$buffer[] = $campaign;
    }

    public static function testAdd_DynamicTextCampaign_WbMaximumClicks_ServingOff(): Campaign
    {
        $campaign = Campaign::make()
            ->setName('DynamicTextCampaign_WbMaximumClicks_ServingOff')
            ->setStartDate('2029-10-01')
            ->setEndDate('2029-10-10')
            ->setNegativeKeywords(['set', 'negative', 'keywords'])
            ->setDynamicTextCampaign(
                DynamicTextCampaign::make()
                    ->setBiddingStrategy(
                        DynamicTextCampaignStrategy::make()
                            ->setSearch(
                                DynamicTextCampaignSearchStrategy::make()
                                    ->setBiddingStrategyType('WB_MAXIMUM_CLICKS')
                                    ->setWbMaximumClicks(
                                        StrategyMaximumClicks::make()
                                            ->setWeeklySpendLimit(400000000)
                                            ->setBidCeiling(10000000)
                                    )
                            )
                            ->setNetwork(
                                DynamicTextCampaignNetworkStrategy::make()
                                    ->setBiddingStrategyType('SERVING_OFF')
                            )
                    )
            );

        $result = $campaign->add();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$buffer[] = $campaign;
    }

    public static function testAdd_DynamicTextCampaign_WbMaximumConversionRate_ServingOff(): Campaign
    {
        $campaign = Campaign::make()
            ->setName('DynamicTextCampaign_WbMaximumConversionRate_ServingOff')
            ->setStartDate('2029-10-01')
            ->setEndDate('2029-10-10')
            ->setNegativeKeywords(['set', 'negative', 'keywords'])
            ->setDynamicTextCampaign(
                DynamicTextCampaign::make()
                    ->setBiddingStrategy(
                        DynamicTextCampaignStrategy::make()
                            ->setSearch(
                                DynamicTextCampaignSearchStrategy::make()
                                    ->setBiddingStrategyType('WB_MAXIMUM_CONVERSION_RATE')
                                    ->setWbMaximumConversionRate(
                                        StrategyMaximumConversionRate::make()
                                            ->setWeeklySpendLimit(400000000)
                                            ->setBidCeiling(10000000)
                                            ->setGoalId(0)
                                    )
                            )
                            ->setNetwork(
                                DynamicTextCampaignNetworkStrategy::make()
                                    ->setBiddingStrategyType('SERVING_OFF')
                            )
                    )
            );

        $result = $campaign->add();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$buffer[] = $campaign;
    }

    public static function testAdd_DynamicTextCampaign_AverageCpc_ServingOff(): Campaign
    {
        $campaign = Campaign::make()
            ->setName('DynamicTextCampaign_AverageCpc_ServingOff')
            ->setStartDate('2029-10-01')
            ->setEndDate('2029-10-10')
            ->setNegativeKeywords(['set', 'negative', 'keywords'])
            ->setDynamicTextCampaign(
                DynamicTextCampaign::make()
                    ->setBiddingStrategy(
                        DynamicTextCampaignStrategy::make()
                            ->setSearch(
                                DynamicTextCampaignSearchStrategy::make()
                                    ->setBiddingStrategyType('AVERAGE_CPC')
                                    ->setAverageCpc(
                                        StrategyAverageCpc::make()
                                            ->setAverageCpc(10000000)
                                            ->setWeeklySpendLimit(400000000)
                                    )
                            )
                            ->setNetwork(
                                DynamicTextCampaignNetworkStrategy::make()
                                    ->setBiddingStrategyType('SERVING_OFF')
                            )
                    )
            );

        $result = $campaign->add();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$buffer[] = $campaign;
    }

    public static function testAdd_DynamicTextCampaign_AverageCpa_ServingOff(): Campaign
    {
        $campaign = Campaign::make()
            ->setName('DynamicTextCampaign_AverageCpa_ServingOff')
            ->setStartDate('2029-10-01')
            ->setEndDate('2029-10-10')
            ->setNegativeKeywords(['set', 'negative', 'keywords'])
            ->setDynamicTextCampaign(
                DynamicTextCampaign::make()
                    ->setBiddingStrategy(
                        DynamicTextCampaignStrategy::make()
                            ->setSearch(
                                DynamicTextCampaignSearchStrategy::make()
                                    ->setBiddingStrategyType('AVERAGE_CPA')
                                    ->setAverageCpa(
                                        StrategyAverageCpa::make()
                                            ->setAverageCpa(10000000)
                                            ->setWeeklySpendLimit(400000000)
                                            ->setBidCeiling(20000000)
                                            ->setGoalId(0)
                                    )
                            )
                            ->setNetwork(
                                DynamicTextCampaignNetworkStrategy::make()
                                    ->setBiddingStrategyType('SERVING_OFF')
                            )
                    )
            );

        $result = $campaign->add();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$buffer[] = $campaign;
    }

    public static function testAdd_DynamicTextCampaign_AverageRoi_ServingOff(): Campaign
    {
        $campaign = Campaign::make()
            ->setName('DynamicTextCampaign_AverageRoi_ServingOff')
            ->setStartDate('2029-10-01')
            ->setEndDate('2029-10-10')
            ->setNegativeKeywords(['set', 'negative', 'keywords'])
            ->setDynamicTextCampaign(
                DynamicTextCampaign::make()
                    ->setBiddingStrategy(
                        DynamicTextCampaignStrategy::make()
                            ->setSearch(
                                DynamicTextCampaignSearchStrategy::make()
                                    ->setBiddingStrategyType('AVERAGE_ROI')
                                    ->setAverageRoi(
                                        StrategyAverageRoi::make()
                                            ->setReserveReturn(80)
                                            ->setRoiCoef(400000000)
                                            ->setGoalId(0)
                                            ->setWeeklySpendLimit(400000000)
                                            ->setBidCeiling(10000000)
                                            ->setProfitability(50000000)
                                    )
                            )
                            ->setNetwork(
                                DynamicTextCampaignNetworkStrategy::make()
                                    ->setBiddingStrategyType('SERVING_OFF')
                            )
                    )
            );

        $result = $campaign->add();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$buffer[] = $campaign;
    }

    public static function testAdd_DynamicTextCampaign_WeeklyClickPackage_ServingOff(): Campaign
    {
        $campaign = Campaign::make()
            ->setName('DynamicTextCampaign_WeeklyClickPackage_ServingOff')
            ->setStartDate('2029-10-01')
            ->setEndDate('2029-10-10')
            ->setNegativeKeywords(['set', 'negative', 'keywords'])
            ->setDynamicTextCampaign(
                DynamicTextCampaign::make()
                    ->setBiddingStrategy(
                        DynamicTextCampaignStrategy::make()
                            ->setSearch(
                                DynamicTextCampaignSearchStrategy::make()
                                    ->setBiddingStrategyType('WEEKLY_CLICK_PACKAGE')
                                    ->setWeeklyClickPackage(
                                        StrategyWeeklyClickPackage::make()
                                            ->setClicksPerWeek(100)
                                            ->setAverageCpc(10000000)
                                    )
                            )
                            ->setNetwork(
                                DynamicTextCampaignNetworkStrategy::make()
                                    ->setBiddingStrategyType('SERVING_OFF')
                            )
                    )
            );

        $result = $campaign->add();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$buffer[] = $campaign;
    }


    public static function testAdd_MobileAppCampaign_HighestPosition_NetworkDefault(): Campaign
    {
        $campaign = Campaign::make()
            ->setName('MobileAppCampaign_HighestPosition_NetworkDefault')
            ->setStartDate('2029-10-01')
            ->setEndDate('2029-10-10')
            ->setNegativeKeywords(['set', 'negative', 'keywords'])
            ->setMobileAppCampaign(
                MobileAppCampaign::make()
                    ->setBiddingStrategy(
                        MobileAppCampaignStrategy::make()
                            ->setSearch(
                                MobileAppCampaignSearchStrategy::make()
                                    ->setBiddingStrategyType('HIGHEST_POSITION')
                            )
                            ->setNetwork(
                                MobileAppCampaignNetworkStrategy::make()
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
        return static::$buffer[] = $campaign;
    }

    public static function testAdd_MobileAppCampaign_WbMaximumClicks_NetworkDefault(): Campaign
    {
        $campaign = Campaign::make()
            ->setName('MobileAppCampaign_WbMaximumClicks_NetworkDefault')
            ->setStartDate('2029-10-01')
            ->setEndDate('2029-10-10')
            ->setNegativeKeywords(['set', 'negative', 'keywords'])
            ->setMobileAppCampaign(
                MobileAppCampaign::make()
                    ->setBiddingStrategy(
                        MobileAppCampaignStrategy::make()
                            ->setSearch(
                                MobileAppCampaignSearchStrategy::make()
                                    ->setBiddingStrategyType('WB_MAXIMUM_CLICKS')
                                    ->setWbMaximumClicks(
                                        StrategyMaximumClicks::make()
                                            ->setWeeklySpendLimit(400000000)
                                            ->setBidCeiling(10000000)
                                    )
                            )
                            ->setNetwork(
                                MobileAppCampaignNetworkStrategy::make()
                                    ->setBiddingStrategyType('NETWORK_DEFAULT')
                                    ->setNetworkDefault()
                            )
                    )
            );

        $result = $campaign->add();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$buffer[] = $campaign;
    }

    public static function testAdd_MobileAppCampaign_WbMaximumAppInstalls_NetworkDefault(): Campaign
    {
        $campaign = Campaign::make()
            ->setName('MobileAppCampaign_WbMaximumAppInstalls_NetworkDefault')
            ->setStartDate('2029-10-01')
            ->setEndDate('2029-10-10')
            ->setNegativeKeywords(['set', 'negative', 'keywords'])
            ->setMobileAppCampaign(
                MobileAppCampaign::make()
                    ->setBiddingStrategy(
                        MobileAppCampaignStrategy::make()
                            ->setSearch(
                                MobileAppCampaignSearchStrategy::make()
                                    ->setBiddingStrategyType('WB_MAXIMUM_APP_INSTALLS')
                                    ->setWbMaximumAppInstalls(
                                        StrategyMaximumAppInstalls::make()
                                            ->setWeeklySpendLimit(400000000)
                                            ->setBidCeiling(10000000)
                                    )
                            )
                            ->setNetwork(
                                MobileAppCampaignNetworkStrategy::make()
                                    ->setBiddingStrategyType('NETWORK_DEFAULT')
                                    ->setNetworkDefault()
                            )
                    )
            );

        $result = $campaign->add();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$buffer[] = $campaign;
    }

    public static function testAdd_MobileAppCampaign_AverageCpc_NetworkDefault(): Campaign
    {
        $campaign = Campaign::make()
            ->setName('MobileAppCampaign_AverageCpc_NetworkDefault')
            ->setStartDate('2029-10-01')
            ->setEndDate('2029-10-10')
            ->setNegativeKeywords(['set', 'negative', 'keywords'])
            ->setMobileAppCampaign(
                MobileAppCampaign::make()
                    ->setBiddingStrategy(
                        MobileAppCampaignStrategy::make()
                            ->setSearch(
                                MobileAppCampaignSearchStrategy::make()
                                    ->setBiddingStrategyType('AVERAGE_CPC')
                                    ->setAverageCpc(
                                        StrategyAverageCpc::make()
                                            ->setAverageCpc(10000000)
                                            ->setWeeklySpendLimit(400000000)
                                    )
                            )
                            ->setNetwork(
                                MobileAppCampaignNetworkStrategy::make()
                                    ->setBiddingStrategyType('NETWORK_DEFAULT')
                                    ->setNetworkDefault()
                            )
                    )
            );

        $result = $campaign->add();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$buffer[] = $campaign;
    }

    public static function testAdd_MobileAppCampaign_AverageCpi_NetworkDefault(): Campaign
    {
        $campaign = Campaign::make()
            ->setName('MobileAppCampaign_AverageCpi_NetworkDefault')
            ->setStartDate('2029-10-01')
            ->setEndDate('2029-10-10')
            ->setNegativeKeywords(['set', 'negative', 'keywords'])
            ->setMobileAppCampaign(
                MobileAppCampaign::make()
                    ->setBiddingStrategy(
                        MobileAppCampaignStrategy::make()
                            ->setSearch(
                                MobileAppCampaignSearchStrategy::make()
                                    ->setBiddingStrategyType('AVERAGE_CPI')
                                    ->setAverageCpi(
                                        StrategyAverageCpi::make()
                                            ->setAverageCpi(10000000)
                                            ->setWeeklySpendLimit(400000000)
                                            ->setBidCeiling(20000000)
                                    )
                            )
                            ->setNetwork(
                                MobileAppCampaignNetworkStrategy::make()
                                    ->setBiddingStrategyType('NETWORK_DEFAULT')
                                    ->setNetworkDefault()
                            )
                    )
            );

        $result = $campaign->add();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$buffer[] = $campaign;
    }

    public static function testAdd_MobileAppCampaign_WeeklyClickPackage_NetworkDefault(): Campaign
    {
        $campaign = Campaign::make()
            ->setName('MobileAppCampaign_WeeklyClickPackage_NetworkDefault')
            ->setStartDate('2029-10-01')
            ->setEndDate('2029-10-10')
            ->setNegativeKeywords(['set', 'negative', 'keywords'])
            ->setMobileAppCampaign(
                MobileAppCampaign::make()
                    ->setBiddingStrategy(
                        MobileAppCampaignStrategy::make()
                            ->setSearch(
                                MobileAppCampaignSearchStrategy::make()
                                    ->setBiddingStrategyType('WEEKLY_CLICK_PACKAGE')
                                    ->setWeeklyClickPackage(
                                        StrategyWeeklyClickPackage::make()
                                            ->setClicksPerWeek(100)
                                            ->setAverageCpc(10000000)
                                    )
                            )
                            ->setNetwork(
                                MobileAppCampaignNetworkStrategy::make()
                                    ->setBiddingStrategyType('NETWORK_DEFAULT')
                                    ->setNetworkDefault()
                            )
                    )
            );

        $result = $campaign->add();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$buffer[] = $campaign;
    }

    public static function testAdd_MobileAppCampaign_ServingOff_WbMaximumClicks(): Campaign
    {
        $campaign = Campaign::make()
            ->setName('MobileAppCampaign_ServingOff_WbMaximumClicks')
            ->setStartDate('2029-10-01')
            ->setEndDate('2029-10-10')
            ->setNegativeKeywords(['set', 'negative', 'keywords'])
            ->setMobileAppCampaign(
                MobileAppCampaign::make()
                    ->setBiddingStrategy(
                        MobileAppCampaignStrategy::make()
                            ->setSearch(
                                MobileAppCampaignSearchStrategy::make()
                                    ->setBiddingStrategyType('SERVING_OFF')
                            )
                            ->setNetwork(
                                MobileAppCampaignNetworkStrategy::make()
                                    ->setBiddingStrategyType('WB_MAXIMUM_CLICKS')
                                    ->setWbMaximumClicks(
                                        StrategyMaximumClicks::make()
                                            ->setWeeklySpendLimit(400000000)
                                            ->setBidCeiling(10000000)
                                    )
                            )
                    )
            );

        $result = $campaign->add();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$buffer[] = $campaign;
    }


    public static function testAdd_CpmBannerCampaign_ServingOff_ManualCpm(): Campaign
    {
        $campaign = Campaign::make()
            ->setName('CpmBannerCampaign_ServingOff_ManualCpm')
            ->setStartDate('2029-10-01')
            ->setEndDate('2029-10-10')
            ->setCpmBannerCampaign(
                CpmBannerCampaign::make()
                    ->setBiddingStrategy(
                        CpmBannerCampaignStrategy::make()
                            ->setSearch(
                                CpmBannerCampaignSearchStrategy::make()
                                    ->setBiddingStrategyType('SERVING_OFF')
                            )
                            ->setNetwork(
                                CpmBannerCampaignNetworkStrategy::make()
                                    ->setBiddingStrategyType('MANUAL_CPM')
                            )
                    )
            );

        $result = $campaign->add();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$buffer[] = $campaign;
    }

    public static function testAdd_CpmBannerCampaign_ServingOff_WbMaximumImpressions(): Campaign
    {
        $campaign = Campaign::make()
            ->setName('CpmBannerCampaign_ServingOff_WbMaximumImpressions')
            ->setStartDate('2029-10-01')
            ->setEndDate('2029-10-10')
            ->setCpmBannerCampaign(
                CpmBannerCampaign::make()
                    ->setBiddingStrategy(
                        CpmBannerCampaignStrategy::make()
                            ->setSearch(
                                CpmBannerCampaignSearchStrategy::make()
                                    ->setBiddingStrategyType('SERVING_OFF')
                            )
                            ->setNetwork(
                                CpmBannerCampaignNetworkStrategy::make()
                                    ->setBiddingStrategyType('WB_MAXIMUM_IMPRESSIONS')
                                    ->setWbMaximumImpressions(
                                        StrategyWbMaximumImpressions::make()
                                            ->setAverageCpm(10000000)
                                            ->setSpendLimit(5000000000)
                                    )
                            )
                    )
            );

        $result = $campaign->add();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$buffer[] = $campaign;
    }

    public static function testAdd_CpmBannerCampaign_ServingOff_CpMaximumImpressions(): Campaign
    {
        $campaign = Campaign::make()
            ->setName('CpmBannerCampaign_ServingOff_CpMaximumImpressions')
            ->setStartDate('2029-10-01')
            ->setEndDate('2029-10-10')
            ->setCpmBannerCampaign(
                CpmBannerCampaign::make()
                    ->setBiddingStrategy(
                        CpmBannerCampaignStrategy::make()
                            ->setSearch(
                                CpmBannerCampaignSearchStrategy::make()
                                    ->setBiddingStrategyType('SERVING_OFF')
                            )
                            ->setNetwork(
                                CpmBannerCampaignNetworkStrategy::make()
                                    ->setBiddingStrategyType('CP_MAXIMUM_IMPRESSIONS')
                                    ->setCpMaximumImpressions(
                                        StrategyCpMaximumImpressions::make()
                                            ->setAverageCpm(10000000)
                                            ->setSpendLimit(5000000000)
                                            ->setStartDate('2029-10-01')
                                            ->setEndDate('2029-10-10')
                                            ->setAutoContinue('NO')
                                    )
                            )
                    )
            );

        $result = $campaign->add();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$buffer[] = $campaign;
    }

    public static function testAdd_CpmBannerCampaign_ServingOff_WbDecreasedPriceForRepeatedImpressions(): Campaign
    {
        $campaign = Campaign::make()
            ->setName('CpmBannerCampaign_ServingOff_WbDecreasedPriceForRepeatedImpressions')
            ->setStartDate('2029-10-01')
            ->setEndDate('2029-10-10')
            ->setCpmBannerCampaign(
                CpmBannerCampaign::make()
                    ->setBiddingStrategy(
                        CpmBannerCampaignStrategy::make()
                            ->setSearch(
                                CpmBannerCampaignSearchStrategy::make()
                                    ->setBiddingStrategyType('SERVING_OFF')
                            )
                            ->setNetwork(
                                CpmBannerCampaignNetworkStrategy::make()
                                    ->setBiddingStrategyType('WB_DECREASED_PRICE_FOR_REPEATED_IMPRESSIONS')
                                    ->setWbDecreasedPriceForRepeatedImpressions(
                                        StrategyWbDecreasedPriceForRepeatedImpressions::make()
                                            ->setAverageCpm(10000000)
                                            ->setSpendLimit(5000000000)
                                    )
                            )
                    )
            );

        $result = $campaign->add();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$buffer[] = $campaign;
    }

    public static function testAdd_CpmBannerCampaign_ServingOff_CpDecreasedPriceForRepeatedImpressions(): Campaign
    {
        $campaign = Campaign::make()
            ->setName('CpmBannerCampaign_ServingOff_CpDecreasedPriceForRepeatedImpressions')
            ->setStartDate('2029-10-01')
            ->setEndDate('2029-10-10')
            ->setCpmBannerCampaign(
                CpmBannerCampaign::make()
                    ->setBiddingStrategy(
                        CpmBannerCampaignStrategy::make()
                            ->setSearch(
                                CpmBannerCampaignSearchStrategy::make()
                                    ->setBiddingStrategyType('SERVING_OFF')
                            )
                            ->setNetwork(
                                CpmBannerCampaignNetworkStrategy::make()
                                    ->setBiddingStrategyType('CP_DECREASED_PRICE_FOR_REPEATED_IMPRESSIONS')
                                    ->setCpDecreasedPriceForRepeatedImpressions(
                                        StrategyCpDecreasedPriceForRepeatedImpressions::make()
                                            ->setAverageCpm(10000000)
                                            ->setSpendLimit(5000000000)
                                            ->setStartDate('2029-10-01')
                                            ->setEndDate('2029-10-10')
                                            ->setAutoContinue('NO')
                                    )
                            )
                    )
            );

        $result = $campaign->add();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$buffer[] = $campaign;
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Actions
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAdd_TextCampaign_HighestPosition_MaximumCoverage
     * @param Campaign $campaign
     */
    public static function testSuspend(Campaign $campaign): void
    {
        $result = $campaign->suspend();

        // [ Post processing ] =========================================================================================

        Checklists::checkResult($result);
        sleep(10);
    }

    /**
     * @depends testAdd_TextCampaign_HighestPosition_MaximumCoverage
     * @depends testSuspend
     * @param Campaign $campaign
     */
    public static function testArchive(Campaign $campaign): void
    {
        $result = $campaign->archive();

        // [ Post processing ] =========================================================================================

        Checklists::checkResult($result);
        sleep(10);
    }

    /**
     * @depends testAdd_TextCampaign_HighestPosition_MaximumCoverage
     * @depends testArchive
     * @param Campaign $campaign
     */
    public static function testUnarchive(Campaign $campaign): void
    {
        $result = $campaign->unarchive();

        // [ Post processing ] =========================================================================================

        Checklists::checkResult($result);
        sleep(10);
    }

    /**
     * @depends testAdd_TextCampaign_HighestPosition_MaximumCoverage
     * @depends testUnarchive
     * @param Campaign $campaign
     */
    public function testResume(Campaign $campaign): void
    {
        $result = $campaign->resume();

        // [ Post processing ] =========================================================================================

        Checklists::checkResult($result);
        sleep(10);
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Related
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAdd_TextCampaign_HighestPosition_MaximumCoverage
     * @param Campaign $campaign
     */
    public static function testAddRelatedAdGroups(Campaign $campaign): void
    {
        $adGroups = AdGroups::wrap([
            AdGroup::make()
                ->setName('MyAdGroup one')
                ->setRegionIds([225])
                ->setNegativeKeywords(['negative','keywords'])
                ->setTrackingParams('from=direct&ad={ad_id}'),
            AdGroup::make()
                ->setName('MyAdGroup two')
                ->setRegionIds([225])
        ]);

        $result = $campaign->addRelatedAdGroups($adGroups);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, AdGroups::class, [
            'Id' => 'required|integer',
            'CampaignId' => 'required|integer',
            'Name' => 'required|string',
            'RegionIds' => 'required|array_of:integer',
            'NegativeKeywords.Items' => 'array_of:string',
            'TrackingParams' => 'string'
        ]);

        Checklists::checkResult(
            $result->getResource()->delete()
        );
    }

    /**
     * @depends testAdd_TextCampaign_HighestPosition_MaximumCoverage
     * @param Campaign $campaign
     */
    public static function testAddRelatedAdGroup_TextCampaign_HighestPosition_MaximumCoverage_TextAdGroup(Campaign $campaign): void
    {
        $adGroup = AdGroup::make()
            ->setName('TextAdGroup')
            ->setRegionIds([225])
            ->setNegativeKeywords(['negative','keywords'])
            ->setTrackingParams('from=direct&ad={ad_id}');

        $result = $campaign->addRelatedAdGroups($adGroup);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, AdGroups::class, [
            'Id' => 'required|integer',
            'CampaignId' => 'required|integer',
            'Name' => 'required|string',
            'RegionIds' => 'required|array_of:integer',
            'NegativeKeywords.Items' => 'required|array_of:string',
            'TrackingParams' => 'required|string'
        ]);

        $adGroups = $campaign
            ->getRelatedAdGroups(['Id', 'Name'])
            ->getResource();

        $result = $adGroups->addRelatedAds(
            Ad::make()
                ->setTextAd(
                    TextAd::make()
                        ->setTitle('Title of my ad')
                        ->setTitle2('Title of my second ad')
                        ->setText('My ad text')
                        ->setHref('https://mysite.com/page/')
                        ->setMobile('NO')
                )
        );

        Checklists::checkResource($result, Ads::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'TextAd.Title' => 'required|string',
            'TextAd.Title2' => 'required|string',
            'TextAd.Text' => 'required|string',
            'TextAd.Href' => 'required|string',
            'TextAd.Mobile' => 'required|string'
        ]);

        $result = $adGroups->addRelatedKeywords(
            Keywords::make(
                Keyword::make()->setKeyword('yandex api'),
                Keyword::make()->setKeyword('yandex direct')
            )
        );

        Checklists::checkResource($result, Keywords::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'Keyword' => 'required|string'
        ]);
    }

    /**
     * @depends testAdd_TextCampaign_WbMaximumClicks_NetworkDefault
     * @param Campaign $campaign
     */
    public static function testAddRelatedAdGroup_TextCampaign_WbMaximumClicks_NetworkDefault_TextAdGroup(Campaign $campaign): void
    {
        $adGroup = AdGroup::make()
            ->setName('TextAdGroup')
            ->setRegionIds([225])
            ->setNegativeKeywords(['negative','keywords'])
            ->setTrackingParams('from=direct&ad={ad_id}');

        $result = $campaign->addRelatedAdGroups($adGroup);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, AdGroups::class, [
            'Id' => 'required|integer',
            'CampaignId' => 'required|integer',
            'Name' => 'required|string',
            'RegionIds' => 'required|array_of:integer',
            'NegativeKeywords.Items' => 'required|array_of:string',
            'TrackingParams' => 'required|string'
        ]);

        $adGroups = $campaign
            ->getRelatedAdGroups(['Id', 'Name'])
            ->getResource();

        $result = $adGroups->addRelatedAds(
            Ad::make()
                ->setTextAd(
                    TextAd::make()
                        ->setTitle('Title of my ad')
                        ->setTitle2('Title of my second ad')
                        ->setText('My ad text')
                        ->setHref('https://mysite.com/page/')
                        ->setMobile('NO')
                )
        );

        Checklists::checkResource($result, Ads::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'TextAd.Title' => 'required|string',
            'TextAd.Title2' => 'required|string',
            'TextAd.Text' => 'required|string',
            'TextAd.Href' => 'required|string',
            'TextAd.Mobile' => 'required|string'
        ]);

        $result = $adGroups->addRelatedKeywords(
            Keywords::make(
                Keyword::make()->setKeyword('yandex api'),
                Keyword::make()->setKeyword('yandex direct')
            )
        );

        Checklists::checkResource($result, Keywords::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'Keyword' => 'required|string'
        ]);
    }

    /**
     * @depends testAdd_DynamicTextCampaign_HighestPosition_ServingOff
     * @param Campaign $campaign
     */
    public static function testAddRelatedAdGroup_DynamicTextCampaign_HighestPosition_ServingOff_DynamicTextAdGroup(Campaign $campaign): void
    {
        $adGroup = AdGroup::make()
            ->setName('DynamicTextAdGroup')
            ->setRegionIds([225])
            ->setNegativeKeywords(['negative','keywords'])
            ->setTrackingParams('from=direct&ad={ad_id}')
            ->setDynamicTextAdGroup(
                DynamicTextAdGroup::make()
                    ->setDomainUrl('yandex.ru')
            );

        $result = $campaign->addRelatedAdGroups($adGroup);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, AdGroups::class, [
            'Id' => 'required|integer',
            'CampaignId' => 'required|integer',
            'Name' => 'required|string',
            'RegionIds' => 'required|array_of:integer',
            'NegativeKeywords.Items' => 'required|array_of:string',
            'TrackingParams' => 'required|string'
        ]);
    }

    /**
     * @depends testAdd_MobileAppCampaign_HighestPosition_NetworkDefault
     * @param Campaign $campaign
     */
    public static function testAddRelatedAdGroup_MobileAppCampaign_HighestPosition_NetworkDefault_MobileAppAdGroup(Campaign $campaign): void
    {
        $adGroup = AdGroup::make()
            ->setName('MobileAppAdGroup')
            ->setRegionIds([225])
            ->setNegativeKeywords(['negative','keywords'])
            ->setTrackingParams('from=direct&ad={ad_id}')
            ->setMobileAppAdGroup(
                MobileAppAdGroup::make()
                    ->setStoreUrl('https://play.google.com/store/apps/details?id=ru.yandex.direct')
                    ->setTargetDeviceType(['DEVICE_TYPE_MOBILE','DEVICE_TYPE_TABLET'])
                    ->setTargetCarrier('WI_FI_AND_CELLULAR')
                    ->setTargetOperatingSystemVersion('2.3')

            );

        $result = $campaign->addRelatedAdGroups($adGroup);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, AdGroups::class, [
            'Id' => 'required|integer',
            'CampaignId' => 'required|integer',
            'Name' => 'required|string',
            'RegionIds' => 'required|array_of:integer',
            'NegativeKeywords.Items' => 'required|array_of:string',
            'TrackingParams' => 'required|string'
        ]);
    }

    /**
     * @depends testAdd_CpmBannerCampaign_ServingOff_ManualCpm
     * @param Campaign $campaign
     */
    public static function testAddRelatedAdGroup_CpmBannerCampaign_ServingOff_ManualCpm_CpmBannerKeywordsAdGroup(Campaign $campaign): void
    {
        $adGroup = AdGroup::make()
            ->setName('CpmBannerKeywordsAdGroup')
            ->setRegionIds([225])
            ->setNegativeKeywords(['negative','keywords'])
            ->setTrackingParams('from=direct&ad={ad_id}')
            ->setCpmBannerKeywordsAdGroup();

        $result = $campaign->addRelatedAdGroups($adGroup);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, AdGroups::class, [
            'Id' => 'required|integer',
            'CampaignId' => 'required|integer',
            'Name' => 'required|string',
            'RegionIds' => 'required|array_of:integer',
            'NegativeKeywords.Items' => 'required|array_of:string',
            'TrackingParams' => 'required|string',
            'CpmBannerKeywordsAdGroup' => 'required'
        ]);
    }

    /**
     * @depends testAdd_CpmBannerCampaign_ServingOff_ManualCpm
     * @param Campaign $campaign
     */
    public static function testAddRelatedAdGroup_CpmBannerCampaign_ServingOff_ManualCpm_CpmBannerUserProfileAdGroup(Campaign $campaign): void
    {
        $adGroup = AdGroup::make()
            ->setName('CpmBannerUserProfileAdGroup')
            ->setRegionIds([225])
            ->setTrackingParams('from=direct&ad={ad_id}')
            ->setCpmBannerUserProfileAdGroup();

        $result = $campaign->addRelatedAdGroups($adGroup);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, AdGroups::class, [
            'Id' => 'required|integer',
            'CampaignId' => 'required|integer',
            'Name' => 'required|string',
            'RegionIds' => 'required|array_of:integer',
            'TrackingParams' => 'required|string',
            'CpmBannerUserProfileAdGroup' => 'required'
        ]);
    }

    /**
     * @depends testAdd_CpmBannerCampaign_ServingOff_ManualCpm
     * @param Campaign $campaign
     */
    public static function testAddRelatedAdGroup_CpmBannerCampaign_ServingOff_ManualCpm_CpmVideoAdGroup(Campaign $campaign): void
    {
        $adGroup = AdGroup::make()
            ->setName('CpmVideoAdGroup')
            ->setRegionIds([225])
            ->setTrackingParams('from=direct&ad={ad_id}')
            ->setCpmVideoAdGroup();

        $result = $campaign->addRelatedAdGroups($adGroup);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, AdGroups::class, [
            'Id' => 'required|integer',
            'CampaignId' => 'required|integer',
            'Name' => 'required|string',
            'RegionIds' => 'required|array_of:integer',
            'TrackingParams' => 'required|string',
            'CpmVideoAdGroup' => 'required'
        ]);
    }

    /**
     * @depends testAdd_TextCampaign_HighestPosition_MaximumCoverage
     * @depends testAddRelatedAdGroup_TextCampaign_HighestPosition_MaximumCoverage_TextAdGroup
     * @param Campaign $campaign
     */
    public static function testGetRelatedAdGroups(Campaign $campaign): void
    {
        $result = $campaign->getRelatedAdGroups(['Id', 'Name']);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, AdGroups::class, [
            'Id' => 'required|integer',
            'Name' => 'required|string',
        ]);
    }

    /**
     * @depends testAdd_TextCampaign_HighestPosition_MaximumCoverage
     * @depends testAddRelatedAdGroup_TextCampaign_HighestPosition_MaximumCoverage_TextAdGroup
     * @param Campaign $campaign
     */
    public static function testGetRelatedAds(Campaign $campaign): void
    {
        // [ Preprocessing ] ===========================================================================================

        $result = $campaign->getRelatedAds(['Id','TextAd.Title']);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Ads::class, [
            'Id' => 'required|integer',
            'TextAd.Title' => 'required|string',
        ]);
    }

    /**
     * @depends testAdd_TextCampaign_HighestPosition_MaximumCoverage
     * @depends testAddRelatedAdGroup_TextCampaign_HighestPosition_MaximumCoverage_TextAdGroup
     * @param Campaign $campaign
     */
    public static function testAddRelatedBidModifiers(Campaign $campaign): void
    {
        $bidModifier = BidModifier::make()
            ->setRegionalAdjustment(
                RegionalAdjustment::make()
                    ->setRegionId(225)
                    ->setBidModifier(50)
            );

        $result = $campaign->addRelatedBidModifiers($bidModifier);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, BidModifiers::class, [
            'Id' => 'required|integer',
            'CampaignId' => 'required|integer',
            'RegionalAdjustment.RegionId' => 'required|integer',
            'RegionalAdjustment.BidModifier' => 'required|integer'
        ]);
    }

    /**
     * @depends testAdd_TextCampaign_HighestPosition_MaximumCoverage
     * @depends testAddRelatedBidModifiers
     * @param Campaign $campaign
     */
    public static function testGetRelatedBidModifiers(Campaign $campaign): void
    {
        $result = $campaign->getRelatedBidModifiers([
            'Id',
            'CampaignId',
            'RegionalAdjustment.RegionId',
            'RegionalAdjustment.BidModifier'
        ]);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, BidModifiers::class, [
            'Id' => 'required|integer',
            'CampaignId' => 'required|integer',
            'RegionalAdjustment.RegionId' => 'required|integer',
            'RegionalAdjustment.BidModifier' => 'required|integer'
        ]);
    }

    /**
     * @depends testAdd_TextCampaign_HighestPosition_MaximumCoverage
     * @depends testAddRelatedBidModifiers
     * @param Campaign $campaign
     */
    public static function testDisableBidModifiers(Campaign $campaign): void
    {
        $result = $campaign->disableBidModifiers('REGIONAL_ADJUSTMENT');

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, BidModifierToggles::class);
        sleep(10);
    }

    /**
     * @depends testAdd_TextCampaign_HighestPosition_MaximumCoverage
     * @depends testDisableBidModifiers
     * @param Campaign $campaign
     */
    public static function testEnableBidModifiers(Campaign $campaign): void
    {
        $result = $campaign->enableBidModifiers('REGIONAL_ADJUSTMENT');

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, BidModifierToggles::class);
        sleep(10);
    }

    /**
     * @depends testAdd_TextCampaign_HighestPosition_MaximumCoverage
     * @param Campaign $campaign
     */
    public static function testGetRelatedAudienceTarget(Campaign $campaign): void
    {
        $result = $campaign->getRelatedAudienceTargets(['Id','AdGroupId','State']);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, AudienceTargets::class);

        Env::useLocalApi(true);
        $result = $campaign->getRelatedAudienceTargets(['Id','AdGroupId','State']);
        Env::useLocalApi(false);

        Checklists::checkResource($result, AudienceTargets::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'CampaignId' => 'required|integer',
            'RetargetingListId' => 'required|integer',
            'InterestId' => 'required|integer',
            'State' => 'required|string',
            'ContextBid' => 'required|integer',
            'StrategyPriority' => 'required|string'
        ]);
    }

    /**
     * @depends testAdd_TextCampaign_HighestPosition_MaximumCoverage
     * @depends testAddRelatedAdGroup_TextCampaign_HighestPosition_MaximumCoverage_TextAdGroup
     * @param Campaign $campaign
     */
    public static function testSetRelatedBids(Campaign $campaign): void
    {
        $result = $campaign->setRelatedBids(30000000, 10000000);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Bids::class, [
            'CampaignId' => 'required|integer',
            'Bid' => 'required|integer',
            'ContextBid' => 'required|integer'
        ]);
    }

    /**
     * @depends testAdd_TextCampaign_HighestPosition_MaximumCoverage
     * @depends testAddRelatedAdGroup_TextCampaign_HighestPosition_MaximumCoverage_TextAdGroup
     * @param Campaign $campaign
     */
    public static function testSetRelatedContextBids(Campaign $campaign): void
    {
        $result = $campaign->setRelatedContextBids(10000000);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Bids::class, [
            'CampaignId' => 'required|integer',
            'ContextBid' => 'required|integer'
        ]);
    }

    /**
     * @depends testAdd_TextCampaign_WbMaximumClicks_NetworkDefault
     * @depends testAddRelatedAdGroup_TextCampaign_WbMaximumClicks_NetworkDefault_TextAdGroup
     * @param Campaign $campaign
     */
    public static function testSetRelatedStrategyPriority(Campaign $campaign): void
    {
        $result = $campaign->setRelatedStrategyPriority('LOW');

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Bids::class, [
            'CampaignId' => 'required|integer',
            'StrategyPriority' => 'required|string'
        ]);
    }

    /**
     * @depends testAdd_TextCampaign_HighestPosition_MaximumCoverage
     * @depends testAddRelatedAdGroup_TextCampaign_HighestPosition_MaximumCoverage_TextAdGroup
     * @param Campaign $campaign
     */
    public static function testSetRelatedBidsAuto(Campaign $campaign): void
    {
        $bidAuto = BidAuto::make()
            ->setScope(['SEARCH'])
            ->setPosition('PREMIUMBLOCK');

        $result = $campaign->setRelatedBidsAuto($bidAuto);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, BidsAuto::class, [
            'CampaignId' => 'required|integer',
            'Scope' => 'required|array',
            'Position' => 'string'
        ]);
    }

    /**
     * @depends testAdd_TextCampaign_HighestPosition_MaximumCoverage
     * @depends testSetRelatedBids
     * @param Campaign $campaign
     */
    public static function testGetRelatedBids(Campaign $campaign): void
    {
        $result = $campaign->getRelatedBids(['Bid','CampaignId','AdGroupId','KeywordId']);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Bids::class, [
            'Bid' => 'required|integer',
            'CampaignId' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'KeywordId' => 'required|integer'
        ]);

    }

    /**
     * @depends testAdd_TextCampaign_HighestPosition_MaximumCoverage
     * @depends testAddRelatedAdGroup_TextCampaign_HighestPosition_MaximumCoverage_TextAdGroup
     * @param Campaign $campaign
     */
    public static function testGetRelatedKeywords(Campaign $campaign): void
    {
        $result = $campaign->getRelatedKeywords(['Id','Keyword','Status']);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Keywords::class, [
            'Id' => 'required|integer',
            'Keyword' => 'required|string',
            'Status' => 'required|string'
        ]);
    }

    /**
     * @depends testAdd_TextCampaign_HighestPosition_MaximumCoverage
     * @param Campaign $campaign
     */
    public static function testGetRelatedWebpages(Campaign $campaign): void
    {
        $result = $campaign->getRelatedWebpages(['Id','Name','CampaignId','AdGroupId']);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Webpages::class);

        Env::useLocalApi(true);
        $result = $campaign->getRelatedWebpages(['Id','Name','CampaignId','AdGroupId']);
        Env::useLocalApi(false);

        Checklists::checkResource($result, Webpages::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'CampaignId' => 'required|integer',
            'Name' => 'required|string',
            'Bid' => 'required|integer',
            'ContextBid' => 'required|integer',
            'StrategyPriority' => 'required|string',
            'State' => 'required|string',
            'StatusClarification' => 'required|string',
            'Conditions.*.Operand' => 'required|string',
            'Conditions.*.Operator' => 'required|string',
            'Conditions.*.Arguments' => 'required|array',
            'ConditionType' => 'required|string'
        ]);
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Update
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAdd_TextCampaign_HighestPosition_MaximumCoverage
     * @param Campaign $campaign
     */
    public static function testUpdateCampaign(Campaign $campaign): void
    {
        // [ Pre processing ] ==========================================================================================

        $campaignID = $campaign->id;

        // [ Example ] =================================================================================================

        $campaign = Campaign::find($campaignID, [
            'Id',
            'Name',
            'NegativeKeywords',
            'TextCampaign.CounterIds',
            'TextCampaign.Settings'
        ]);

        $campaign->textCampaign->setCounterIds([1234, 4321]);
        $campaign->textCampaign->setSettings(
            TextCampaignSettings::make(
                TextCampaignSetting::addMetricaTag(true),
                TextCampaignSetting::addToFavorites(true)
            )
        );

        $result = $campaign->update();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Campaigns::class);
    }


    /*
     |-------------------------------------------------------------------------------
     |
     | Delete
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAdd_TextCampaign_HighestPosition_MaximumCoverage
     * @param Campaign $campaign
     */
    public static function testDeleteCampaign(Campaign $campaign): void
    {
        // [ Pre processing ] ==========================================================================================

        $campaignID = $campaign->id;

        // [ Example ] =================================================================================================

        $result = Campaign::find($campaignID)->delete();

        // [ Post processing ] =========================================================================================

        Checklists::checkResult($result);
    }
}