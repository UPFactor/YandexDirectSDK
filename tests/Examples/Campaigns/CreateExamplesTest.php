<?php

namespace YandexDirectSDKTest\Examples\Campaigns;

use PHPUnit\Framework\TestCase;
use UPTools\Arr;
use YandexDirectSDK\Collections\Campaigns;
use YandexDirectSDK\Models\Campaign;
use YandexDirectSDK\Models\CpmBannerCampaign;
use YandexDirectSDK\Models\CpmBannerCampaignNetworkStrategy;
use YandexDirectSDK\Models\CpmBannerCampaignSearchStrategy;
use YandexDirectSDK\Models\CpmBannerCampaignStrategy;
use YandexDirectSDK\Models\DynamicTextCampaign;
use YandexDirectSDK\Models\DynamicTextCampaignNetworkStrategy;
use YandexDirectSDK\Models\DynamicTextCampaignSearchStrategy;
use YandexDirectSDK\Models\DynamicTextCampaignStrategy;
use YandexDirectSDK\Models\MobileAppCampaign;
use YandexDirectSDK\Models\MobileAppCampaignNetworkStrategy;
use YandexDirectSDK\Models\MobileAppCampaignSearchStrategy;
use YandexDirectSDK\Models\MobileAppCampaignStrategy;
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
use YandexDirectSDK\Models\TextCampaign;
use YandexDirectSDK\Models\TextCampaignNetworkStrategy;
use YandexDirectSDK\Models\TextCampaignSearchStrategy;
use YandexDirectSDK\Models\TextCampaignStrategy;
use YandexDirectSDKTest\Helpers\Checklists;
use YandexDirectSDKTest\Helpers\Env;

