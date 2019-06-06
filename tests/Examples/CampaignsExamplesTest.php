<?php

namespace YandexDirectSDKTest\Examples;

use PHPUnit\Framework\TestCase;
use ReflectionException;
use YandexDirectSDK\Collections\AdGroups;
use YandexDirectSDK\Collections\Ads;
use YandexDirectSDK\Collections\AudienceTargets;
use YandexDirectSDK\Collections\BidModifiers;
use YandexDirectSDK\Collections\BidModifierToggles;
use YandexDirectSDK\Collections\Bids;
use YandexDirectSDK\Collections\BidsAuto;
use YandexDirectSDK\Collections\Campaigns;
use YandexDirectSDK\Collections\Keywords;
use YandexDirectSDK\Collections\Webpages;
use YandexDirectSDK\Components\Data;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\ModelCollectionException;
use YandexDirectSDK\Exceptions\RequestException;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Exceptions\ServiceException;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\BidAuto;
use YandexDirectSDK\Models\BidModifier;
use YandexDirectSDK\Models\Campaign;
use YandexDirectSDK\Models\DynamicTextCampaign;
use YandexDirectSDK\Models\DynamicTextCampaignNetworkStrategy;
use YandexDirectSDK\Models\DynamicTextCampaignSearchStrategy;
use YandexDirectSDK\Models\DynamicTextCampaignStrategy;
use YandexDirectSDK\Models\Keyword;
use YandexDirectSDK\Models\RegionalAdjustment;
use YandexDirectSDK\Models\StrategyMaximumClicks;
use YandexDirectSDK\Models\StrategyMaximumConversionRate;
use YandexDirectSDK\Models\StrategyNetworkDefault;
use YandexDirectSDK\Models\TextCampaign;
use YandexDirectSDK\Models\TextCampaignNetworkStrategy;
use YandexDirectSDK\Models\TextCampaignSearchStrategy;
use YandexDirectSDK\Models\TextCampaignStrategy;
use YandexDirectSDK\Session;
use YandexDirectSDKTest\Helpers\SessionTools;

/**
 * Class CampaignsExamplesTest
 * @package YandexDirectSDKTest\Examples
 */
class CampaignsExamplesTest extends TestCase
{
    /**
     * @var Session
     */
    public static $session;

    public static function setUpBeforeClass():void
    {
        self::$session = SessionTools::init();
    }

    public static function tearDownAfterClass():void
    {
        self::$session = null;
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Creating model and collection
     |
     |-------------------------------------------------------------------------------
    */

    public function testCreateCampaignModel_byArray(){
        $session = self::$session;

        /**
         * Campaign properties array.
         * @var array $campaignRaw
         */
        $campaignRaw = [
            'Name' => 'MyCampaign',
            'StartDate' => '2019-10-01',
            'EndDate' => '2019-10-10',
            'TextCampaign' => [
                'BiddingStrategy' => [
                    'Search' => [
                        'BiddingStrategyType' => 'WB_MAXIMUM_CLICKS',
                        'WbMaximumClicks' => [
                            'WeeklySpendLimit' => 300000000,
                            'BidCeiling' => 2000000
                        ]
                    ],
                    'Network' => [
                        'BiddingStrategyType' => 'NETWORK_DEFAULT',
                        'NetworkDefault' => [
                            'LimitPercent' => 20,
                            'BidPercent' => 10
                        ]
                    ]
                ]
            ],
            'NegativeKeywords' => [
                'Items' => ['negative','keywords']
            ]
        ];

        /**
         * Create campaign model.
         * @var Campaign $campaign
         */
        $campaign = Campaign::make($campaignRaw)->setSession($session);

        $this->assertInstanceOf(Campaign::class, $campaign);
        $this->assertEquals($campaignRaw, $campaign->toArray());
    }

    /**
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testCreateCampaignsCollection_byArray(){
        $session = self::$session;

        /**
         * Campaigns properties array.
         * @var array $campaignRaw
         */
        $campaignsRaw = [
            [
                'Name' => 'MyCampaign',
                'StartDate' => '2019-10-01',
                'EndDate' => '2019-10-10',
                'TextCampaign' => [
                    'BiddingStrategy' => [
                        'Search' => [
                            'BiddingStrategyType' => 'WB_MAXIMUM_CLICKS',
                            'WbMaximumClicks' => [
                                'WeeklySpendLimit' => 300000000,
                                'BidCeiling' => 2000000
                            ]
                        ],
                        'Network' => [
                            'BiddingStrategyType' => 'NETWORK_DEFAULT',
                            'NetworkDefault' => [
                                'LimitPercent' => 20,
                                'BidPercent' => 10
                            ]
                        ]
                    ]
                ],
                'NegativeKeywords' => [
                    'Items' => ['negative','keywords']
                ]
            ],
            [
                'Name' => 'MyCampaign2',
                'StartDate' => '2019-10-01',
                'EndDate' => '2019-10-10',
                'TextCampaign' => [
                    'BiddingStrategy' => [
                        'Search' => [
                            'BiddingStrategyType' => 'WB_MAXIMUM_CLICKS',
                            'WbMaximumClicks' => [
                                'WeeklySpendLimit' => 300000000,
                                'BidCeiling' => 2000000
                            ]
                        ],
                        'Network' => [
                            'BiddingStrategyType' => 'NETWORK_DEFAULT',
                            'NetworkDefault' => [
                                'LimitPercent' => 20,
                                'BidPercent' => 10
                            ]
                        ]
                    ]
                ],
                'NegativeKeywords' => [
                    'Items' => ['negative','keywords']
                ]
            ]
        ];

        /**
         * Create campaign collection.
         * @var Campaigns $campaigns
         */
        $campaigns = Campaigns::make()->insert($campaignsRaw)->setSession($session);

        $this->assertInstanceOf(Campaigns::class, $campaigns);
        $this->assertEquals($campaignsRaw, $campaigns->toArray());
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Add campaigns
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @return Campaigns
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testAddCampaigns_byService(){
        $session = self::$session;

        // Demo =====================================================================

        /**
         * Add a campaign to Yandex.Direct.
         * @var Result $result
         */
        $result = $session->getCampaignsService()->add(
            //Creating a campaign collection and adding a campaign model to it.
            Campaigns::make()->push(
                //Creating a campaign model and setting its properties.
                Campaign::make()
                    ->setName('MyTextCampaign')
                    ->setStartDate('2019-10-01')
                    ->setEndDate('2019-10-10')
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
                    )
                    ->setNegativeKeywords(['set','negative','keywords'])
            )
            //You can add more campaigns to the collection.
            //Just continue this chain using the "push" method.
        );

        /**
         * Convert result to array.
         * @var array $array
         */
        $array = $result->getData()->all();

        /**
         * Convert result to data object.
         * @var Data $data
         */
        $data = $result->getData();

        /**
         * Convert result to campaigns collection.
         * @var Campaigns $campaigns
         */
        $campaigns = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(Campaigns::class, $campaigns);

        return $campaigns;
    }

