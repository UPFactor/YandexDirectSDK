<?php


namespace YandexDirectSDKTest\Examples\Campaigns;


use PHPUnit\Framework\TestCase;
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
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\ModelCollectionException;
use YandexDirectSDK\Exceptions\ModelException;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Interfaces\Model as ModelInterface;
use YandexDirectSDK\Interfaces\ModelCollection as ModelCollectionInterface;
use YandexDirectSDK\Models\Ad;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\BidAuto;
use YandexDirectSDK\Models\BidModifier;
use YandexDirectSDK\Models\Campaign;
use YandexDirectSDK\Models\DynamicTextAd;
use YandexDirectSDK\Models\DynamicTextAdGroup;
use YandexDirectSDK\Models\DynamicTextCampaign;
use YandexDirectSDK\Models\DynamicTextCampaignNetworkStrategy;
use YandexDirectSDK\Models\DynamicTextCampaignSearchStrategy;
use YandexDirectSDK\Models\DynamicTextCampaignStrategy;
use YandexDirectSDK\Models\Keyword;
use YandexDirectSDK\Models\RegionalAdjustment;
use YandexDirectSDK\Models\StrategyMaximumClicks;
use YandexDirectSDK\Models\StrategyNetworkDefault;
use YandexDirectSDK\Models\TextAd;
use YandexDirectSDK\Models\TextCampaign;
use YandexDirectSDK\Models\TextCampaignNetworkStrategy;
use YandexDirectSDK\Models\TextCampaignSearchStrategy;
use YandexDirectSDK\Models\TextCampaignStrategy;
use YandexDirectSDK\Session;
use YandexDirectSDKTest\Helpers\Checklists;
use YandexDirectSDKTest\Helpers\FakeSession;
use YandexDirectSDKTest\Helpers\SessionTools;

class CollectionExamplesTest extends TestCase
{
    /**
     * @var Checklists
     */
    public static $checklists;

    /**
     * @var Session
     */
    public static $session;

    /**
     * @var FakeSession
     */
    public static $fakeSession;

    /**
     * @var Campaigns
     */
    public static $textCampaigns_HighestPosition;

    /**
     * @var Campaign
     */
    public static $dynamicTextCampaigns_HighestPosition;

    /**
     * @var Campaigns
     */
    public static $textCampaigns_WbMaximumClicks;

    /**
     * @var Campaigns
     */
    public static $dynamicTextCampaigns_WbMaximumClicks;

    /*
     |-------------------------------------------------------------------------------
     |
     | Handlers
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @throws RuntimeException
     */
    public static function setUpBeforeClass():void
    {
        self::$checklists = new Checklists();
        self::$session = SessionTools::init();
        self::$fakeSession = SessionTools::fake(__DIR__.'/../../Data/Base');
    }

    public static function tearDownAfterClass():void
    {
        if (!is_null(self::$textCampaigns_HighestPosition)){
            self::$textCampaigns_HighestPosition->delete();
        }

        if (!is_null(self::$textCampaigns_WbMaximumClicks)){
            self::$textCampaigns_WbMaximumClicks->delete();
        }

        if (!is_null(self::$dynamicTextCampaigns_HighestPosition)){
            self::$dynamicTextCampaigns_HighestPosition->delete();
        }

        if (!is_null(self::$dynamicTextCampaigns_WbMaximumClicks)){
            self::$dynamicTextCampaigns_WbMaximumClicks->delete();
        }

        self::$checklists = null;
        self::$session = null;
        self::$fakeSession = null;
        self::$textCampaigns_HighestPosition = null;
        self::$textCampaigns_WbMaximumClicks = null;
        self::$dynamicTextCampaigns_HighestPosition = null;
        self::$dynamicTextCampaigns_WbMaximumClicks = null;
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Add
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @return Campaigns
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     */
    public function testAddTextCampaigns_HighestPosition()
    {
        $session = self::$session;

        // DEMO =====================================================================

        /**
         * @var Campaigns $campaigns
         */
        $campaigns = Campaigns::make(
            Campaign::make()
                ->setName('MyTextCampaign1')
                ->setStartDate('2019-10-01')
                ->setEndDate('2019-10-10')
                ->setNegativeKeywords(['set','negative','keywords'])
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
                ),
            Campaign::make()
                ->setName('MyTextCampaign2')
                ->setStartDate('2019-10-01')
                ->setEndDate('2019-10-10')
                ->setNegativeKeywords(['set','negative','keywords'])
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
        );

        /**
         * @var Session $session
         * @var Campaigns $campaign
         */
        $campaigns->setSession($session);
        $campaigns->add();

        // ==========================================================================

        self::$checklists->checkModelCollection($campaigns, ['Id' => 'integer']);
        self::$textCampaigns_HighestPosition = $campaigns;
        return $campaigns;
    }