class CreateExamplesTest extends TestCase
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
        Campaign::find(Arr::map(static::$campaigns, function(Campaign $campaign){
            return $campaign->id;
        }))->delete();

        static::$campaigns = [];
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Examples
     |
     |-------------------------------------------------------------------------------
    */

    /*
     | Make
     | -------------------------------------------------------------------------------
     */

    /**
     * @test
     * @return void
     */
    public static function makeTextCampaign_HighestPosition_MaximumCoverage():void
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

        $result = $campaign->create();

        // [ Post processing ]

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        $campaign->delete();

    }

    /**
     * @test
     * @return void
     */
    public static function makeTextCampaign_WbMaximumClicks_NetworkDefault():void
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

        $result = $campaign->create();

        // [ Post processing ]

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        $campaign->delete();
    }

    /**
     * @test
     * @return void
     */
    public static function makeTextCampaign_ServingOff_WbMaximumClicks():void
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

        $result = $campaign->create();

        // [ Post processing ]

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        $campaign->delete();
    }

    /*
     | TextCampaign
     | -------------------------------------------------------------------------------
     */

    /**
     * @test
     * @return Campaign
     */
    public static function createTextCampaign_HighestPosition_MaximumCoverage(): Campaign
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

        $result = $campaign->create();

        // [ Post processing ] 

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$campaigns['TextCampaign_HighestPosition_MaximumCoverage'] =  $campaign;
    }

    /**
     * @test
     * @return Campaign
     */
    public static function createTextCampaign_WbMaximumClicks_NetworkDefault(): Campaign
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

        $result = $campaign->create();

        // [ Post processing ] 

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$campaigns['TextCampaign_WbMaximumClicks_NetworkDefault'] = $campaign;
    }

    /**
     * @test
     * @return Campaign
     */
    public static function createTextCampaign_WbMaximumConversionRate_NetworkDefault(): Campaign
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

        $result = $campaign->create();

        // [ Post processing ] 

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$campaigns['TextCampaign_WbMaximumConversionRate_NetworkDefault'] = $campaign;
    }

    /**
     * @test
     * @return Campaign
     */
    public static function createTextCampaign_AverageCpc_NetworkDefault(): Campaign
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

        $result = $campaign->create();

        // [ Post processing ] 

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$campaigns['TextCampaign_AverageCpc_NetworkDefault'] = $campaign;
    }

    /**
     * @test
     * @return Campaign
     */
    public static function createTextCampaign_AverageCpa_NetworkDefault(): Campaign
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

        $result = $campaign->create();

        // [ Post processing ] 

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$campaigns['TextCampaign_AverageCpa_NetworkDefault'] = $campaign;
    }

    /**
     * @test
     * @return Campaign
     */
    public static function createTextCampaign_AverageRoi_NetworkDefault(): Campaign
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

        $result = $campaign->create();

        // [ Post processing ] 

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$campaigns['TextCampaign_AverageRoi_NetworkDefault'] = $campaign;
    }

    /**
     * @test
     * @return Campaign
     */
    public static function createTextCampaign_WeeklyClickPackage_NetworkDefault(): Campaign
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

        $result = $campaign->create();

        // [ Post processing ] 

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$campaigns['TextCampaign_WeeklyClickPackage_NetworkDefault'] = $campaign;
    }

    /**
     * @test
     * @return Campaign
     */
    public static function createTextCampaign_ServingOff_WbMaximumClicks(): Campaign
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

        $result = $campaign->create();

        // [ Post processing ] 

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$campaigns['TextCampaign_ServingOff_WbMaximumClicks'] = $campaign;
    }

    /*
     | DynamicTextCampaign
     | -------------------------------------------------------------------------------
     */

    /**
     * @test
     * @return Campaign
     */
    public static function createDynamicTextCampaign_HighestPosition_ServingOff(): Campaign
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

        $result = $campaign->create();

        // [ Post processing ] 

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$campaigns['DynamicTextCampaign_HighestPosition_ServingOff'] = $campaign;
    }

    /**
     * @test
     * @return Campaign
     */
    public static function createDynamicTextCampaign_WbMaximumClicks_ServingOff(): Campaign
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

        $result = $campaign->create();

        // [ Post processing ] 

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$campaigns['DynamicTextCampaign_WbMaximumClicks_ServingOff'] = $campaign;
    }

    /**
     * @test
     * @return Campaign
     */
    public static function createDynamicTextCampaign_WbMaximumConversionRate_ServingOff(): Campaign
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

        $result = $campaign->create();

        // [ Post processing ] 

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$campaigns['DynamicTextCampaign_WbMaximumConversionRate_ServingOff'] = $campaign;
    }

    /**
     * @test
     * @return Campaign
     */
    public static function createDynamicTextCampaign_AverageCpc_ServingOff(): Campaign
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

        $result = $campaign->create();

        // [ Post processing ] 

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$campaigns['DynamicTextCampaign_AverageCpc_ServingOff'] = $campaign;
    }

    /**
     * @test
     * @return Campaign
     */
    public static function createDynamicTextCampaign_AverageCpa_ServingOff(): Campaign
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

        $result = $campaign->create();

        // [ Post processing ] 

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$campaigns['DynamicTextCampaign_AverageCpa_ServingOff'] = $campaign;
    }

    /**
     * @test
     * @return Campaign
     */
    public static function createDynamicTextCampaign_AverageRoi_ServingOff(): Campaign
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

        $result = $campaign->create();

        // [ Post processing ] 

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$campaigns['DynamicTextCampaign_AverageRoi_ServingOff'] = $campaign;
    }

    /**
     * @test
     * @return Campaign
     */
    public static function createDynamicTextCampaign_WeeklyClickPackage_ServingOff(): Campaign
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

        $result = $campaign->create();

        // [ Post processing ] 

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$campaigns['DynamicTextCampaign_WeeklyClickPackage_ServingOff'] = $campaign;
    }

    /*
     | MobileAppCampaign
     | -------------------------------------------------------------------------------
     */

    /**
     * @test
     * @return Campaign
     */
    public static function createMobileAppCampaign_HighestPosition_NetworkDefault(): Campaign
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

        $result = $campaign->create();

        // [ Post processing ] 

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$campaigns['MobileAppCampaign_HighestPosition_NetworkDefault'] = $campaign;
    }

    /**
     * @test
     * @return Campaign
     */
    public static function createMobileAppCampaign_WbMaximumClicks_NetworkDefault(): Campaign
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

        $result = $campaign->create();

        // [ Post processing ] 

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$campaigns['MobileAppCampaign_WbMaximumClicks_NetworkDefault'] = $campaign;
    }

    /**
     * @test
     * @return Campaign
     */
    public static function createMobileAppCampaign_WbMaximumAppInstalls_NetworkDefault(): Campaign
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

        $result = $campaign->create();

        // [ Post processing ] 

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$campaigns['MobileAppCampaign_WbMaximumAppInstalls_NetworkDefault'] = $campaign;
    }

    /**
     * @test
     * @return Campaign
     */
    public static function createMobileAppCampaign_AverageCpc_NetworkDefault(): Campaign
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

        $result = $campaign->create();

        // [ Post processing ] 

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$campaigns['MobileAppCampaign_AverageCpc_NetworkDefault'] = $campaign;
    }

    /**
     * @test
     * @return Campaign
     */
    public static function createMobileAppCampaign_AverageCpi_NetworkDefault(): Campaign
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

        $result = $campaign->create();

        // [ Post processing ] 

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$campaigns['MobileAppCampaign_AverageCpi_NetworkDefault'] = $campaign;
    }

    /**
     * @test
     * @return Campaign
     */
    public static function createMobileAppCampaign_WeeklyClickPackage_NetworkDefault(): Campaign
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

        $result = $campaign->create();

        // [ Post processing ] 

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$campaigns['MobileAppCampaign_WeeklyClickPackage_NetworkDefault'] = $campaign;
    }

    /**
     * @test
     * @return Campaign
     */
    public static function createMobileAppCampaign_ServingOff_WbMaximumClicks(): Campaign
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

        $result = $campaign->create();

        // [ Post processing ] 

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$campaigns['MobileAppCampaign_ServingOff_WbMaximumClicks'] = $campaign;
    }

    /*
     | CpmBannerCampaign
     | -------------------------------------------------------------------------------
     */

    /**
     * @test
     * @return Campaign
     */
    public static function createCpmBannerCampaign_ServingOff_ManualCpm(): Campaign
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

        $result = $campaign->create();

        // [ Post processing ] 

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$campaigns['CpmBannerCampaign_ServingOff_ManualCpm'] = $campaign;
    }

    /**
     * @test
     * @return Campaign
     */
    public static function createCpmBannerCampaign_ServingOff_WbMaximumImpressions(): Campaign
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

        $result = $campaign->create();

        // [ Post processing ] 

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$campaigns['CpmBannerCampaign_ServingOff_WbMaximumImpressions'] = $campaign;
    }

    /**
     * @test
     * @return Campaign
     */
    public static function createCpmBannerCampaign_ServingOff_CpMaximumImpressions(): Campaign
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

        $result = $campaign->create();

        // [ Post processing ] 

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$campaigns['CpmBannerCampaign_ServingOff_CpMaximumImpressions'] = $campaign;
    }

    /**
     * @test
     * @return Campaign
     */
    public static function createCpmBannerCampaign_ServingOff_WbDecreasedPriceForRepeatedImpressions(): Campaign
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

        $result = $campaign->create();

        // [ Post processing ] 

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$campaigns['CpmBannerCampaign_ServingOff_WbDecreasedPriceForRepeatedImpressions'] = $campaign;
    }

    /**
     * @test
     * @return Campaign
     */
    public static function createCpmBannerCampaign_ServingOff_CpDecreasedPriceForRepeatedImpressions(): Campaign
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

        $result = $campaign->create();

        // [ Post processing ] 

        Checklists::checkResource($result, Campaigns::class, ['Id' => 'required|integer']);
        return static::$campaigns['CpmBannerCampaign_ServingOff_CpDecreasedPriceForRepeatedImpressions'] = $campaign;
    }
}