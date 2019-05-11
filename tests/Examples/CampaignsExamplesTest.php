<?php

namespace YandexDirectSDKTest\Examples;

use PHPUnit\Framework\TestCase;
use YandexDirectSDK\Collections\AdGroups;
use YandexDirectSDK\Collections\Ads;
use YandexDirectSDK\Collections\AudienceTargets;
use YandexDirectSDK\Collections\BidModifiers;
use YandexDirectSDK\Collections\BidModifierToggles;
use YandexDirectSDK\Collections\Bids;
use YandexDirectSDK\Collections\BidsAuto;
use YandexDirectSDK\Collections\Campaigns;
use YandexDirectSDK\Collections\KeywordBids;
use YandexDirectSDK\Collections\KeywordBidsAuto;
use YandexDirectSDK\Collections\Keywords;
use YandexDirectSDK\Collections\RegionalAdjustments;
use YandexDirectSDK\Collections\Webpages;
use YandexDirectSDK\Components\Data;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\ModelCollectionException;
use YandexDirectSDK\Exceptions\RequestException;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\Bid;
use YandexDirectSDK\Models\BidAuto;
use YandexDirectSDK\Models\BiddingRule;
use YandexDirectSDK\Models\BidModifier;
use YandexDirectSDK\Models\Campaign;
use YandexDirectSDK\Models\Keyword;
use YandexDirectSDK\Models\KeywordBid;
use YandexDirectSDK\Models\KeywordBidAuto;
use YandexDirectSDK\Models\RegionalAdjustment;
use YandexDirectSDK\Models\SearchByTrafficVolume;
use YandexDirectSDK\Models\StrategyMaximumClicks;
use YandexDirectSDK\Models\StrategyNetworkDefault;
use YandexDirectSDK\Models\TextCampaign;
use YandexDirectSDK\Models\TextCampaignNetworkStrategy;
use YandexDirectSDK\Models\TextCampaignSearchStrategy;
use YandexDirectSDK\Models\TextCampaignStrategy;
use YandexDirectSDKTest\Helpers\SessionTools;

