<?php


namespace YandexDirectSDKTest\Examples\Campaigns;

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
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\ModelCollectionException;
use YandexDirectSDK\Exceptions\ModelException;
use YandexDirectSDK\Exceptions\RequestException;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Exceptions\ServiceException;
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

class ServiceExamplesTest extends TestCase
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
     * @var Campaigns
     */
    public static $textCampaigns_WbMaximumClicks;

    /**
     * @var Campaign
     */
    public static $dynamicTextCampaigns_HighestPosition;

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
     * @return Campaigns|ModelInterface|ModelCollectionInterface
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     */
    public function testAddTextCampaigns_HighestPosition()
    {
        $session = self::$session;

        // DEMO =====================================================================

        $result = $session->getCampaignsService()->add(
            Campaigns::make(
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
                                            ->setBiddingStrategyType('HIGHEST_POSITION')
                                    )
                                    ->setNetwork(
                                        TextCampaignNetworkStrategy::make()
                                            ->setBiddingStrategyType('MAXIMUM_COVERAGE')
                                    )
                            )
                    )
            )
        );

        // ==========================================================================

        $campaigns = self::$checklists->checkResource($result, Campaigns::class, ['Id' => 'integer']);
        self::$textCampaigns_HighestPosition = $campaigns;
        return $campaigns;
    }

    /**
     * @return Campaigns|ModelInterface|ModelCollectionInterface
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     */
    public function testAddTextCampaigns_WbMaximumClicks()
    {
        $session = self::$session;

        // DEMO =====================================================================

        $result = $session->getCampaignsService()->add(
            Campaigns::make(
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
                    ->setNegativeKeywords(['set','negative','keywords'])
            )
        );

        // ==========================================================================

        $campaigns = self::$checklists->checkResource($result, Campaigns::class, ['Id' => 'integer']);
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
         * @var Session $session
         * @var Result $result
         */
        $result = $session->getCampaignsService()->add(
            Campaigns::make(
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
            )
        );

        // ==========================================================================

        $campaigns = self::$checklists->checkResource($result, Campaigns::class, ['Id' => 'integer']);
        self::$dynamicTextCampaigns_HighestPosition = $campaigns;
        return $campaigns;
    }

    /**
     * @return Campaigns|ModelInterface|ModelCollectionInterface
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     */
    public function testAddDynamicTextCampaigns_WbMaximumClicks()
    {
        $session = self::$session;

        // DEMO =====================================================================

        /**
         * @var Session $session
         * @var Result $result
         */
        $result = $session->getCampaignsService()->add(
            Campaigns::make(
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

        // ==========================================================================

        $campaigns = self::$checklists->checkResource($result, Campaigns::class, ['Id' => 'integer']);
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
        $result = $session->getCampaignsService()->query()
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
        $session = self::$session;
        $campaignsIds = $campaigns->extract('id');

        // DEMO =====================================================================

        /**
         * @var Session $session
         * @var array $campaignIds
         * @var Result $result
         */
        $result = $session->getCampaignsService()->suspend($campaignsIds);

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
        $session = self::$session;
        $campaignsIds = $campaigns->extract('id');

        // DEMO =====================================================================

        /**
         * @var Session $session
         * @var array $campaignIds
         * @var Result $result
         */
        $result = $session->getCampaignsService()->archive($campaignsIds);

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
        $session = self::$session;
        $campaignsIds = $campaigns->extract('id');

        // DEMO =====================================================================

        /**
         * @var Session $session
         * @var array $campaignIds
         * @var Result $result
         */
        $result = $session->getCampaignsService()->unarchive($campaignsIds);

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
        $session = self::$session;
        $campaignsIds = $campaigns->extract('id');

        // DEMO =====================================================================

        /**
         * @var Session $session
         * @var array $campaignIds
         * @var Result $result
         */
        $result = $session->getCampaignsService()->resume($campaignsIds);

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
     * @throws ServiceException
     */
    public function testAddRelatedTextAdGroup_HighestPosition(Campaigns $campaigns)
    {
        $session = self::$session;
        $campaignIds = $campaigns->extract('id');

        // DEMO =====================================================================

        /**
         * @var AdGroup $adGroup
         */
        $adGroup = AdGroup::make()
            ->setName('MyAdGroup')
            ->setRegionIds([225]);

        /**
         * @var AdGroup $adGroup
         * @var array $campaignIds
         * @var Session $session
         * @var Result $result
         */
        $result = $session
            ->getCampaignsService()
            ->addRelatedAdGroups($campaignIds, $adGroup);

        // ==========================================================================

        self::$checklists->checkResource($result, AdGroups::class, [
            'Id' => 'integer',
            'Name' => 'string',
            'RegionIds' => 'array',
            'CampaignId' => 'integer'
        ]);

        /**
         * @var AdGroups $adGroup
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
     * @throws ServiceException
     */
    public function testAddRelatedTextAdGroup_WbMaximumClicks(Campaigns $campaigns)
    {
        $session = self::$session;
        $campaignIds = $campaigns->extract('id');

        // DEMO =====================================================================

        /**
         * @var AdGroup $adGroup
         */
        $adGroup = AdGroup::make()
            ->setName('MyAdGroup')
            ->setRegionIds([225]);

        /**
         * @var AdGroup $adGroup
         * @var array $campaignIds
         * @var Session $session
         * @var Result $result
         */
        $result = $session
            ->getCampaignsService()
            ->addRelatedAdGroups($campaignIds, $adGroup);

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
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     * @throws ServiceException
     */
    public function testAddRelatedDynamicTextAdGroup_WbMaximumClicks(Campaigns $campaigns)
    {
        $session = self::$session;
        $campaignIds = $campaigns->extract('id');

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
         * @var array $campaignIds
         * @var Session $session
         * @var Result $result
         */
        $result = $session
            ->getCampaignsService()
            ->addRelatedAdGroups($campaignIds, $adGroup);

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
     * @throws InvalidArgumentException
     * @throws ModelException
     * @throws RuntimeException
     */
    public function testGetRelatedAdGroup(Campaigns $campaigns)
    {
        $session = self::$session;
        $campaignIds = $campaigns->extract('id');

        // DEMO =====================================================================

        /**
         * @var array $campaignIds
         * @var Session $session
         * @var Result $result
         */
        $result = $session
            ->getCampaignsService()
            ->getRelatedAdGroups($campaignIds, ['Id','Name']);

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
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     * @throws RuntimeException
     * @throws ServiceException
     * @throws ReflectionException
     * @throws RequestException
     */
    public function testAddRelatedBidModifiers(Campaigns $campaigns)
    {
        $session = self::$session;
        $campaignIds = $campaigns->extract('id');

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
         * @var array $campaignIds
         * @var Session $session
         * @var Result $result
         */
        $result = $session
            ->getCampaignsService()
            ->addRelatedBidModifiers($campaignIds, $bidModifier);

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
     * @throws InvalidArgumentException
     * @throws ModelException
     * @throws RuntimeException
     */
    public function testGetRelatedBidModifiers(Campaigns $campaigns)
    {
        $session = self::$session;
        $campaignIds = $campaigns->extract('id');

        // DEMO =====================================================================

        /**
         * @var array $campaignIds
         * @var Session $session
         * @var Result $result
         */
        $result = $session
            ->getCampaignsService()
            ->getRelatedBidModifiers($campaignIds, [
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
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function testDisableBidModifiers(Campaigns $campaigns)
    {
        $session = self::$session;
        $campaignIds = $campaigns->extract('id');

        // DEMO =====================================================================

        /**
         * @var array $campaignIds
         * @var Session $session
         * @var Result $result
         */
        $result = $session
            ->getCampaignsService()
            ->disableBidModifiers($campaignIds, 'REGIONAL_ADJUSTMENT');

        // ==========================================================================

        self::$checklists->checkResource($result, BidModifierToggles::class);
    }

    /**
     * @depends testAddTextCampaigns_HighestPosition
     * @depends testDisableBidModifiers
     *
     * @param Campaigns $campaigns
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function testEnableBidModifiers(Campaigns $campaigns)
    {
        $session = self::$session;
        $campaignIds = $campaigns->extract('id');

        // DEMO =====================================================================

        /**
         * @var array $campaignIds
         * @var Session $session
         * @var Result $result
         */
        $result = $session
            ->getCampaignsService()
            ->enableBidModifiers($campaignIds, 'REGIONAL_ADJUSTMENT');

        // ==========================================================================

        self::$checklists->checkResource($result, BidModifierToggles::class);
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
    public function testGetRelatedAds(Campaigns $campaigns)
    {
        $session = self::$session;
        $campaignIds = $campaigns->extract('id');

        // DEMO =====================================================================

        /**
         * @var array $campaignIds
         * @var Session $session
         * @var Result $result
         */
        $result = $session
            ->getCampaignsService()
            ->getRelatedAds($campaignIds, ['Id','TextAd.Title']);

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
        $session = self::$session;
        $campaignIds = $campaigns->extract('id');

        // DEMO =====================================================================

        /**
         * @var array $campaignIds
         * @var Session $session
         * @var Result $result
         */
        $result = $session
            ->getCampaignsService()
            ->getRelatedAudienceTargets($campaignIds, ['Id','AdGroupId','State']);

        // ==========================================================================

        self::$checklists->checkResource($result, AudienceTargets::class);

        $result = self::$fakeSession
            ->getCampaignsService()
            ->getRelatedAudienceTargets($campaignIds, []);

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
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function testSetRelatedBids(Campaigns $campaigns)
    {
        $session = self::$session;
        $campaignIds = $campaigns->extract('id');

        // DEMO =====================================================================

        /**
         * @var array $campaignIds
         * @var Session $session
         * @var Result $result
         */
        $result = $session
            ->getCampaignsService()
            ->setRelatedBids($campaignIds, 30000000, 10000000);


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
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function testSetRelatedContextBids(Campaigns $campaigns)
    {
        $session = self::$session;
        $campaignIds = $campaigns->extract('id');

        // DEMO =====================================================================

        $result = $session
            ->getCampaignsService()
            ->setRelatedContextBids($campaignIds, 10000000);

        // ==========================================================================

        self::$checklists->checkResource($result, Bids::class, [
            'CampaignId' => 'integer',
            'ContextBid' => 'integer'
        ]);
    }

    /**
     * @depends testAddTextCampaigns_WbMaximumClicks
     * @depends testAddRelatedTextAdGroup_WbMaximumClicks
     *
     * @param Campaigns $campaigns
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function testSetRelatedStrategyPriority(Campaigns $campaigns)
    {
        $session = self::$session;
        $campaignIds = $campaigns->extract('id');

        // DEMO =====================================================================

        /**
         * @var array $campaignIds
         * @var Session $session
         * @var Result $result
         */
        $result = $session
            ->getCampaignsService()
            ->setRelatedStrategyPriority($campaignIds, 'LOW');


        // ==========================================================================

        self::$checklists->checkResource($result, Bids::class, [
            'CampaignId' => 'integer',
            'StrategyPriority' => 'string'
        ]);
    }

    /**
     * @depends testAddTextCampaigns_HighestPosition
     * @depends testAddRelatedTextAdGroup_HighestPosition
     *
     * @param Campaigns $campaigns
     * @throws InvalidArgumentException
     * @throws ModelException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ServiceException
     */
    public function testSetRelatedBidsAuto(Campaigns $campaigns)
    {
        $session = self::$session;
        $campaignIds = $campaigns->extract('id');

        // DEMO =====================================================================

        /**
         * @var BidAuto $bidAuto
         */
        $bidAuto = BidAuto::make()
            ->setScope(['SEARCH'])
            ->setPosition('PREMIUMBLOCK');

        /**
         * @var BidAuto $bidAuto
         * @var array $campaignIds
         * @var Session $session
         * @var Result $result
         */
        $result = $session
            ->getCampaignsService()
            ->setRelatedBidsAuto($campaignIds, $bidAuto);

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
     * @throws InvalidArgumentException
     * @throws ModelException
     * @throws RuntimeException
     */
    public function testGetRelatedBids(Campaigns $campaigns)
    {
        $session = self::$session;
        $campaignIds = $campaigns->extract('id');

        // DEMO =====================================================================

        /**
         * @var Result $result
         * @var Session $session
         * @var array $campaignIds
         */
        $result = $session
            ->getCampaignsService()
            ->getRelatedBids($campaignIds, ['Bid','CampaignId','AdGroupId','KeywordId']);

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
     * @throws InvalidArgumentException
     * @throws ModelException
     * @throws RuntimeException
     */
    public function testGetRelatedKeywords(Campaigns $campaigns)
    {
        $session = self::$session;
        $campaignIds = $campaigns->extract('id');

        // DEMO =====================================================================

        /**
         * @var Result $result
         * @var Session $session
         * @var array $campaignIds
         */
        $result = $session
            ->getCampaignsService()
            ->getRelatedKeywords($campaignIds, ['Id','Keyword','Status']);

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
        $session = self::$session;
        $campaignIds = $campaigns->extract('id');

        // DEMO =====================================================================

        /**
         * @var Result $result
         * @var Session $session
         * @var array $campaignIds
         */
        $result = $session
            ->getCampaignsService()
            ->getRelatedWebpages($campaignIds, ['Id','Name','CampaignId','AdGroupId']);

        // ==========================================================================

        self::$checklists->checkResource($result, Webpages::class);

        $result = self::$fakeSession
            ->getCampaignsService()
            ->getRelatedWebpages($campaignIds, []);

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
        $session = self::$session;

        // DEMO =====================================================================

        /**
         * @var Campaigns $campaigns
         * @var Campaign $campaign
         */
        $campaign = $campaigns->first();

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
         * Saving changes to Yandex.Direct.
         * @var Result $result
         */
        $result = $session
            ->getCampaignsService()
            ->update($campaign);

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
        $session = self::$session;
        $campaignIds = $campaigns->extract('id');

        // DEMO =====================================================================

        $result = $session
            ->getCampaignsService()
            ->delete($campaignIds);

        // ==========================================================================

        self::$checklists->checkResult($result);
        self::$textCampaigns_HighestPosition = null;
    }
}