    /**
     * @return Campaigns
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testAddDynamicTextCampaigns_byService(){
        $session = self::$session;

        // Demo =====================================================================

        /**
         * Add DynamicTextCampaign to Yandex.Direct.
         * @var Result $result
         */
        $result = $session->getCampaignsService()->add(
            Campaigns::make()->push(
                Campaign::make()
                    ->setName('DynamicTextCampaign')
                    ->setStartDate('2019-10-01')
                    ->setDynamicTextCampaign(
                        DynamicTextCampaign::make()
                            ->setBiddingStrategy(
                                DynamicTextCampaignStrategy::make()
                                    ->setSearch(
                                        DynamicTextCampaignSearchStrategy::make()
                                            ->setBiddingStrategyType('WB_MAXIMUM_CLICKS')
                                            ->setWbMaximumClicks(
                                                StrategyMaximumClicks::make()
                                                    ->setWeeklySpendLimit(300000000)
                                            )
                                    )
                                    ->setNetwork(
                                        DynamicTextCampaignNetworkStrategy::make()
                                            ->setBiddingStrategyType('SERVING_OFF')
                                    )
                            )
                    )
            )
        );

        /**
         * Convert result to array.
         * @var array $array
         */
        $array = $result->getData()->all();

        /**
         * Convert result to data object.
         * @var Data $data
         */
        $data = $result->getData();

        /**
         * Convert result to campaigns collection.
         * @var Campaigns $campaigns
         */
        $campaigns = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(Campaigns::class, $campaigns);