class CampaignsExamplesTest extends TestCase
{
    public function testCreateCampaignModelByArray(){
        $session = SessionTools::init();

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
    public function testCreateCampaignsCollectionByArray(){
        $session = SessionTools::init();

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

    /**
     * @return Campaigns
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testAddCampaignsByService(){
        $session = SessionTools::init();

        /**
         * Creating a new campaign.
         * @var Result $result
         */
        $result = $session->getCampaignsService()->add(
            Campaigns::make()->push(
                Campaign::make()
                    ->setName('MyCampaign')
                    ->setStartDate('2019-10-01')
                    ->setEndDate('2019-10-10')
                    ->setTextCampaign(
                        TextCampaign::make()
                            ->setBiddingStrategy(
                                TextCampaignStrategy::make()
                                    ->setSearch(
                                        TextCampaignSearchStrategy::make()
                                            ->setBiddingStrategyType(TextCampaignSearchStrategy::HIGHEST_POSITION)
                                    )
                                    ->setNetwork(
                                        TextCampaignNetworkStrategy::make()
                                            ->setBiddingStrategyType(TextCampaignNetworkStrategy::MAXIMUM_COVERAGE)
                                    )
                            )
                    )
                    ->setNegativeKeywords(['set','negative','keywords'])
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

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(Campaigns::class, $campaigns);

        return $campaigns;
    }

    /**
     * @depends testDeleteCampaigns
     *
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws RequestException
     */
    public function testAddCampaignsByArray(){
        $session = SessionTools::init();

        /**
         * Creating a new campaign.
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

    /**
     * @depends testAddCampaignsByService
     *
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testGetCampaignsByService(){
        $session = SessionTools::init();

        /**
         * Getting a list of result.
         * @var Result $result
         */
        $result = $session->getCampaignsService()->query()
            ->select('Id','Name','State','TextCampaign.BiddingStrategy', 'TextCampaign.Settings')
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
    }

    /**
     * @depends testAddCampaignsByService
     *
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testGetCampaignsByModel(){
        $session = SessionTools::init();

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

    }

    /**
     * @depends testAddCampaignsByService
     *
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws ModelCollectionException
     */
    public function testGetCampaignsByCollection(){
        $session = SessionTools::init();

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
    }

    /**
     * @depends testGetCampaignsByService
     *
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testArchiveCampaigns(){
        $session = $result = SessionTools::init();

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
        $session = SessionTools::init();

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
     * @depends testGetCampaignsByService
     *
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testSuspendCampaigns(){
        $session = SessionTools::init();

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
        $session = SessionTools::init();

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

    /**
     * @depends testAddCampaignsByService
     *
     * @param $campaigns
     * @return AdGroups
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testAddRelatedAdGroup($campaigns){
        /**
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
     * @depends testAddCampaignsByService
     *
     * @param $campaigns
     * @return AdGroups
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testAddRelatedAdGroups($campaigns){

        /**
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

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(AdGroups::class, $adGroups);

        return $adGroups;
    }

    /**
     * @depends testAddCampaignsByService
     * @depends testAddRelatedAdGroup
     * @depends testAddRelatedAdGroups
     *
     * @param $campaigns
     */
    public function testGetRelatedAdGroups($campaigns){

        /**
         * @var Campaigns $campaigns
         */

        $result = $campaigns->getRelatedAdGroups(['Id','CampaignId','Name']);

        /**
         * Convert result to adGroups collection.
         * @var AdGroups $adGroups
         */
        $adGroups = $result->getResource();

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(AdGroups::class, $adGroups);

    }

    /**
     * @depends testAddCampaignsByService
     *
     * @param $campaigns
     * @return BidModifiers
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testAddRelatedBidModifier($campaigns){

        /**
         * @var Campaigns $campaigns
         */

        $result = $campaigns->addRelatedBidModifiers(
            BidModifier::make()->setRegionalAdjustments(
                RegionalAdjustments::make(
                    RegionalAdjustment::make()
                        ->setRegionId(225)
                        ->setBidModifier(50),
                    RegionalAdjustment::make()
                        ->setRegionId(1)
                        ->setBidModifier(50)
                )

            )
        );

        /**
         * Convert result to BidModifiers collection.
         * @var BidModifiers $bidModifiers
         */
        $bidModifiers = $result->getResource();

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(BidModifiers::class, $bidModifiers);

        return $bidModifiers;
    }

    /**
     * @depends testAddCampaignsByService
     * @depends testAddRelatedBidModifier
     *
     * @param $campaigns
     * @return BidModifiers
     */
    public function testGetRelatedBidModifiers($campaigns){

        /**
         * @var Campaigns $campaigns
         */

        $result = $campaigns->getRelatedBidModifiers(['Id','CampaignId','AdGroupId']);

        /**
         * Convert result to BidModifiers collection.
         * @var BidModifiers $bidModifiers
         */
        $bidModifiers = $result->getResource();

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(BidModifiers::class, $bidModifiers);

        return $bidModifiers;
    }

    /**
     * @depends testAddCampaignsByService
     * @depends testAddRelatedBidModifier
     *
     * @param $campaigns
     */
    public function testDisableBidModifiers($campaigns){

        /**
         * @var Campaigns $campaigns
         */

        $result = $campaigns->disableBidModifiers('REGIONAL_ADJUSTMENT');

        /**
         * Convert result to BidModifierToggles collection.
         * @var BidModifierToggles $bidModifierToggles
         */
        $bidModifierToggles = $result->getResource();

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(BidModifierToggles::class, $bidModifierToggles);
    }

    /**
     * @depends testAddCampaignsByService
     * @depends testAddRelatedBidModifier
     * @depends testDisableBidModifiers
     *
     * @param $campaigns
     */
    public function testEnableBidModifiers($campaigns){

        /**
         * @var Campaigns $campaigns
         */

        $result = $campaigns->enableBidModifiers('REGIONAL_ADJUSTMENT');

        /**
         * Convert result to BidModifierToggles collection.
         * @var BidModifierToggles $bidModifierToggles
         */
        $bidModifierToggles = $result->getResource();

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(BidModifierToggles::class, $bidModifierToggles);
    }

    /**
     * @depends testAddCampaignsByService
     * @depends testAddRelatedAdGroups
     *
     * @param $campaigns
     */
    public function testGetRelatedAds($campaigns){

        /**
         * @var Campaigns $campaigns
         */

        $result = $campaigns->getRelatedAds(['Id','TextAd.Title']);

        /**
         * Convert result to Ads collection.
         * @var Ads $ads
         */
        $ads = $result->getResource();

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Ads::class, $ads);
    }

    /**
     * @depends testAddCampaignsByService
     * @depends testAddRelatedAdGroups
     *
     * @param $campaigns
     */
    public function testGetRelatedAudienceTargets($campaigns){

        /**
         * @var Campaigns $campaigns
         */

        $result = $campaigns->getRelatedAudienceTargets(['Id','AdGroupId','CampaignId']);

        /**
         * Convert result to AudienceTargets collection.
         * @var AudienceTargets $audienceTargets
         */
        $audienceTargets = $result->getResource();

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(AudienceTargets::class, $audienceTargets);
    }

    /**
     * @depends testAddCampaignsByService
     * @depends testAddRelatedAdGroup
     *
     * @param $campaigns
     */
    public function testGetRelatedBids($campaigns){

        /**
         * @var Campaigns $campaigns
         */
        $result = $campaigns->getRelatedBids(['Bid','AdGroupId','CampaignId']);

        /**
         * Convert result to Bids collection.
         * @var Bids $bids
         */
        $bids = $result->getResource();

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Bids::class, $bids);
    }

