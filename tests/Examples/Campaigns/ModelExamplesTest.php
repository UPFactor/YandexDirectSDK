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

class ModelExamplesTest extends TestCase
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
    public static $textCampaign_HighestPosition;

    /**
     * @var Campaigns
     */
    public static $textCampaign_WbMaximumClicks;

    /**
     * @var Campaign
     */
    public static $dynamicTextCampaign_HighestPosition;

    /**
     * @var Campaigns
     */
    public static $dynamicTextCampaign_WbMaximumClicks;

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
        if (!is_null(self::$textCampaign_HighestPosition)){
            self::$textCampaign_HighestPosition->delete();
        }

        if (!is_null(self::$textCampaign_WbMaximumClicks)){
            self::$textCampaign_WbMaximumClicks->delete();
        }

        if (!is_null(self::$dynamicTextCampaign_HighestPosition)){
            self::$dynamicTextCampaign_HighestPosition->delete();
        }

        if (!is_null(self::$dynamicTextCampaign_WbMaximumClicks)){
            self::$dynamicTextCampaign_WbMaximumClicks->delete();
        }

        self::$checklists = null;
        self::$session = null;
        self::$fakeSession = null;
        self::$textCampaign_HighestPosition = null;
        self::$textCampaign_WbMaximumClicks = null;
        self::$dynamicTextCampaign_HighestPosition = null;
        self::$dynamicTextCampaign_WbMaximumClicks = null;
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Add
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @return Campaign
     * @throws ModelException
     */
    public function testAddTextCampaigns_HighestPosition()
    {
        $session = self::$session;

        // DEMO =====================================================================

        /**
         * @var Campaign $campaign
         */
        $campaign = Campaign::make()
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
                                    ->setBiddingStrategyType('HIGHEST_POSITION')
                            )
                            ->setNetwork(
                                TextCampaignNetworkStrategy::make()
                                    ->setBiddingStrategyType('MAXIMUM_COVERAGE')
                            )
                    )
            );

        /**
         * @var Session $session
         * @var Campaign $campaign
         */
        $campaign->setSession($session);
        $campaign->add();

        // ==========================================================================

        self::$checklists->checkModel($campaign, ['Id' => 'integer']);
        self::$textCampaign_HighestPosition = $campaign;
        return $campaign;
    }

    /**
     * @return Campaign
     * @throws ModelException
     */
    public function testAddTextCampaigns_WbMaximumClicks()
    {
        $session = self::$session;

        // DEMO =====================================================================

        /**
         * @var Campaign $campaign
         */
        $campaign = Campaign::make()
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
            );

        /**
         * @var Session $session
         * @var Campaign $campaign
         */
        $campaign->setSession($session);
        $campaign->add();

        // ==========================================================================

        self::$checklists->checkModel($campaign, ['Id' => 'integer']);
        self::$textCampaign_WbMaximumClicks = $campaign;
        return $campaign;
    }

    /**
     * @return Campaign
     * @throws ModelException
     */
    public function testAddDynamicTextCampaigns_HighestPosition()
    {
        $session = self::$session;

        // DEMO =====================================================================

        /**
         * @var Campaign $campaign
         */
        $campaign = Campaign::make()
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
            );

        /**
         * @var Session $session
         * @var Campaign $campaign
         */
        $campaign->setSession($session);
        $campaign->add();

        // ==========================================================================

        self::$checklists->checkModel($campaign, ['Id' => 'integer']);
        self::$dynamicTextCampaign_HighestPosition = $campaign;
        return $campaign;
    }

    /**
     * @return Campaign
     * @throws ModelException
     */
    public function testAddDynamicTextCampaigns_WbMaximumClicks()
    {
        $session = self::$session;

        // DEMO =====================================================================

        /**
         * @var Campaign $campaign
         */
        $campaign = Campaign::make()
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
            );

        /**
         * @var Session $session
         * @var Campaign $campaign
         */
        $campaign->setSession($session);
        $campaign->add();

        // ==========================================================================

        self::$checklists->checkModel($campaign, ['Id' => 'integer']);
        self::$dynamicTextCampaign_WbMaximumClicks = $campaign;
        return $campaign;
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
     * @param Campaign $campaign
     */
    public function testSuspend(Campaign $campaign)
    {
        // DEMO =====================================================================

        /**
         * @var Campaign $campaign
         * @var Result $result
         */
        $result = $campaign->suspend();

        // ==========================================================================

        self::$checklists->checkResult($result);
        sleep(10);
    }

    /**
     * @depends testAddTextCampaigns_HighestPosition
     * @depends testSuspend
     *
     * @param Campaign $campaign
     */
    public function testArchive(Campaign $campaign)
    {
        // DEMO =====================================================================

        /**
         * @var Campaign $campaign
         * @var Result $result
         */
        $result = $campaign->archive();

        // ==========================================================================

        self::$checklists->checkResult($result);
        sleep(10);
    }

    /**
     * @depends testAddTextCampaigns_HighestPosition
     * @depends testArchive
     *
     * @param Campaign $campaign
     */
    public function testUnarchive(Campaign $campaign)
    {
        // DEMO =====================================================================

        /**
         * @var Campaign $campaign
         * @var Result $result
         */
        $result = $campaign->unarchive();

        // ==========================================================================

        self::$checklists->checkResult($result);
        sleep(10);
    }

    /**
     * @depends testAddTextCampaigns_HighestPosition
     * @depends testUnarchive
     *
     * @param Campaign $campaign
     */
    public function testResume(Campaign $campaign)
    {
        // DEMO =====================================================================

        /**
         * @var Campaign $campaign
         * @var Result $result
         */
        $result = $campaign->resume();

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
     * @param Campaign $campaign
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     */
    public function testAddRelatedTextAdGroup_HighestPosition(Campaign $campaign)
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
         * @var Campaign $campaign
         * @var Result $result
         */
        $result = $campaign->addRelatedAdGroups($adGroup);

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
         * @var AdGroups $adGroup
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
     * @param Campaign $campaign
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     */
    public function testAddRelatedTextAdGroup_WbMaximumClicks(Campaign $campaign)
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
         * @var Campaign $campaign
         * @var Result $result
         */
        $result = $campaign->addRelatedAdGroups($adGroup);

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
     * @param Campaign $campaign
     * @throws ModelException
     */
    public function testAddRelatedDynamicTextAdGroup_WbMaximumClicks(Campaign $campaign)
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
         * @var Campaign $campaign
         * @var Result $result
         */
        $result = $campaign->addRelatedAdGroups($adGroup);

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
     * @param Campaign $campaign
     * @throws ModelException
     */
    public function testGetRelatedAdGroup(Campaign $campaign)
    {
        // DEMO =====================================================================

        /**
         * @var Campaign $campaign
         * @var Result $result
         */
        $result = $campaign->getRelatedAdGroups(['Id','Name']);

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
     * @param Campaign $campaign
     * @throws ModelException
     */
    public function testAddRelatedBidModifiers(Campaign $campaign)
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
         * @var Campaign $campaign
         * @var Result $result
         */
        $result = $campaign->addRelatedBidModifiers($bidModifier);

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
     * @param Campaign $campaign
     * @throws ModelException
     */
    public function testGetRelatedBidModifiers(Campaign $campaign)
    {
        // DEMO =====================================================================

        /**
         * @var Campaign $campaign
         * @var Result $result
         */
        $result = $campaign->getRelatedBidModifiers([
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
     * @param Campaign $campaign
     * @throws ModelException
     */
    public function testDisableBidModifiers(Campaign $campaign)
    {
        // DEMO =====================================================================

        /**
         * @var Campaign $campaign
         * @var Result $result
         */
        $result = $campaign->disableBidModifiers('REGIONAL_ADJUSTMENT');

        // ==========================================================================

        self::$checklists->checkResource($result, BidModifierToggles::class);
    }

    /**
     * @depends testAddTextCampaigns_HighestPosition
     * @depends testDisableBidModifiers
     *
     * @param Campaign $campaign
     * @throws ModelException
     */
    public function testEnableBidModifiers(Campaign $campaign)
    {
        // DEMO =====================================================================

        /**
         * @var Campaign $campaign
         * @var Result $result
         */
        $result = $campaign->enableBidModifiers('REGIONAL_ADJUSTMENT');

        // ==========================================================================

        self::$checklists->checkResource($result, BidModifierToggles::class);
    }

    /**
     * @depends testAddTextCampaigns_HighestPosition
     * @depends testAddRelatedTextAdGroup_HighestPosition
     *
     * @param Campaign $campaign
     * @throws ModelException
     */
    public function testGetRelatedAds(Campaign $campaign)
    {
        // DEMO =====================================================================

        /**
         * @var Campaign $campaign
         * @var Result $result
         */
        $result = $campaign->getRelatedAds(['Id','TextAd.Title']);

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
     * @param Campaign $campaign
     * @throws InvalidArgumentException
     * @throws ModelException
     * @throws RuntimeException
     */
    public function testGetRelatedAudienceTarget(Campaign $campaign)
    {
        // DEMO =====================================================================

        /**
         * @var Campaign $campaign
         * @var Result $result
         */
        $result = $campaign->getRelatedAudienceTargets(['Id','AdGroupId','State']);

        // ==========================================================================

        self::$checklists->checkResource($result, AudienceTargets::class);

        $result = self::$fakeSession
            ->getCampaignsService()
            ->getRelatedAudienceTargets($campaign->id, []);

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
     * @param Campaign $campaign
     * @throws ModelException
     */
    public function testSetRelatedBids(Campaign $campaign)
    {
        // DEMO =====================================================================

        /**
         * @var Campaign $campaign
         * @var Result $result
         */
        $result = $campaign->setRelatedBids(30000000, 10000000);


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
     * @param Campaign $campaign
     * @throws ModelException
     */
    public function testSetRelatedContextBids(Campaign $campaign)
    {
        // DEMO =====================================================================

        /**
         * @var Campaign $campaign
         * @var Result $result
         */
        $result = $campaign->setRelatedContextBids(10000000);

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
     * @param Campaign $campaign
     * @throws ModelException
     */
    public function testSetRelatedStrategyPriority(Campaign $campaign)
    {
        // DEMO =====================================================================

        /**
         * @var Campaign $campaign
         * @var Result $result
         */
        $result = $campaign->setRelatedStrategyPriority('LOW');


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
     * @param Campaign $campaign
     * @throws ModelException
     */
    public function testSetRelatedBidsAuto(Campaign $campaign)
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
         * @var Campaign $campaign
         * @var Result $result
         */
        $result = $campaign->setRelatedBidsAuto($bidAuto);

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
     * @param Campaign $campaign
     * @throws ModelException
     */
    public function testGetRelatedBids(Campaign $campaign)
    {
        // DEMO =====================================================================

        /**
         * @var Campaign $campaign
         * @var Result $result
         */
        $result = $campaign->getRelatedBids(['Bid','CampaignId','AdGroupId','KeywordId']);

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
     * @param Campaign $campaign
     * @throws ModelException
     */
    public function testGetRelatedKeywords(Campaign $campaign)
    {
        // DEMO =====================================================================

        /**
         * @var Campaign $campaign
         * @var Result $result
         */
        $result = $campaign->getRelatedKeywords(['Id','Keyword','Status']);

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
     * @param Campaign $campaign
     * @throws InvalidArgumentException
     * @throws ModelException
     * @throws RuntimeException
     */
    public function testGetRelatedWebpages(Campaign $campaign)
    {
        // DEMO =====================================================================

        /**
         * @var Campaign $campaign
         * @var Result $result
         */
        $result = $campaign->getRelatedWebpages(['Id','Name','CampaignId','AdGroupId']);

        // ==========================================================================

        self::$checklists->checkResource($result, Webpages::class);

        $result = self::$fakeSession
            ->getCampaignsService()
            ->getRelatedWebpages($campaign->id, []);

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
     * @param Campaign $campaign
     * @throws ModelException
     */
    public function testUpdateTextCampaigns_HighestPosition(Campaign $campaign)
    {
        // DEMO =====================================================================

        /**
         * @var Campaign $campaign
         */
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

        /**
         * @var Campaign $campaign
         * @var Result $result
         */
        $result = $campaign->update();

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
     * @param Campaign $campaign
     */
    public function testDeleteTextCampaigns_HighestPosition(Campaign $campaign)
    {
        // DEMO =====================================================================

        $result = $campaign->delete();

        // ==========================================================================

        self::$checklists->checkResult($result);
        self::$textCampaign_HighestPosition = null;
    }
}