    /**
     * @return Campaigns
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     */
    public function testAddTextCampaigns_WbMaximumClicks()
    {
        $session = self::$session;

        // DEMO =====================================================================

        /**
         * @var Campaigns $campaigns
         */
        $campaigns = Campaigns::make(
            Campaign::make()
                ->setName('MyTextCampaign')
                ->setStartDate('2019-10-01')
                ->setEndDate('2019-10-10')
                ->setNegativeKeywords(['set','negative','keywords'])
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
                                        ->setNetworkDefault(
                                            StrategyNetworkDefault::make()
                                                ->setLimitPercent(20)
                                                ->setBidPercent(10)
                                        )
                                )
                        )
                ),
            Campaign::make()
                ->setName('MyTextCampaign')
                ->setStartDate('2019-10-01')
                ->setEndDate('2019-10-10')
                ->setNegativeKeywords(['set','negative','keywords'])
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
                                        ->setNetworkDefault(
                                            StrategyNetworkDefault::make()
                                                ->setLimitPercent(20)
                                                ->setBidPercent(10)
                                        )
                                )
                        )
                )
        );

        /**
         * @var Session $session
         * @var Campaigns $campaign
         */
        $campaigns->setSession($session);
        $campaigns->add();

        // ==========================================================================

        self::$checklists->checkModelCollection($campaigns, ['Id' => 'integer']);
        self::$textCampaigns_WbMaximumClicks = $campaigns;
        return $campaigns;
    }

    /**
     * @return Campaigns|ModelInterface|ModelCollectionInterface
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     */
    public function testAddDynamicTextCampaigns_HighestPosition()
    {
        $session = self::$session;

        // DEMO =====================================================================

        /**
         * @var Campaigns $campaigns
         */
        $campaigns = Campaigns::make(
            Campaign::make()
                ->setName('DynamicTextCampaign')
                ->setStartDate('2019-10-01')
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
                ),
            Campaign::make()
                ->setName('DynamicTextCampaign')
                ->setStartDate('2019-10-01')
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
                )
        );

        /**
         * @var Session $session
         * @var Campaigns $campaign
         */
        $campaigns->setSession($session);
        $campaigns->add();

        // ==========================================================================

        self::$checklists->checkModelCollection($campaigns, ['Id' => 'integer']);
        self::$dynamicTextCampaigns_HighestPosition = $campaigns;
        return $campaigns;
    }

    /**
     * @return Campaigns
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     */
    public function testAddDynamicTextCampaigns_WbMaximumClicks()
    {
        $session = self::$session;

        // DEMO =====================================================================

        /**
         * @var Campaigns $campaigns
         */
        $campaigns = Campaigns::make(
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
                ),
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
        );

        /**
         * @var Session $session
         * @var Campaigns $campaign
         */
        $campaigns->setSession($session);
        $campaigns->add();

        // ==========================================================================

        self::$checklists->checkModelCollection($campaigns, ['Id' => 'integer']);
        self::$dynamicTextCampaigns_WbMaximumClicks = $campaigns;
        return $campaigns;
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Get
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddTextCampaigns_HighestPosition
     *
     * @param Campaigns $campaigns
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     * @throws RuntimeException
     */
    public function testGetCampaigns(Campaigns $campaigns)
    {
        $session = self::$session;
        $campaignIds = $campaigns->extract('id');

        // DEMO =====================================================================

        /**
         * @var Session $session
         * @var array $campaignIds
         * @var Result $result
         */
        $result = Campaigns::make()->setSession($session)->query()
            ->select(
                'Id',
                'Name',
                'State',
                'TextCampaign.BiddingStrategy',
                'TextCampaign.Settings'
            )
            ->whereIn('Ids', $campaignIds)
            ->limit(10)
            ->get();

        // ==========================================================================

        self::$checklists->checkResource($result, Campaigns::class, [
            'Id' => 'integer',
            'Name' => 'string',
            'State' => 'string',
            'TextCampaign.BiddingStrategy.Search.BiddingStrategyType' => 'string',
            'TextCampaign.BiddingStrategy.Network.BiddingStrategyType' => 'string',
            'TextCampaign.Settings' => 'array'
        ]);
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Actions
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddTextCampaigns_HighestPosition
     *
     * @param Campaigns $campaigns
     */
    public function testSuspend(Campaigns $campaigns)
    {
        // DEMO =====================================================================

        /**
         * @var Campaigns $campaigns
         * @var Result $result
         */
        $result = $campaigns->suspend();

        // ==========================================================================

        self::$checklists->checkResult($result);
        sleep(10);
    }

    /**
     * @depends testAddTextCampaigns_HighestPosition
     * @depends testSuspend
     *
     * @param Campaigns $campaigns
     */
    public function testArchive(Campaigns $campaigns)
    {
        // DEMO =====================================================================

        /**
         * @var Campaigns $campaigns
         * @var Result $result
         */
        $result = $campaigns->archive();

        // ==========================================================================

        self::$checklists->checkResult($result);
        sleep(10);
    }

    /**
     * @depends testAddTextCampaigns_HighestPosition
     * @depends testArchive
     *
     * @param Campaigns $campaigns
     */
    public function testUnarchive(Campaigns $campaigns)
    {
        // DEMO =====================================================================

        /**
         * @var Campaigns $campaigns
         * @var Result $result
         */
        $result = $campaigns->unarchive();

        // ==========================================================================

        self::$checklists->checkResult($result);
        sleep(10);
    }

    /**
     * @depends testAddTextCampaigns_HighestPosition
     * @depends testUnarchive
     *
     * @param Campaigns $campaigns
     */
    public function testResume(Campaigns $campaigns)
    {
        // DEMO =====================================================================

        /**
         * @var Campaigns $campaigns
         * @var Result $result
         */
        $result = $campaigns->resume();

        // ==========================================================================

        self::$checklists->checkResult($result);
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
     * @depends testAddTextCampaigns_HighestPosition
     *
     * @param Campaigns $campaigns
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     */
    public function testAddRelatedTextAdGroup_HighestPosition(Campaigns $campaigns)
    {
        // DEMO =====================================================================

        /**
         * @var AdGroup $adGroups
         */
        $adGroup = AdGroup::make()
            ->setName('MyAdGroup')
            ->setRegionIds([225]);

        /**
         * @var AdGroup $adGroup
         * @var Campaigns $campaigns
         * @var Result $result
         */
        $result = $campaigns->addRelatedAdGroups($adGroup);

        // ==========================================================================

        self::$checklists->checkResource($result, AdGroups::class, [
            'Id' => 'integer',
            'Name' => 'string',
            'RegionIds' => 'array',
            'CampaignId' => 'integer'
        ]);

        /**
         * @var AdGroups $adGroups
         */
        $adGroups = $result->getResource();

        /**
         * @var Result $result
         * @var AdGroups $adGroups
         */
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

        self::$checklists->checkResource($result, Ads::class, [
            'Id' => 'integer',
            'TextAd.Title' => 'string',
            'TextAd.Title2' => 'string',
            'TextAd.Text' => 'string',
            'TextAd.Href' => 'string',
            'TextAd.Mobile' => 'string'
        ]);

        $result = $adGroups->addRelatedKeywords(
            Keywords::make(
                Keyword::make()->setKeyword('yandex api'),
                Keyword::make()->setKeyword('yandex direct')
            )
        );

        self::$checklists->checkResource($result, Keywords::class, [
            'Id' => 'integer',
            'Keyword' => 'string',
            'AdGroupId' => 'integer'
        ]);
    }

    /**
     * @depends testAddTextCampaigns_WbMaximumClicks
     *
     * @param Campaigns $campaigns
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     */
    public function testAddRelatedTextAdGroup_WbMaximumClicks(Campaigns $campaigns)
    {
        // DEMO =====================================================================

        /**
         * @var AdGroup $adGroup
         */
        $adGroup = AdGroup::make()
            ->setName('MyAdGroup')
            ->setRegionIds([225]);

        /**
         * @var AdGroup $adGroup
         * @var Campaigns $campaigns
         * @var Result $result
         */
        $result = $campaigns->addRelatedAdGroups($adGroup);

        // ==========================================================================

        self::$checklists->checkResource($result, AdGroups::class, [
            'Id' => 'integer',
            'Name' => 'string',
            'RegionIds' => 'array',
            'CampaignId' => 'integer'
        ]);

        /**
         * @var AdGroups $adGroups
         */
        $adGroups = $result->getResource();

        /**
         * @var Result $result
         * @var AdGroups $adGroups
         */
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

        self::$checklists->checkResource($result, Ads::class, [
            'Id' => 'integer',
            'TextAd.Title' => 'string',
            'TextAd.Title2' => 'string',
            'TextAd.Text' => 'string',
            'TextAd.Href' => 'string',
            'TextAd.Mobile' => 'string'
        ]);

        $result = $adGroups->addRelatedKeywords(
            Keywords::make(
                Keyword::make()->setKeyword('yandex api'),
                Keyword::make()->setKeyword('yandex direct')
            )
        );

        self::$checklists->checkResource($result, Keywords::class, [
            'Id' => 'integer',
            'Keyword' => 'string',
            'AdGroupId' => 'integer'
        ]);
    }

    /**
     * @depends testAddDynamicTextCampaigns_WbMaximumClicks
     *
     * @param Campaigns $campaigns
     * @throws ModelException
     */
    public function testAddRelatedDynamicTextAdGroup_WbMaximumClicks(Campaigns $campaigns)
    {
        // DEMO =====================================================================

        /**
         * @var AdGroup $adGroup
         */
        $adGroup = AdGroup::make()
            ->setName('MyAdGroup')
            ->setRegionIds([225])
            ->setDynamicTextAdGroup(
                DynamicTextAdGroup::make()
                    ->setDomainUrl('yandex.com')
            );

        /**
         * @var AdGroup $adGroup
         * @var Campaigns $campaigns
         * @var Result $result
         */
        $result = $campaigns->addRelatedAdGroups($adGroup);

        // ==========================================================================

        self::$checklists->checkResource($result, AdGroups::class, [
            'Id' => 'integer',
            'Name' => 'string',
            'RegionIds' => 'array',
            'CampaignId' => 'integer'
        ]);

        /**
         * @var AdGroups $adGroups
         */
        $adGroups = $result->getResource();

        /**
         * @var Result $result
         * @var AdGroups $adGroups
         */
        $result = $adGroups->addRelatedAds(
            Ad::make()
                ->setDynamicTextAd(
                    DynamicTextAd::make()
                        ->setText('Text of my ad')
                )
        );

        self::$checklists->checkResource($result, Ads::class, [
            'Id' => 'integer',
            'DynamicTextAd.Text' => 'string'
        ]);
    }

    /**
     * @depends testAddTextCampaigns_HighestPosition
     * @depends testAddRelatedTextAdGroup_HighestPosition
     *
     * @param Campaigns $campaigns
     * @throws ModelException
     */
    public function testGetRelatedAdGroup(Campaigns $campaigns)
    {
        // DEMO =====================================================================

        /**
         * @var Campaigns $campaigns
         * @var Result $result
         */
        $result = $campaigns->getRelatedAdGroups(['Id','Name']);

        // ==========================================================================

        self::$checklists->checkResource($result, AdGroups::class, [
            'Id' => 'integer',
            'Name' => 'string'
        ]);
    }

    /**
     * @depends testAddTextCampaigns_HighestPosition
     * @depends testAddRelatedTextAdGroup_HighestPosition
     *
     * @param Campaigns $campaigns
     * @throws ModelException
     */
    public function testAddRelatedBidModifiers(Campaigns $campaigns)
    {
        // DEMO =====================================================================

        /**
         * @var BidModifier $bidModifier
         */
        $bidModifier = BidModifier::make()
            ->setRegionalAdjustment(
                RegionalAdjustment::make()
                    ->setRegionId(225)
                    ->setBidModifier(50)
            );

        /**
         * @var BidModifier $bidModifier
         * @var Campaigns $campaigns
         * @var Result $result
         */
        $result = $campaigns->addRelatedBidModifiers($bidModifier);

        // ==========================================================================

        self::$checklists->checkResource($result, BidModifiers::class, [
            'Id' => 'integer',
            'CampaignId' => 'integer',
            'RegionalAdjustment.RegionId' => 'integer',
            'RegionalAdjustment.BidModifier' => 'integer'
        ]);
    }

    /**
     * @depends testAddTextCampaigns_HighestPosition
     * @depends testAddRelatedBidModifiers
     *
     * @param Campaigns $campaigns
     * @throws ModelException
     */
    public function testGetRelatedBidModifiers(Campaigns $campaigns)
    {
        // DEMO =====================================================================

        /**
         * @var Campaigns $campaigns
         * @var Result $result
         */
        $result = $campaigns->getRelatedBidModifiers([
            'Id',
            'CampaignId',
            'RegionalAdjustment.RegionId',
            'RegionalAdjustment.BidModifier'
        ]);

        // ==========================================================================

        self::$checklists->checkResource($result, BidModifiers::class, [
            'Id' => 'integer',
            'CampaignId' => 'integer',
            'RegionalAdjustment.RegionId' => 'integer',
            'RegionalAdjustment.BidModifier' => 'integer'
        ]);
    }

    /**
     * @depends testAddTextCampaigns_HighestPosition
     * @depends testGetRelatedBidModifiers
     *
     * @param Campaigns $campaigns
     * @throws ModelException
     */
    public function testDisableBidModifiers(Campaigns $campaigns)
    {
        // DEMO =====================================================================

        /**
         * @var Campaigns $campaigns
         * @var Result $result
         */
        $result = $campaigns->disableBidModifiers('REGIONAL_ADJUSTMENT');

        // ==========================================================================

        self::$checklists->checkResource($result, BidModifierToggles::class);
    }

    /**
     * @depends testAddTextCampaigns_HighestPosition
     * @depends testDisableBidModifiers
     *
     * @param Campaigns $campaigns
     * @throws ModelException
     */
    public function testEnableBidModifiers(Campaigns $campaigns)
    {
        // DEMO =====================================================================

        /**
         * @var Campaigns $campaigns
         * @var Result $result
         */
        $result = $campaigns->enableBidModifiers('REGIONAL_ADJUSTMENT');

        // ==========================================================================

        self::$checklists->checkResource($result, BidModifierToggles::class);
    }

    /**
     * @depends testAddTextCampaigns_HighestPosition
     * @depends testAddRelatedTextAdGroup_HighestPosition
     *
     * @param Campaigns $campaigns
     * @throws ModelException
     */
    public function testGetRelatedAds(Campaigns $campaigns)
    {
        // DEMO =====================================================================

        /**
         * @var Campaigns $campaigns
         * @var Result $result
         */
        $result = $campaigns->getRelatedAds(['Id','TextAd.Title']);

        // ==========================================================================

        self::$checklists->checkResource($result, Ads::class, [
            'Id',
            'TextAd.Title'
        ]);
    }

    /**
     * @depends testAddTextCampaigns_HighestPosition
     * @depends testAddRelatedTextAdGroup_HighestPosition
     *
     * @param Campaigns $campaigns
     * @throws InvalidArgumentException
     * @throws ModelException
     * @throws RuntimeException
     */
    public function testGetRelatedAudienceTarget(Campaigns $campaigns)
    {
        // DEMO =====================================================================

        /**
         * @var Campaigns $campaigns
         * @var Result $result
         */
        $result = $campaigns->getRelatedAudienceTargets(['Id','AdGroupId','State']);

        // ==========================================================================

        self::$checklists->checkResource($result, AudienceTargets::class);

        $result = self::$fakeSession
            ->getCampaignsService()
            ->getRelatedAudienceTargets($campaigns->extract('id'), []);

        self::$checklists->checkResource($result, AudienceTargets::class, [
            'Id' => 'integer',
            'AdGroupId' => 'integer',
            'CampaignId' => 'integer',
            'RetargetingListId' => 'integer',
            'InterestId' => 'integer',
            'State' => 'string',
            'ContextBid' => 'integer',
            'StrategyPriority' => 'string'
        ]);
    }

    /**
     * @depends testAddTextCampaigns_HighestPosition
     * @depends testAddRelatedTextAdGroup_HighestPosition
     *
     * @param Campaigns $campaigns
     * @throws ModelException
     */
    public function testSetRelatedBids(Campaigns $campaigns)
    {
        // DEMO =====================================================================

        /**
         * @var Campaigns $campaigns
         * @var Result $result
         */
        $result = $campaigns->setRelatedBids(30000000, 10000000);


        // ==========================================================================

        self::$checklists->checkResource($result, Bids::class, [
            'CampaignId',
            'Bid',
            'ContextBid'
        ]);
    }

    /**
     * @depends testAddTextCampaigns_HighestPosition
     * @depends testAddRelatedTextAdGroup_HighestPosition
     *
     * @param Campaigns $campaigns
     * @throws ModelException
     */
    public function testSetRelatedContextBids(Campaigns $campaigns)
    {
        // DEMO =====================================================================

        /**
         * @var Campaigns $campaigns
         * @var Result $result
         */
        $result = $campaigns->setRelatedContextBids(10000000);

        // ==========================================================================

        self::$checklists->checkResource($result, Bids::class, [
            'CampaignId',
            'ContextBid'
        ]);
    }

    /**
     * @depends testAddTextCampaigns_WbMaximumClicks
     * @depends testAddRelatedTextAdGroup_WbMaximumClicks
     *
     * @param Campaigns $campaigns
     * @throws ModelException
     */
    public function testSetRelatedStrategyPriority(Campaigns $campaigns)
    {
        // DEMO =====================================================================

        /**
         * @var Campaigns $campaigns
         * @var Result $result
         */
        $result = $campaigns->setRelatedStrategyPriority('LOW');


        // ==========================================================================

        self::$checklists->checkResource($result, Bids::class, [
            'CampaignId',
            'StrategyPriority'
        ]);
    }

    /**
     * @depends testAddTextCampaigns_HighestPosition
     * @depends testAddRelatedTextAdGroup_HighestPosition
     *
     * @param Campaigns $campaigns
     * @throws ModelException
     */
    public function testSetRelatedBidsAuto(Campaigns $campaigns)
    {
        // DEMO =====================================================================

        /**
         * @var BidAuto $bidAuto
         */
        $bidAuto = BidAuto::make()
            ->setScope(['SEARCH'])
            ->setPosition('PREMIUMBLOCK');

        /**
         * @var BidAuto $bidAuto
         * @var Campaigns $campaigns
         * @var Result $result
         */
        $result = $campaigns->setRelatedBidsAuto($bidAuto);

        // ==========================================================================

        self::$checklists->checkResource($result, BidsAuto::class, [
            'CampaignId' => 'integer',
            'Scope' => 'array',
            'Position' => 'string'
        ]);
    }

    /**
     * @depends testAddTextCampaigns_HighestPosition
     * @depends testAddRelatedTextAdGroup_HighestPosition
     * @depends testSetRelatedBids
     * @depends testSetRelatedContextBids
     * @depends testSetRelatedStrategyPriority
     * @depends testSetRelatedBidsAuto
     *
     * @param Campaigns $campaigns
     * @throws ModelException
     */
    public function testGetRelatedBids(Campaigns $campaigns)
    {
        // DEMO =====================================================================

        /**
         * @var Campaigns $campaigns
         * @var Result $result
         */
        $result = $campaigns->getRelatedBids(['Bid','CampaignId','AdGroupId','KeywordId']);

        // ==========================================================================

        self::$checklists->checkResource($result, Bids::class, [
            'Bid' => 'integer',
            'CampaignId' => 'integer',
            'AdGroupId' => 'integer',
            'KeywordId' => 'integer'
        ]);
    }

    /**
     * @depends testAddTextCampaigns_HighestPosition
     * @depends testAddRelatedTextAdGroup_HighestPosition
     *
     * @param Campaigns $campaigns
     * @throws ModelException
     */
    public function testGetRelatedKeywords(Campaigns $campaigns)
    {
        // DEMO =====================================================================

        /**
         * @var Campaigns $campaigns
         * @var Result $result
         */
        $result = $campaigns->getRelatedKeywords(['Id','Keyword','Status']);

        // ==========================================================================

        self::$checklists->checkResource($result, Keywords::class, [
            'Id' => 'integer',
            'Keyword' => 'string',
            'Status' => 'string'
        ]);
    }

    /**
     * @depends testAddDynamicTextCampaigns_WbMaximumClicks
     * @depends testAddRelatedDynamicTextAdGroup_WbMaximumClicks
     *
     * @param Campaigns $campaigns
     * @throws InvalidArgumentException
     * @throws ModelException
     * @throws RuntimeException
     */
    public function testGetRelatedWebpages(Campaigns $campaigns)
    {
        // DEMO =====================================================================

        /**
         * @var Campaigns $campaigns
         * @var Result $result
         */
        $result = $campaigns->getRelatedWebpages(['Id','Name','CampaignId','AdGroupId']);

        // ==========================================================================

        self::$checklists->checkResource($result, Webpages::class);

        $result = self::$fakeSession
            ->getCampaignsService()
            ->getRelatedWebpages($campaigns->extract('id'), []);

        self::$checklists->checkResource($result, Webpages::class, [
            'Id' => 'integer',
            'AdGroupId' => 'integer',
            'CampaignId' => 'integer',
            'Name' => 'string',
            'Bid' => 'integer',
            'ContextBid' => 'integer',
            'StrategyPriority' => 'string',
            'State' => 'string',
            'StatusClarification' => 'string',
            'Conditions.0.Operand' => 'string',
            'Conditions.0.Operator' => 'string',
            'Conditions.0.Arguments' => 'array',
            'ConditionType' => 'string'
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
     * @depends testAddTextCampaigns_HighestPosition
     *
     * @param Campaigns $campaigns
     * @throws ModelException
     */
    public function testUpdateTextCampaigns_HighestPosition(Campaigns $campaigns)
    {
        // DEMO =====================================================================

        /**
         * @var Campaigns $campaigns
         */
        $campaigns->each(function (Campaign $campaign){
            $campaign->textCampaign->biddingStrategy
                ->setSearch(
                    TextCampaignSearchStrategy::make()
                        ->setBiddingStrategyType('HIGHEST_POSITION')
                )
                ->setNetwork(
                    TextCampaignNetworkStrategy::make()
                        ->setBiddingStrategyType('NETWORK_DEFAULT')
                        ->setNetworkDefault(
                            StrategyNetworkDefault::make()
                                ->setLimitPercent(20)
                                ->setBidPercent(10)
                        )
                );
        });

        /**
         * @var Campaigns $campaigns
         * @var Result $result
         */
        $result = $campaigns->update();

        // ==========================================================================

        self::$checklists->checkResource($result, Campaigns::class);
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Delete
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddTextCampaigns_HighestPosition
     *
     * @param Campaigns $campaigns
     */
    public function testDeleteTextCampaigns_HighestPosition(Campaigns $campaigns)
    {
        // DEMO =====================================================================

        $result = $campaigns->delete();

        // ==========================================================================

        self::$checklists->checkResult($result);
        self::$textCampaigns_HighestPosition = null;
    }
}