    /**
     * @depends testAddCampaignsByService
     * @depends testAddRelatedAdGroup
     *
     * @param $campaigns
     */
    public function testSetRelatedBids($campaigns){

        /**
         * @var Campaigns $campaigns
         */
        $result = $campaigns->setRelatedBids(
            Bid::make()
                ->setBid(30000000)
                ->setContextBid(10000000)
        );

        /**
         * Convert result to Bids collection.
         * @var Bids $bids
         */
        $bids = $result->getResource();

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Bids::class, $bids);
    }

    /**
     * @depends testAddCampaignsByService
     * @depends testAddRelatedAdGroup
     *
     * @param $campaigns
     */
    public function testSetRelatedBidsAuto($campaigns){
        /**
         * @var Campaigns $campaigns
         */
        $result = $campaigns->setRelatedBidsAuto(
            BidAuto::make()
                ->setScope([BidAuto::SEARCH])
                ->setPosition(BidAuto::PREMIUMBLOCK)
        );

        /**
         * Convert result to Bids collection.
         * @var BidsAuto $bids
         */
        $bids = $result->getResource();

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(BidsAuto::class, $bids);
    }

    /**
     * @depends testAddCampaignsByService
     * @depends testAddRelatedAdGroup
     *
     * @param $campaigns
     */
    public function testGetRelatedKeywordBids($campaigns){

        /**
         * @var Campaigns $campaigns
         */
        $result = $campaigns->getRelatedKeywordBids(['KeywordId','AdGroupId','CampaignId']);

        /**
         * Convert result to Bids collection.
         * @var KeywordBids $keywordBids
         */
        $keywordBids = $result->getResource();

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(KeywordBids::class, $keywordBids);
    }

    /**
     * @depends testAddCampaignsByService
     * @depends testAddRelatedAdGroup
     *
     * @param $campaigns
     */
    public function testSetRelatedKeywordBids($campaigns){

        /**
         * @var Campaigns $campaigns
         */
        $result = $campaigns->setRelatedKeywordBids(
            KeywordBid::make()
                ->setSearchBid(30000000)
                ->setNetworkBid(10000000)
        );

        /**
         * Convert result to Bids collection.
         * @var KeywordBids $keywordBids
         */
        $keywordBids = $result->getResource();

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(KeywordBids::class, $keywordBids);
    }

    /**
     * @depends testAddCampaignsByService
     * @depends testAddRelatedAdGroup
     *
     * @param $campaigns
     */
    public function testSetRelatedKeywordBidsAuto($campaigns){
        /**
         * @var Campaigns $campaigns
         */
        $result = $campaigns->setRelatedKeywordBidsAuto(
            KeywordBidAuto::make()
                ->setBiddingRule(
                    BiddingRule::make()
                        ->setSearchByTrafficVolume(
                            SearchByTrafficVolume::make()
                                ->setTargetTrafficVolume(10)
                        )
                )
        );

        /**
         * Convert result to Bids collection.
         * @var KeywordBidsAuto $keywordBids
         */
        $keywordBids = $result->getResource();

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(KeywordBidsAuto::class, $keywordBids);
    }

    /**
     * @depends testAddCampaignsByService
     *
     * @param $campaigns
     */
    public function testGetRelatedKeywords($campaigns){
        /**
         * @var Campaigns $campaigns
         */
        $result = $campaigns->getRelatedKeywords(['Id','Keyword','Status']);

        /**
         * Convert result to Keywords collection.
         * @var Keywords $adGroups
         */
        $keywords = $result->getResource();

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Keywords::class, $keywords);
    }

    /**
     * @depends testAddCampaignsByService
     *
     * @param $campaigns
     */
    public function testGetRelatedWebpages($campaigns){
        /**
         * @var Campaigns $campaigns
         */
        $result = $campaigns->getRelatedWebpages(['AdGroupId','Bid','CampaignId']);

        /**
         * Convert result to Webpages collection.
         * @var Webpages $adGroups
         */
        $webpages = $result->getResource();

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Webpages::class, $webpages);
    }

    /**
     * @depends testAddCampaignsByService
     *
     * @param $campaigns
     */
    public function testUpdateCampaigns($campaigns){

        /**
         * @var Campaigns $campaigns
         */

        $campaign = $campaigns->first();

        /**
         * @var Campaign $campaign
         */
        $campaign
            ->textCampaign
            ->biddingStrategy
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
         * @var Result $result
         */
        $result = $campaign->update();

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
    }

    /**
     * @depends testAddCampaignsByService
     *
     * @param $campaigns
     */
    public function testDeleteCampaigns($campaigns){

        /**
         * @var Campaigns $campaigns
         */
        $result = $campaigns->delete();

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
    }
}