        return $campaigns;
    }

    /**
     * @return Campaigns
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testAddConversionCampaigns_byService(){
        $session = self::$session;

        // Demo =====================================================================

        /**
         * Add a campaign to Yandex.Direct.
         * @var Result $result
         */
        $result = $session->getCampaignsService()->add(
            Campaigns::make()->push(
                Campaign::make()
                    ->setName('MyConversionCampaign')
                    ->setStartDate('2019-10-01')
                    ->setEndDate('2019-10-10')
                    ->setTextCampaign(
                        TextCampaign::make()
                            ->setBiddingStrategy(
                                TextCampaignStrategy::make()
                                    ->setSearch(
                                        TextCampaignSearchStrategy::make()
                                            ->setBiddingStrategyType('WB_MAXIMUM_CONVERSION_RATE')
                                            ->setWbMaximumConversionRate(
                                                StrategyMaximumConversionRate::make()
                                                    ->setWeeklySpendLimit(300000000)
                                                    ->setGoalId(123456789)
                                            )
                                    )
                                    ->setNetwork(
                                        TextCampaignNetworkStrategy::make()
                                            ->setBiddingStrategyType('NETWORK_DEFAULT')
                                            ->setNetworkDefault(StrategyNetworkDefault::make())
                                    )
                            )
                    )
                    ->setNegativeKeywords(['set','negative','keywords'])
            )
        );

        /**
         * Convert result to campaigns collection.
         * @var Campaigns $campaigns
         */
        $campaigns = $result->getResource();

        // End Demo =====================================================================

        $this->assertInstanceOf(Campaigns::class, $campaigns);

        return $campaigns;
    }

    /**
     * @depends testAddCampaigns_byService
     *
     * @return void
     */
    public function testAddCampaigns_byModel(){
        $session = self::$session;

        // Demo =====================================================================

        /**
         * Create a campaign model.
         * @var Campaign $campaign
         */
        $campaign = Campaign::make()
            ->setSession($session)
            ->setName('MyTextCampaign')
            ->setStartDate('2019-10-01')
            ->setEndDate('2019-10-10')
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
            )
            ->setNegativeKeywords(['set','negative','keywords']);

        /**
         * Add a campaign to Yandex.Direct.
         * @var Result $result
         */
        $result = $campaign->add();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Campaign::class, $campaign);
        $this->assertNotNull($campaign->id);

        $result = $campaign->delete();

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
    }

    /**
     * @depends testAddCampaigns_byService
     *
     * @return void
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testAddCampaigns_byCollection(){
        $session = self::$session;

        // Demo =====================================================================

        /**
         * Create an empty collection and connect session.
         * @var Session $session
         * @var Campaigns $campaigns.
         */
        $campaigns = Campaigns::make()->setSession($session);

        /**
         * Add campaigns to the collection.
         */
        $campaigns->push(
            Campaign::make()
                ->setName('MyTextCampaign')
                ->setStartDate('2019-10-01')
                ->setEndDate('2019-10-10')
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
                )
                ->setNegativeKeywords(['set','negative','keywords'])
        );

        $campaigns->push(
            Campaign::make()
                ->setName('MyDynamicTextCampaign')
                ->setStartDate('2019-10-01')
                ->setEndDate('2019-10-10')
                ->setDynamicTextCampaign(
                    DynamicTextCampaign::make()
                        ->setBiddingStrategy(
                            DynamicTextCampaignStrategy::make()
                                ->setSearch(
                                    DynamicTextCampaignSearchStrategy::make()
                                        ->setBiddingStrategyType('WB_MAXIMUM_CLICKS')
                                        ->setWbMaximumClicks(
                                            StrategyMaximumClicks::make()
                                                ->setWeeklySpendLimit(300000000)
                                                ->setBidCeiling(3000000)
                                        )
                                )
                                ->setNetwork(
                                    DynamicTextCampaignNetworkStrategy::make()
                                        ->setBiddingStrategyType('SERVING_OFF')
                                )
                        )
                )
                ->setNegativeKeywords(['set','negative','keywords'])
        );

        /**
         * Add campaigns to Yandex.Direct.
         * @var Result $result
         */
        $result = $campaigns->add();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Campaigns::class, $campaigns);
        $this->assertNotNull($campaigns->first()->{'id'});
        $this->assertNotNull($campaigns->last()->{'id'});

        $result = $campaigns->delete();

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
    }

    /**
     * @depends testDeleteCampaigns
     *
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws RequestException
     */
    public function testAddCampaigns_byArray(){
        $session = self::$session;

        // Demo =====================================================================

        /**
         * Add a campaign to Yandex.Direct.
         * @var Result $result
         */
        $result = $session->getCampaignsService()->call('add', [
            'Campaigns' => [
                [
                    'Name' => 'MyCampaign',
                    'StartDate' => '2019-10-01',
                    'EndDate' => '2019-10-10',
                    'TextCampaign' => [
                        'BiddingStrategy' => [
                            'Search' => [
                                'BiddingStrategyType' => 'WB_MAXIMUM_CLICKS',
                                'WbMaximumClicks' => [
                                    'WeeklySpendLimit' => 300000000,
                                    'BidCeiling' => 2000000
                                ]
                            ],
                            'Network' => [
                                'BiddingStrategyType' => 'NETWORK_DEFAULT',
                                'NetworkDefault' => [
                                    'LimitPercent' => 20,
                                    'BidPercent' => 10
                                ]
                            ]
                        ]
                    ],
                    'NegativeKeywords' => [
                        'Items' => ['negative','keywords']
                    ]
                ]
            ]
        ]);

        /**
         * Convert result to array.
         * @var array $array
         */
        $array = $result->getData()->all();

        /**
         * Convert result to data object.
         * @var Data $data
         */
        $data = $result->getData();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);

        /**
         * Delete created campaigns
         */
        $data->get('AddResults')->each(function($campaign) use ($session){
            $session->getCampaignsService()->delete($campaign['Id']);
        });
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Get campaigns
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddCampaigns_byService
     *
     * @return Campaigns
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testGetCampaigns_byService(){
        $session = self::$session;

        /**
         * Getting a list of result.
         * @var Result $result
         */
        $result = $session->getCampaignsService()->query()
            ->select(
                'Id',
                'Name',
                'State',
                'TextCampaign.BiddingStrategy',
                'TextCampaign.Settings'
            )
            ->whereIn('States', ['SUSPENDED', 'OFF', 'ARCHIVED'])
            ->limit(10)
            ->offset(5)
            ->get();

        /**
         * Convert result to array.
         * @var array $array
         */
        $array = $result->getData()->all();

        /**
         * Convert result to data object.
         * @var Data $data
         */
        $data = $result->getData();

        /**
         * Convert result to campaigns collection.
         * @var Campaigns $campaigns
         */
        $campaigns = $result->getResource();

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(Campaigns::class, $campaigns);

        return $campaigns;
    }

    /**
     * @depends testAddCampaigns_byService
     *
     * @return Campaigns
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testGetCampaigns_byModel(){
        $session = self::$session;

        /**
         * Getting a list of result.
         * @var Result $result
         */
        $result = Campaign::make()->setSession($session)->query()
            ->select('Id','Name','State')
            ->whereIn('States', ['SUSPENDED', 'OFF', 'ARCHIVED'])
            ->limit(10)
            ->offset(5)
            ->get();

        /**
         * Convert result to array.
         * @var array $array
         */
        $array = $result->getData()->all();

        /**
         * Convert result to data object.
         * @var Data $data
         */
        $data = $result->getData();

        /**
         * Convert result to campaigns collection.
         * @var Campaigns $campaigns
         */
        $campaigns = $result->getResource();

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(Campaigns::class, $campaigns);

        return $campaigns;
    }

    /**
     * @depends testAddCampaigns_byService
     *
     * @return Campaigns
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws ModelCollectionException
     */
    public function testGetCampaigns_byCollection(){
        $session = self::$session;

        /**
         * Getting a list of result.
         * @var Result $result
         */
        $result = Campaigns::make()->setSession($session)->query()
            ->select('Id','Name','State')
            ->whereIn('States', ['SUSPENDED', 'OFF', 'ARCHIVED'])
            ->limit(10)
            ->offset(5)
            ->get();

        /**
         * Convert result to array.
         * @var array $array
         */
        $array = $result->getData()->all();

        /**
         * Convert result to data object.
         * @var Data $data
         */
        $data = $result->getData();

        /**
         * Convert result to campaigns collection.
         * @var Campaigns $campaigns
         */
        $campaigns = $result->getResource();

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(Campaigns::class, $campaigns);

        return $campaigns;
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Actions of campaign
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testGetCampaigns_byService
     *
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testArchiveCampaigns(){
        $session = $result = self::$session;

        /**
         * Getting a list of result.
         * @var Result $result
         */
        $result = $session->getCampaignsService()->query()
            ->select('Id','Name','State')
            ->whereIn('States', ['SUSPENDED'])
            ->get();

        /**
         * Convert result to campaigns collection.
         * @var Campaigns $campaigns
         */
        $campaigns = $result->getResource();

        /**
         * Check for non-empty result and archiving received result.
         */
        if ($campaigns->isNotEmpty()){
            $campaigns->archive();
        }

        sleep(10);

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Campaigns::class, $campaigns);
    }

    /**
     * @depends testArchiveCampaigns
     *
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testUnarchiveCampaigns(){
        $session = self::$session;

        /**
         * Getting a list of result.
         * @var Result $result
         */
        $result = $session->getCampaignsService()->query()
            ->select('Id','Name','State')
            ->whereIn('States', ['ARCHIVED'])
            ->get();

        /**
         * Convert result to campaigns collection.
         * @var Campaigns $campaigns
         */
        $campaigns = $result->getResource();

        /**
         * Check for non-empty result and unarchive received result.
         */
        if ($campaigns->isNotEmpty()){
            $campaigns->unarchive();
        }

        sleep(10);

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Campaigns::class, $campaigns);
    }

    /**
     * @depends testGetCampaigns_byService
     *
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testSuspendCampaigns(){
        $session = self::$session;

        /**
         * Getting a list of result.
         * @var Result $result
         */
        $result = $session->getCampaignsService()->query()
            ->select('Id','Name','State')
            ->whereIn('States', ['OFF','ON'])
            ->get();

        /**
         * Convert result to campaigns collection.
         * @var Campaigns $campaigns
         */
        $campaigns = $result->getResource();

        /**
         * Check for non-empty result and suspend received result.
         */
        if ($campaigns->isNotEmpty()){
            $campaigns->suspend();
        }

        sleep(10);

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Campaigns::class, $campaigns);
    }

    /**
     * @depends testSuspendCampaigns
     *
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testResumeCampaigns(){
        $session = self::$session;

        /**
         * Getting a list of result.
         * @var Result $result
         */
        $result = $session->getCampaignsService()->query()
            ->select('Id','Name','State')
            ->whereIn('States', ['SUSPENDED'])
            ->get();

        /**
         * Convert result to campaigns collection.
         * @var Campaigns $campaigns
         */
        $campaigns = $result->getResource();

        /**
         * Check for non-empty result and resume received result.
         */
        if ($campaigns->isNotEmpty()){
            $campaigns->resume();
        }

        sleep(10);

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Campaigns::class, $campaigns);
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Related objects
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddCampaigns_byService
     *
     * @param $campaigns
     * @return AdGroups
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ServiceException
     */
    public function testAddRelatedAdGroup_byService(Campaigns $campaigns){
        $session = self::$session;
        $campaignIds = $campaigns->extract('id');

        // Demo =====================================================================

        /**
         * Create AdGroup model.
         * @var AdGroup $adGroup
         */
        $adGroup = AdGroup::make()
            ->setName('MyAdGroup')
            ->setRegionIds([225]);

        /**
         * Create a new AdGroup for campaigns with id [$campaignIds].
         * @var Result $result
         * @var array $campaignIds
         */
        $result = $session
            ->getCampaignsService()
            ->addRelatedAdGroups($campaignIds, $adGroup);

        /**
         * Convert result to adGroups collection.
         * @var AdGroups $adGroups
         */
        $adGroups = $result->getResource();

        // End Demo =====================================================================

        $this->assertIsArray($campaignIds);
        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(AdGroups::class, $adGroups);

        return $adGroups;
    }

    /**
     * @depends testAddCampaigns_byService
     *
     * @param $campaigns
     * @return AdGroups
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testAddRelatedAdGroup_byModel(Campaigns $campaigns){
        $campaign = $campaigns->first();

        // Demo =====================================================================

        /**
         * Create a new AdGroup for campaign [$campaign].
         * @var Result $result
         * @var Campaign $campaign
         */
        $result = $campaign->addRelatedAdGroups(
            AdGroup::make()
                ->setName('MyAdGroup')
                ->setRegionIds([225])
        );

        /**
         * Convert result to adGroups collection.
         * @var AdGroups $adGroups
         */
        $adGroups = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(AdGroups::class, $adGroups);

        return $adGroups;
    }

    /**
     * @depends testAddCampaigns_byService
     *
     * @param $campaigns
     * @return AdGroups
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testAddRelatedAdGroup_byCollection(Campaigns $campaigns){

        // Demo =====================================================================

        /**
         * Create a AdGroup for each campaign in the collection [$campaigns].
         * @var Result $result
         * @var Campaigns $campaigns
         */
        $result = $campaigns->addRelatedAdGroups(
            AdGroup::make()
                ->setName('MyAdGroup')
                ->setRegionIds([225])
        );

        /**
         * Convert result to adGroups collection.
         * @var AdGroups $adGroups
         */
        $adGroups = $result->getResource();

        // End Demo =====================================================================

        /**
         * Adding keywords to ad group.
         */
        $adGroups->addRelatedKeywords(
            Keywords::make(
                Keyword::make()->setKeyword('yandex api'),
                Keyword::make()->setKeyword('yandex direct')
            )
        );

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(AdGroups::class, $adGroups);

        return $adGroups;
    }

    /**
     * @depends testAddCampaigns_byService
     *
     * @param $campaigns
     * @return AdGroups
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testAddRelatedAdGroups_byCollection(Campaigns $campaigns){

        // Demo =====================================================================

        /**
         * Creating AdGroups for each campaign in the collection [$campaigns].
         * @var Result $result
         * @var Campaigns $campaigns
         */
        $result = $campaigns->addRelatedAdGroups(
            AdGroups::make(
                AdGroup::make()
                    ->setName('MyAdGroup_1')
                    ->setRegionIds([225]),
                AdGroup::make()
                    ->setName('MyAdGroup_2')
                    ->setRegionIds([225])
            )
        );

        /**
         * Convert result to adGroups collection.
         * @var AdGroups $adGroups
         */
        $adGroups = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(AdGroups::class, $adGroups);

        return $adGroups;
    }

    /**
     * @depends testAddCampaigns_byService
     * @depends testAddRelatedAdGroup_byService
     *
     * @param $campaigns
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testGetRelatedAdGroups_byService(Campaigns $campaigns){
        $session = self::$session;
        $campaignIds = $campaigns->extract('id');

        // Demo =====================================================================

        /**
         * Get AdGroups by campaign ids [$campaignIds]
         * @var Result $result
         * @var array $campaignIds
         */
        $result = $session
            ->getCampaignsService()
            ->getRelatedAdGroups($campaignIds,['Id','Name']);

        /**
         * Convert result to adGroups collection.
         * @var AdGroups $adGroups
         */
        $adGroups = $result->getResource();

        // End Demo =================================================================

        $this->assertIsArray($campaignIds);
        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(AdGroups::class, $adGroups);
    }

    /**
     * @depends testAddCampaigns_byService
     * @depends testAddRelatedAdGroup_byModel
     *
     * @param $campaigns
     */
    public function testGetRelatedAdGroups_byModel(Campaigns $campaigns){
        $campaign = $campaigns->first();

        // Demo =====================================================================

        /**
         * Get AdGroups by campaign model [$campaign]
         * @var Result $result
         * @var Campaign $campaign
         */
        $result = $campaign->getRelatedAdGroups(['Id','Name']);

        /**
         * Convert result to adGroups collection.
         * @var AdGroups $adGroups
         */
        $adGroups = $result->getResource();

        // End Demo =================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(AdGroups::class, $adGroups);
    }

    /**
     * @depends testAddCampaigns_byService
     * @depends testAddRelatedAdGroup_byCollection
     * @depends testAddRelatedAdGroups_byCollection
     *
     * @param $campaigns
     */
    public function testGetRelatedAdGroups_byCollection(Campaigns $campaigns){

        // Demo =====================================================================

        /**
         * Get AdGroups by campaign collection [$campaigns]
         * @var Result $result
         * @var Campaigns $campaigns
         */
        $result = $campaigns->getRelatedAdGroups(['Id','Name']);

        /**
         * Convert result to adGroups collection.
         * @var AdGroups $adGroups
         */
        $adGroups = $result->getResource();

        // End Demo =================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(AdGroups::class, $adGroups);
    }

    /**
     * @depends testAddCampaigns_byService
     *
     * @param Campaigns $campaigns
     * @return BidModifiers
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ServiceException
     * @throws ReflectionException
     */
    public function testAddRelatedBidModifiers_byService(Campaigns $campaigns){
        $session = self::$session;
        $campaignIds = $campaigns->extract('id');

        // Demo =====================================================================

        /**
         * Create BidModifier Model.
         * @var BidModifier $bidModifier
         */
        $bidModifier = BidModifiers::make(
            BidModifier::make()
                ->setRegionalAdjustment(
                    RegionalAdjustment::make()
                        ->setRegionId(225)
                        ->setBidModifier(50)
                ),
            BidModifier::make()
                ->setRegionalAdjustment(
                    RegionalAdjustment::make()
                        ->setRegionId(1)
                        ->setBidModifier(50)
                )
        );

        /**
         * Sets a new bid modifier for campaigns with ids [$campaignIds].
         * @var Result $result
         * @var array $campaignIds
         */
        $result = $session
            ->getCampaignsService()
            ->addRelatedBidModifiers($campaignIds, $bidModifier);

        /**
         * Convert result to BidModifiers collection.
         * @var BidModifiers $bidModifiers
         */
        $bidModifiers = $result->getResource();

        // End Demo =================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(BidModifiers::class, $bidModifiers);

        return $bidModifiers;
    }

    /**
     * @depends testAddCampaigns_byService
     *
     * @param $campaigns
     * @return BidModifiers
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testAddRelatedBidModifiers_byModel(Campaigns $campaigns){
        $campaign = $campaigns->first();

        // Demo =====================================================================

        /**
         * Sets a new bid modifier for campaign model [$campaign].
         * @var Campaign $campaign
         * @var Result $result
         */
        $result = $campaign->addRelatedBidModifiers(
            BidModifiers::make(
                BidModifier::make()
                    ->setRegionalAdjustment(
                        RegionalAdjustment::make()
                            ->setRegionId(2)
                            ->setBidModifier(50)
                    ),
                BidModifier::make()
                    ->setRegionalAdjustment(
                        RegionalAdjustment::make()
                            ->setRegionId(3)
                            ->setBidModifier(50)
                    )
            )
        );

        /**
         * Convert result to BidModifiers collection.
         * @var BidModifiers $bidModifiers
         */
        $bidModifiers = $result->getResource();

        // End Demo =================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(BidModifiers::class, $bidModifiers);

        return $bidModifiers;
    }

    /**
     * @depends testAddCampaigns_byService
     *
     * @param $campaigns
     * @return BidModifiers
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testAddRelatedBidModifiers_byCollection(Campaigns $campaigns){

        // Demo =====================================================================

        /**
         * Sets a new bid modifier for campaign collection [$campaigns].
         * @var Campaigns $campaigns
         * @var Result $result
         */
        $result = $campaigns->addRelatedBidModifiers(
            BidModifiers::make(
                BidModifier::make()
                    ->setRegionalAdjustment(
                        RegionalAdjustment::make()
                            ->setRegionId(4)
                            ->setBidModifier(50)
                    ),
                BidModifier::make()
                    ->setRegionalAdjustment(
                        RegionalAdjustment::make()
                            ->setRegionId(5)
                            ->setBidModifier(50)
                    )
            )
        );

        /**
         * Convert result to BidModifiers collection.
         * @var BidModifiers $bidModifiers
         */
        $bidModifiers = $result->getResource();

        // End Demo =================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(BidModifiers::class, $bidModifiers);

        return $bidModifiers;
    }

    /**
     * @depends testAddCampaigns_byService
     * @depends testAddRelatedBidModifiers_byCollection
     *
     * @param Campaigns $campaigns
     * @return BidModifiers
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testGetRelatedBidModifiers_byService(Campaigns $campaigns){
        $session = self::$session;
        $campaignIds = $campaigns->extract('id');

        // Demo =====================================================================

        /**
         * Get BidModifiers by campaign ids [$campaignIds]
         * @var Result $result
         * @var array $campaignIds
         */
        $result = $session
            ->getCampaignsService()
            ->getRelatedBidModifiers($campaignIds, ['Id','CampaignId','AdGroupId']);

        /**
         * Convert result to BidModifiers collection.
         * @var BidModifiers $bidModifiers
         */
        $bidModifiers = $result->getResource();

        // End Demo =====================================================================

        $this->assertIsArray($campaignIds);
        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(BidModifiers::class, $bidModifiers);

        return $bidModifiers;
    }

    /**
     * @depends testAddCampaigns_byService
     * @depends testAddRelatedBidModifiers_byCollection
     *
     * @param $campaigns
     * @return BidModifiers
     */
    public function testGetRelatedBidModifiers_byModel(Campaigns $campaigns){
        $campaign = $campaigns->first();

        // Demo =====================================================================

        /**
         * Get BidModifiers by campaign model [$campaign]
         * @var Result $result
         * @var Campaign $campaign
         */
        $result = $campaign->getRelatedBidModifiers(['Id','CampaignId','AdGroupId']);

        /**
         * Convert result to BidModifiers collection.
         * @var BidModifiers $bidModifiers
         */
        $bidModifiers = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(BidModifiers::class, $bidModifiers);

        return $bidModifiers;
    }

    /**
     * @depends testAddCampaigns_byService
     * @depends testAddRelatedBidModifiers_byCollection
     *
     * @param $campaigns
     * @return BidModifiers
     */
    public function testGetRelatedBidModifiers_byCollection(Campaigns $campaigns){

        // Demo =====================================================================

        /**
         * Get BidModifiers by campaign collection [$campaigns]
         * @var Result $result
         * @var Campaigns $campaigns
         */
        $result = $campaigns->getRelatedBidModifiers(['Id','CampaignId','AdGroupId']);

        /**
         * Convert result to BidModifiers collection.
         * @var BidModifiers $bidModifiers
         */
        $bidModifiers = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(BidModifiers::class, $bidModifiers);

        return $bidModifiers;
    }

    /**
     * @depends testAddCampaigns_byService
     * @depends testAddRelatedBidModifiers_byCollection
     *
     * @param Campaigns $campaigns
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ModelCollectionException
     */
    public function testDisableBidModifiers_byService(Campaigns $campaigns){
        $session = self::$session;
        $campaignIds = $campaigns->extract('id');

        // Demo =====================================================================

        /**
         * Turn off the set of adjustments for campaigns with ids [$campaignIds].
         * @var Result $result
         * @var Campaign $campaign
         */
        $result = $session
            ->getCampaignsService()
            ->disableBidModifiers($campaignIds, 'REGIONAL_ADJUSTMENT');

        /**
         * Convert result to BidModifierToggles collection.
         * @var BidModifierToggles $bidModifierToggles
         */
        $bidModifierToggles = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(BidModifierToggles::class, $bidModifierToggles);
    }

    /**
     * @depends testAddCampaigns_byService
     * @depends testAddRelatedBidModifiers_byCollection
     *
     * @param $campaigns
     */
    public function testDisableBidModifiers_byModel(Campaigns $campaigns){
        $campaign = $campaigns->first();

        // Demo =====================================================================

        /**
         * Turn off the set of adjustments for campaign model [$campaign].
         * @var Result $result
         * @var Campaign $campaign
         */
        $result = $campaign->disableBidModifiers('REGIONAL_ADJUSTMENT');

        /**
         * Convert result to BidModifierToggles collection.
         * @var BidModifierToggles $bidModifierToggles
         */
        $bidModifierToggles = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(BidModifierToggles::class, $bidModifierToggles);
    }

    /**
     * @depends testAddCampaigns_byService
     * @depends testAddRelatedBidModifiers_byCollection
     *
     * @param $campaigns
     */
    public function testDisableBidModifiers_byCollection(Campaigns $campaigns){

        // Demo =====================================================================

        /**
         * Turn off the set of adjustments for all campaigns in the collection [$campaigns].
         * @var Result $result
         * @var Campaigns $campaigns
         */
        $result = $campaigns->disableBidModifiers('REGIONAL_ADJUSTMENT');

        /**
         * Convert result to BidModifierToggles collection.
         * @var BidModifierToggles $bidModifierToggles
         */
        $bidModifierToggles = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(BidModifierToggles::class, $bidModifierToggles);
    }

    /**
     * @depends testAddCampaigns_byService
     * @depends testAddRelatedBidModifiers_byCollection
     * @depends testDisableBidModifiers_byService
     *
     * @param Campaigns $campaigns
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ModelCollectionException
     */
    public function testEnableBidModifiers_byService(Campaigns $campaigns){
        $session = self::$session;
        $campaignIds = $campaigns->extract('id');

        // Demo =====================================================================

        /**
         * Turn on the set of adjustments for campaigns with ids [$campaignIds].
         * @var Result $result
         * @var Campaign $campaign
         */
        $result = $session
            ->getCampaignsService()
            ->enableBidModifiers($campaignIds, 'REGIONAL_ADJUSTMENT');

        /**
         * Convert result to BidModifierToggles collection.
         * @var BidModifierToggles $bidModifierToggles
         */
        $bidModifierToggles = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(BidModifierToggles::class, $bidModifierToggles);
    }

    /**
     * @depends testAddCampaigns_byService
     * @depends testAddRelatedBidModifiers_byCollection
     * @depends testDisableBidModifiers_byModel
     *
     * @param $campaigns
     */
    public function testEnableBidModifiers_byModel(Campaigns $campaigns){
        $campaign = $campaigns->first();

        // Demo =====================================================================

        /**
         * Turn on the set of adjustments for campaign model [$campaign].
         * @var Result $result
         * @var Campaign $campaign
         */
        $result = $campaign->enableBidModifiers('REGIONAL_ADJUSTMENT');

        /**
         * Convert result to BidModifierToggles collection.
         * @var BidModifierToggles $bidModifierToggles
         */
        $bidModifierToggles = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(BidModifierToggles::class, $bidModifierToggles);
    }

    /**
     * @depends testAddCampaigns_byService
     * @depends testAddRelatedBidModifiers_byCollection
     * @depends testDisableBidModifiers_byCollection
     *
     * @param $campaigns
     */
    public function testEnableBidModifiers_byCollection(Campaigns $campaigns){

        // Demo =====================================================================

        /**
         * Turn on the set of adjustments for all campaigns in the collection [$campaigns].
         * @var Result $result
         * @var Campaigns $campaigns
         */
        $result = $campaigns->enableBidModifiers('REGIONAL_ADJUSTMENT');

        /**
         * Convert result to BidModifierToggles collection.
         * @var BidModifierToggles $bidModifierToggles
         */
        $bidModifierToggles = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(BidModifierToggles::class, $bidModifierToggles);
    }

    /**
     * @depends testAddCampaigns_byService
     * @depends testAddRelatedAdGroups_byCollection
     *
     * @param $campaigns
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testGetRelatedAds_byService(Campaigns $campaigns){
        $session = self::$session;
        $campaignIds = $campaigns->extract('id');

        // Demo =====================================================================

        /**
         * Get Ads by campaign ids [$campaignIds]
         * @var Result $result
         * @var array $campaignIds
         */
        $result = $session
            ->getCampaignsService()
            ->getRelatedAds($campaignIds, ['Id','TextAd.Title']);

        /**
         * Convert result to Ads collection.
         * @var Ads $ads
         */
        $ads = $result->getResource();

        // End Demo =====================================================================

        $this->assertIsArray($campaignIds);
        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Ads::class, $ads);
    }

    /**
     * @depends testAddCampaigns_byService
     * @depends testAddRelatedAdGroups_byCollection
     *
     * @param $campaigns
     */
    public function testGetRelatedAds_byModel(Campaigns $campaigns){
        $campaign = $campaigns->first();

        // Demo =====================================================================

        /**
         * Get Ads by campaign model [$campaign]
         * @var Result $result
         * @var Campaign $campaign
         */
        $result = $campaign->getRelatedAds(['Id','TextAd.Title']);

        /**
         * Convert result to Ads collection.
         * @var Ads $ads
         */
        $ads = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Ads::class, $ads);
    }

    /**
     * @depends testAddCampaigns_byService
     * @depends testAddRelatedAdGroups_byCollection
     *
     * @param $campaigns
     */
    public function testGetRelatedAds_byCollection(Campaigns $campaigns){

        // Demo =====================================================================

        /**
         * Get Ads by campaign collection [$campaigns]
         * @var Result $result
         * @var Campaigns $campaigns
         */
        $result = $campaigns->getRelatedAds(['Id','TextAd.Title']);

        /**
         * Convert result to Ads collection.
         * @var Ads $ads
         */
        $ads = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Ads::class, $ads);
    }

    /**
     * @depends testAddCampaigns_byService
     * @depends testAddRelatedAdGroups_byCollection
     *
     * @param Campaigns $campaigns
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testGetRelatedAudienceTargets_byService(Campaigns $campaigns){
        $session = self::$session;
        $campaignIds = $campaigns->extract('id');

        // Demo =====================================================================

        /**
         * Get AudienceTargets by campaign ids [$campaignIds]
         * @var Result $result
         * @var array $campaignIds
         */
        $result = $session
            ->getCampaignsService()
            ->getRelatedAudienceTargets($campaignIds, ['Id','AdGroupId','CampaignId']);

        /**
         * Convert result to AudienceTargets collection.
         * @var AudienceTargets $audienceTargets
         */
        $audienceTargets = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(AudienceTargets::class, $audienceTargets);
    }

    /**
     * @depends testAddCampaigns_byService
     * @depends testAddRelatedAdGroups_byCollection
     *
     * @param $campaigns
     */
    public function testGetRelatedAudienceTargets_byModel(Campaigns $campaigns){
        $campaign = $campaigns->first();

        // Demo =====================================================================

        /**
         * Get AudienceTargets by campaign model [$campaign]
         * @var Result $result
         * @var Campaign $campaign
         */
        $result = $campaign->getRelatedAudienceTargets(['Id','AdGroupId','CampaignId']);

        /**
         * Convert result to AudienceTargets collection.
         * @var AudienceTargets $audienceTargets
         */
        $audienceTargets = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(AudienceTargets::class, $audienceTargets);
    }

    /**
     * @depends testAddCampaigns_byService
     * @depends testAddRelatedAdGroups_byCollection
     *
     * @param $campaigns
     */
    public function testGetRelatedAudienceTargets_byCollection(Campaigns $campaigns){

        // Demo =====================================================================

        /**
         * Get AudienceTargets for all campaigns in the collection [$campaigns]
         * @var Result $result
         * @var Campaigns $campaigns
         */
        $result = $campaigns->getRelatedAudienceTargets(['Id','AdGroupId','CampaignId']);

        /**
         * Convert result to AudienceTargets collection.
         * @var AudienceTargets $audienceTargets
         */
        $audienceTargets = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(AudienceTargets::class, $audienceTargets);
    }

    /**
     * @depends testAddCampaigns_byService
     * @depends testAddRelatedAdGroup_byCollection
     *
     * @param Campaigns $campaigns
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testGetRelatedBids_byService(Campaigns $campaigns){
        $session = self::$session;
        $campaignIds = $campaigns->extract('id');

        // Demo =====================================================================

        /**
         * Get Bids by campaign ids [$campaignIds]
         * @var Result $result
         * @var array $campaignIds
         */
        $result = $session
            ->getCampaignsService()
            ->getRelatedBids($campaignIds, ['Bid','AdGroupId','CampaignId']);

        /**
         * Convert result to Bids collection.
         * @var Bids $bids
         */
        $bids = $result->getResource();

        // End Demo =====================================================================

        $this->assertIsArray($campaignIds);
        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Bids::class, $bids);
    }

    /**
     * @depends testAddCampaigns_byService
     * @depends testAddRelatedAdGroup_byCollection
     *
     * @param $campaigns
     */
    public function testGetRelatedBids_byModel(Campaigns $campaigns){
        $campaign = $campaigns->first();

        // Demo =====================================================================

        /**
         * Get Bids by campaign model [$campaign]
         * @var Result $result
         * @var Campaign $campaign
         */
        $result = $campaign->getRelatedBids(['Bid','AdGroupId','CampaignId']);

        /**
         * Convert result to Bids collection.
         * @var Bids $bids
         */
        $bids = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Bids::class, $bids);
    }

    /**
     * @depends testAddCampaigns_byService
     * @depends testAddRelatedAdGroup_byCollection
     *
     * @param $campaigns
     */
    public function testGetRelatedBids_byCollection(Campaigns $campaigns){

        // Demo =====================================================================

        /**
         * Get Bids for all campaigns in the collection [$campaigns]
         * @var Result $result
         * @var Campaigns $campaigns
         */
        $result = $campaigns->getRelatedBids(['Bid','AdGroupId','CampaignId']);

        /**
         * Convert result to Bids collection.
         * @var Bids $bids
         */
        $bids = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Bids::class, $bids);
    }

    /**
     * @depends testAddCampaigns_byService
     * @depends testAddRelatedAdGroup_byCollection
     *
     * @param Campaigns $campaigns
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function testSetRelatedBids_byService(Campaigns $campaigns){
        $session = self::$session;
        $campaignIds = $campaigns->extract('id');

        // Demo =====================================================================

        /**
         * Sets the bids for the key phrases of each campaign
         * with ids. [$campaignIds]
         *
         * @var Result $result
         * @var array $campaignIds
         */
        $result = $session
            ->getCampaignsService()
            ->setRelatedBids($campaignIds, 30000000, 10000000);

        /**
         * Convert result to Bids collection.
         * @var Bids $bids
         */
        $bids = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Bids::class, $bids);
    }

    /**
     * @depends testAddCampaigns_byService
     * @depends testAddRelatedAdGroup_byCollection
     *
     * @param $campaigns
     */
    public function testSetRelatedBids_byModel(Campaigns $campaigns){
        $campaign = $campaigns->first();

        // Demo =====================================================================

        /**
         * Sets the bids for the campaign model. [$campaign]
         *
         * @var Result $result
         * @var Campaign $campaign
         */
        $result = $campaign->setRelatedBids(30000000);

        /**
         * Convert result to Bids collection.
         *
         * @var Bids $bids
         */
        $bids = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Bids::class, $bids);
    }

    /**
     * @depends testAddCampaigns_byService
     * @depends testAddRelatedAdGroup_byCollection
     *
     * @param $campaigns
     */
    public function testSetRelatedBids_byCollection(Campaigns $campaigns){

        // Demo =====================================================================

        /**
         * Sets the bids for the key phrases of each campaign
         * in the collection. [$campaigns]
         *
         * @var Result $result
         * @var Campaigns $campaigns
         */
        $result = $campaigns->setRelatedBids(30000000, 10000000);

        /**
         * Convert result to Bids collection.
         * @var Bids $bids
         */
        $bids = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Bids::class, $bids);
    }

    /**
     * @depends testAddCampaigns_byService
     * @depends testAddRelatedAdGroup_byCollection
     *
     * @param Campaigns $campaigns
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function testSetRelatedContextBids_byService(Campaigns $campaigns){
        $session = self::$session;
        $campaignIds = $campaigns->extract('id');

        // Demo =====================================================================

        /**
         * Sets the context bids for the key phrases of each campaign
         * with ids. [$campaignIds]
         *
         * @var Result $result
         * @var array $campaignIds
         */
        $result = $session
            ->getCampaignsService()
            ->setRelatedContextBids($campaignIds, 10000000);

        /**
         * Convert result to Bids collection.
         * @var Bids $bids
         */
        $bids = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Bids::class, $bids);
    }

    /**
     * @depends testAddCampaigns_byService
     * @depends testAddRelatedAdGroup_byCollection
     *
     * @param $campaigns
     */
    public function testSetRelatedContextBids_byModel(Campaigns $campaigns){
        $campaign = $campaigns->first();

        // Demo =====================================================================

        /**
         * Sets the context bids for the campaign model. [$campaign]
         *
         * @var Result $result
         * @var Campaign $campaign
         */
        $result = $campaign->setRelatedContextBids(30000000);

        /**
         * Convert result to Bids collection.
         *
         * @var Bids $bids
         */
        $bids = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Bids::class, $bids);
    }

    /**
     * @depends testAddCampaigns_byService
     * @depends testAddRelatedAdGroup_byCollection
     *
     * @param $campaigns
     */
    public function testSetRelatedContextBids_byCollection(Campaigns $campaigns){

        // Demo =====================================================================

        /**
         * Sets the context bids for the key phrases of each campaign
         * in the collection. [$campaigns]
         *
         * @var Result $result
         * @var Campaigns $campaigns
         */
        $result = $campaigns->setRelatedContextBids(10000000);

        /**
         * Convert result to Bids collection.
         * @var Bids $bids
         */
        $bids = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Bids::class, $bids);
    }

    public function testSetRelatedStrategyPriority_byService(){
        $this->markTestIncomplete('Not implemented');
    }

    public function testSetRelatedStrategyPriority_byModel(){
        $this->markTestIncomplete('Not implemented');
    }

    public function testSetRelatedStrategyPriority_byCollection(){
        $this->markTestIncomplete('Not implemented');
    }

    /**
     * @depends testAddCampaigns_byService
     * @depends testAddRelatedAdGroup_byCollection
     *
     * @param Campaigns $campaigns
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ServiceException
     */
    public function testSetRelatedBidsAuto_byService(Campaigns $campaigns){
        $session = self::$session;
        $campaignIds = $campaigns->extract('id');

        // Demo =====================================================================

        /**
         * Create the bid constructor options model.
         * @var BidAuto $bidAuto
         */
        $bidAuto = BidAuto::make()
            ->setScope(['SEARCH'])
            ->setPosition('PREMIUMBLOCK');

        /**
         * Sets the bid constructor options for the keywords of
         * each campaign with ids [$campaignIds].
         * @var Result $result
         * @var array $campaignIds
         */
        $result = $session
            ->getCampaignsService()
            ->setRelatedBidsAuto($campaignIds, $bidAuto);

        /**
         * Convert result to Bids collection.
         * @var BidsAuto $bids
         */
        $bids = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(BidsAuto::class, $bids);
    }

    /**
     * @depends testAddCampaigns_byService
     * @depends testAddRelatedAdGroup_byCollection
     *
     * @param $campaigns
     */
    public function testSetRelatedBidsAuto_byModel(Campaigns $campaigns){
        $campaign = $campaigns->first();

        // Demo =====================================================================

        /**
         * Sets the bid constructor options for the campaign model. [$campaign]
         * @var Result $result
         * @var Campaign $campaign
         */
        $result = $campaign->setRelatedBidsAuto(
            BidAuto::make()
                ->setScope(['SEARCH'])
                ->setPosition('PREMIUMBLOCK')
        );

        /**
         * Convert result to Bids collection.
         * @var BidsAuto $bids
         */
        $bids = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(BidsAuto::class, $bids);
    }

    /**
     * @depends testAddCampaigns_byService
     * @depends testAddRelatedAdGroup_byCollection
     *
     * @param $campaigns
     */
    public function testSetRelatedBidsAuto_byCollection(Campaigns $campaigns){

        // Demo =====================================================================

        /**
         * Sets the bid constructor options for the keywords of
         * each campaign in the collection [$campaigns].
         * @var Result $result
         * @var Campaigns $campaigns
         */
        $result = $campaigns->setRelatedBidsAuto(
            BidAuto::make()
                ->setScope(['SEARCH'])
                ->setPosition('PREMIUMBLOCK')
        );

        /**
         * Convert result to Bids collection.
         * @var BidsAuto $bids
         */
        $bids = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(BidsAuto::class, $bids);
    }

    /**
     * @depends testAddCampaigns_byService
     *
     * @param Campaigns $campaigns
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testGetRelatedKeywords_byService(Campaigns $campaigns){
        $session = self::$session;
        $campaignIds = $campaigns->extract('id');

        // Demo =====================================================================

        /**
         * Get Keywords by campaign ids [$campaignIds]
         * @var Result $result
         * @var array $campaignIds
         */
        $result = $session
            ->getCampaignsService()
            ->getRelatedKeywords($campaignIds, ['Id','Keyword','Status']);

        /**
         * Convert result to Keywords collection.
         * @var Keywords $keywords
         */
        $keywords = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Keywords::class, $keywords);
    }

    /**
     * @depends testAddCampaigns_byService
     *
     * @param $campaigns
     */
    public function testGetRelatedKeywords_byModel(Campaigns $campaigns){
        $campaign = $campaigns->first();

        // Demo =====================================================================

        /**
         * Get Keywords by campaign model [$campaign]
         * @var Result $result
         * @var Campaign $campaign
         */
        $result = $campaign->getRelatedKeywords(['Id','Keyword','Status']);

        /**
         * Convert result to Keywords collection.
         * @var Keywords $keywords
         */
        $keywords = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Keywords::class, $keywords);
    }

    /**
     * @depends testAddCampaigns_byService
     *
     * @param $campaigns
     */
    public function testGetRelatedKeywords_byCollection(Campaigns $campaigns){

        // Demo =====================================================================

        /**
         * Get Keywords for all campaigns in the collection [$campaigns]
         * @var Result $result
         * @var Campaigns $campaigns
         */
        $result = $campaigns->getRelatedKeywords(['Id','Keyword','Status']);

        /**
         * Convert result to Keywords collection.
         * @var Keywords $keywords
         */
        $keywords = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Keywords::class, $keywords);
    }

    /**
     * @depends testAddCampaigns_byService
     *
     * @param Campaigns $campaigns
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testGetRelatedWebpages_byService(Campaigns $campaigns){
        $session = self::$session;
        $campaignIds = $campaigns->extract('id');

        // Demo =====================================================================

        /**
         * Get parameters targeting dynamic ads for all
         * campaigns with ids [$campaignIds].
         * @var Result $result
         * @var array $campaignIds
         */
        $result = $session
            ->getCampaignsService()
            ->getRelatedWebpages($campaignIds, ['AdGroupId','Bid','CampaignId']);

        /**
         * Convert result to Webpages collection.
         * @var Webpages $webpages
         */
        $webpages = $result->getResource();

        // End Demo =====================================================================

        $this->assertIsArray($campaignIds);
        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Webpages::class, $webpages);
    }

    /**
     * @depends testAddCampaigns_byService
     *
     * @param $campaigns
     */
    public function testGetRelatedWebpages_byModel(Campaigns $campaigns){
        $campaign = $campaigns->first();

        // Demo =====================================================================

        /**
         * Get parameters targeting dynamic ads for campaign model [$campaign].
         * @var Result $result
         * @var Campaign $campaign
         */
        $result = $campaign->getRelatedWebpages(['AdGroupId','Bid','CampaignId']);

        /**
         * Convert result to Webpages collection.
         * @var Webpages $webpages
         */
        $webpages = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Webpages::class, $webpages);
    }

    /**
     * @depends testAddCampaigns_byService
     *
     * @param $campaigns
     */
    public function testGetRelatedWebpages_byCollection(Campaigns $campaigns){

        // Demo =====================================================================

        /**
         * Get parameters targeting dynamic ads for all
         * campaigns in the collection [$campaigns].
         * @var Result $result
         * @var Campaigns $campaigns
         */
        $result = $campaigns->getRelatedWebpages(['AdGroupId','Bid','CampaignId']);

        /**
         * Convert result to Webpages collection.
         * @var Webpages $adGroups
         */
        $webpages = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Webpages::class, $webpages);
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Update campaigns
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddCampaigns_byService
     *
     * @param $campaigns
     */
    public function testUpdateCampaigns_byService(Campaigns $campaigns){
        $session = self::$session;

        // Demo =====================================================================

        /**
         * Get the first campaign from the collection.
         * @var Campaigns $campaign - Campaign collection
         * @var Campaign $campaign - Campaign model
         */
        $campaign = $campaigns->first();

        /**
         * Changing impression strategy parameters for a campaign.
         * @var Campaign $campaign
         */
        $campaign->textCampaign->biddingStrategy
            ->setSearch(
                TextCampaignSearchStrategy::make()
                    ->setBiddingStrategyType(TextCampaignSearchStrategy::WB_MAXIMUM_CLICKS)
                    ->setWbMaximumClicks(
                        StrategyMaximumClicks::make()
                            ->setWeeklySpendLimit(300000000)
                            ->setBidCeiling(2000000)
                    )
            )
            ->setNetwork(
                TextCampaignNetworkStrategy::make()
                    ->setBiddingStrategyType(TextCampaignNetworkStrategy::NETWORK_DEFAULT)
                    ->setNetworkDefault(
                        StrategyNetworkDefault::make()
                            ->setLimitPercent(30)
                            ->setBidPercent(10)
                    )
            );

        /**
         * Saving changes to Yandex.Direct.
         * @var Result $result
         */
        $result = $session
            ->getCampaignsService()
            ->update($campaign);

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
    }

    /**
     * @depends testAddCampaigns_byService
     *
     * @param $campaigns
     */
    public function testUpdateCampaigns_byModel(Campaigns $campaigns){

        // Demo =====================================================================

        /**
         * Get the first campaign from the collection.
         * @var Campaigns $campaign - Campaign collection
         * @var Campaign $campaign - Campaign model
         */
        $campaign = $campaigns->first();

        /**
         * Changing impression strategy parameters for a campaign.
         * @var Campaign $campaign
         */
        $campaign->textCampaign->biddingStrategy
            ->setSearch(
                TextCampaignSearchStrategy::make()
                    ->setBiddingStrategyType(TextCampaignSearchStrategy::WB_MAXIMUM_CLICKS)
                    ->setWbMaximumClicks(
                        StrategyMaximumClicks::make()
                            ->setWeeklySpendLimit(300000000)
                            ->setBidCeiling(2000000)
                    )
            )
            ->setNetwork(
                TextCampaignNetworkStrategy::make()
                    ->setBiddingStrategyType(TextCampaignNetworkStrategy::NETWORK_DEFAULT)
                    ->setNetworkDefault(
                        StrategyNetworkDefault::make()
                            ->setLimitPercent(30)
                            ->setBidPercent(10)
                    )
            );

        /**
         * Saving changes to Yandex.Direct.
         * @var Result $result
         */
        $result = $campaign->update();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Delete
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddCampaigns_byService
     *
     * @param $campaigns
     */
    public function testDeleteCampaigns(Campaigns $campaigns){

        /**
         * @var Campaigns $campaigns
         */
        $result = $campaigns->delete();

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
    }

    /**
     * @depends testAddDynamicTextCampaigns_byService
     *
     * @param Campaigns $campaigns
     */
    public function testDeleteDynamicTextCampaigns(Campaigns $campaigns){

        /**
         * @var Campaigns $campaigns
         */
        $result = $campaigns->delete();

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
    }
}