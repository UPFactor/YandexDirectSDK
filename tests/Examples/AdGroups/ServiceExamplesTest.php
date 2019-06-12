<?php


namespace YandexDirectSDKTest\Examples\AdGroups;

use PHPUnit\Framework\TestCase;
use ReflectionException;
use YandexDirectSDK\Collections\AdGroups;
use YandexDirectSDK\Collections\Ads;
use YandexDirectSDK\Collections\AudienceTargets;
use YandexDirectSDK\Collections\BidModifiers;
use YandexDirectSDK\Collections\BidModifierToggles;
use YandexDirectSDK\Collections\Bids;
use YandexDirectSDK\Collections\BidsAuto;
use YandexDirectSDK\Collections\Keywords;
use YandexDirectSDK\Collections\WebpageConditions;
use YandexDirectSDK\Collections\Webpages;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\ModelCollectionException;
use YandexDirectSDK\Exceptions\ModelException;
use YandexDirectSDK\Exceptions\RequestException;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Exceptions\ServiceException;
use YandexDirectSDK\Interfaces\ModelCollection as ModelCollectionInterface;
use YandexDirectSDK\Models\Ad;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\AudienceTarget;
use YandexDirectSDK\Models\BidAuto;
use YandexDirectSDK\Models\BidModifier;
use YandexDirectSDK\Models\Campaign;
use YandexDirectSDK\Models\DemographicsAdjustment;
use YandexDirectSDK\Models\DynamicTextAd;
use YandexDirectSDK\Models\DynamicTextAdGroup;
use YandexDirectSDK\Models\Keyword;
use YandexDirectSDK\Models\TextAd;
use YandexDirectSDK\Models\Webpage;
use YandexDirectSDK\Models\WebpageCondition;
use YandexDirectSDK\Session;
use YandexDirectSDKTest\Examples\Campaigns\ModelExamplesTest as CampaignModelExamples;
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
     * @var Campaign
     */
    public static $textCampaign_HighestPosition;

    /**
     * @var Campaign
     */
    public static $textCampaign_WbMaximumClicks;

    /**
     * @var Campaign
     */
    public static $dynamicTextCampaign_HighestPosition;

    /**
     * @var Campaign
     */
    public static $dynamicTextCampaign_WbMaximumClicks;

    /**
     * @var AdGroups
     */
    public static $textAdGroups_HighestPosition;

    /**
     * @var AdGroups
     */
    public static $textAdGroups_WbMaximumClicks;

    /**
     * @var AdGroups
     */
    public static $dynamicTextAdGroups_HighestPosition;

    /**
     * @var AdGroups
     */
    public static $dynamicTextAdGroups_WbMaximumClicks;

    /*
     |-------------------------------------------------------------------------------
     |
     | Handlers
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @throws RuntimeException
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     */
    public static function setUpBeforeClass():void
    {
        $campaignExamples = new CampaignModelExamples();
        $campaignExamples::setUpBeforeClass();

        self::$checklists = new Checklists();
        self::$session = SessionTools::init();
        self::$fakeSession = SessionTools::fake(__DIR__.'/../../Data/Base');
        self::$textCampaign_HighestPosition = $campaignExamples->testAddTextCampaigns_HighestPosition();
        self::$textCampaign_WbMaximumClicks = $campaignExamples->testAddTextCampaigns_WbMaximumClicks();
        self::$dynamicTextCampaign_HighestPosition = $campaignExamples->testAddDynamicTextCampaigns_HighestPosition();
        self::$dynamicTextCampaign_WbMaximumClicks = $campaignExamples->testAddDynamicTextCampaigns_WbMaximumClicks();
    }

    public static function tearDownAfterClass():void
    {
        CampaignModelExamples::tearDownAfterClass();

        self::$textCampaign_HighestPosition = null;
        self::$textCampaign_WbMaximumClicks = null;
        self::$dynamicTextCampaign_HighestPosition = null;
        self::$dynamicTextCampaign_WbMaximumClicks = null;
        self::$textAdGroups_HighestPosition = null;
        self::$textAdGroups_WbMaximumClicks = null;
        self::$dynamicTextAdGroups_HighestPosition = null;
        self::$dynamicTextAdGroups_WbMaximumClicks = null;
        self::$checklists = null;
        self::$session = null;
        self::$fakeSession = null;
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Add
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @return AdGroups|ModelCollectionInterface
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     */
    public function testAddTextAdGroup_HighestPosition()
    {
        $session = self::$session;
        $campaign = self::$textCampaign_HighestPosition;

        // DEMO =====================================================================

        /**
         * @var Campaign $campaign
         * @var Session $session
         */
        $result = $session->getAdGroupsService()->add(
            AdGroups::make(
                AdGroup::make()
                    ->setName('MyAdGroup')
                    ->setCampaignId($campaign->id)
                    ->setRegionIds([225])
                    ->setNegativeKeywords(['set','negative','keywords'])
                    ->setTrackingParams('from=direct&ad={ad_id}')
            )
        );

        // ==========================================================================

        $adGroups = self::$checklists->checkResource($result, AdGroups::class, ['Id' => 'integer']);
        self::$textAdGroups_HighestPosition = $adGroups;

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

        return $adGroups;
    }

    /**
     * @return AdGroups|ModelCollectionInterface
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     */
    public function testAddTextAdGroup_WbMaximumClicks()
    {
        $session = self::$session;
        $campaign = self::$textCampaign_WbMaximumClicks;

        // DEMO =====================================================================

        $result = $session->getAdGroupsService()->add(
            AdGroups::make(
                AdGroup::make()
                    ->setName('MyAdGroup')
                    ->setCampaignId($campaign->id)
                    ->setRegionIds([225])
                    ->setNegativeKeywords(['set','negative','keywords'])
                    ->setTrackingParams('from=direct&ad={ad_id}')
            )
        );

        // ==========================================================================

        $adGroups = self::$checklists->checkResource($result, AdGroups::class, ['Id' => 'integer']);
        self::$textAdGroups_WbMaximumClicks = $adGroups;

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

        return $adGroups;
    }

    /**
     * @return AdGroups|ModelCollectionInterface
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     */
    public function testAddDynamicTextAdGroup_HighestPosition()
    {
        $session = self::$session;
        $campaign = self::$dynamicTextCampaign_HighestPosition;

        // DEMO =====================================================================

        $result = $session->getAdGroupsService()->add(
            AdGroups::make(
                AdGroup::make()
                    ->setName('MyAdGroup')
                    ->setCampaignId($campaign->id)
                    ->setRegionIds([225])
                    ->setDynamicTextAdGroup(
                        DynamicTextAdGroup::make()
                            ->setDomainUrl('yandex.com')
                    )
            )
        );

        // ==========================================================================

        $adGroups = self::$checklists->checkResource($result, AdGroups::class, ['Id' => 'integer']);
        self::$dynamicTextAdGroups_HighestPosition = $adGroups;

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

        return $adGroups;
    }

    /**
     * @return AdGroups|ModelCollectionInterface
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     */
    public function testAddDynamicTextAdGroup_WbMaximumClicks()
    {
        $session = self::$session;
        $campaign = self::$dynamicTextCampaign_WbMaximumClicks;

        // DEMO =====================================================================

        $result = $session->getAdGroupsService()->add(
            AdGroups::make(
                AdGroup::make()
                    ->setName('MyAdGroup')
                    ->setCampaignId($campaign->id)
                    ->setRegionIds([225])
                    ->setDynamicTextAdGroup(
                        DynamicTextAdGroup::make()
                            ->setDomainUrl('yandex.com')
                    )
            )
        );

        // ==========================================================================

        $adGroups = self::$checklists->checkResource($result, AdGroups::class, ['Id' => 'integer']);
        self::$dynamicTextAdGroups_WbMaximumClicks = $adGroups;

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

        return $adGroups;
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Get
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddTextAdGroup_HighestPosition
     *
     * @param AdGroups $adGroups
     * @throws InvalidArgumentException
     * @throws ModelException
     * @throws RuntimeException
     */
    public function testGetAdGroup(AdGroups $adGroups)
    {
        $session = self::$session;
        $adGroupsIds = $adGroups->extract('id');

        // DEMO =====================================================================

        /**
         * @var Session $session
         * @var array $adGroupsIds
         * @var Result $result
         */
        $result = $session->getAdGroupsService()->query()
            ->select(
                'Id',
                'Name',
                'RegionIds',
                'NegativeKeywords'
            )
            ->whereIn('Ids', $adGroupsIds)
            ->limit(10)
            ->get();

        // ==========================================================================

        self::$checklists->checkResource($result, AdGroups::class, [
            'Id' => 'integer',
            'Name' => 'string',
            'RegionIds' => 'array',
            'NegativeKeywords' => 'array'
        ]);
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Related
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddTextAdGroup_HighestPosition
     *
     * @param AdGroups $adGroups
     * @throws ModelException
     * @throws ServiceException
     */
    public function testAddRelatedAds_HighestPosition(AdGroups $adGroups)
    {
        $session = self::$session;
        $adGroupsIds = $adGroups->extract('id');

        // DEMO =====================================================================

        /**
         * @var Ad $ad
         */
        $ad = Ad::make()
            ->setTextAd(
                TextAd::make()
                    ->setTitle('My Title')
                    ->setTitle2('My Title2')
                    ->setText('My text')
                    ->setHref('https://mysite.com/page/')
                    ->setMobile('NO')
            );

        /**
         * @var Ad $ad
         * @var Session $session
         * @var array $adGroupsIds
         * @var Result $result
         */
        $result = $session
            ->getAdGroupsService()
            ->addRelatedAds($adGroupsIds, $ad);

        // ==========================================================================

        self::$checklists->checkResource($result, Ads::class, [
            'TextAd.Title' => 'string',
            'TextAd.Title2' => 'string',
            'TextAd.Text' => 'string',
            'TextAd.Mobile' => 'string'
        ]);
    }

    /**
     * @depends testAddTextAdGroup_HighestPosition
     * @depends testAddRelatedAds_HighestPosition
     *
     * @param AdGroups $adGroups
     * @throws InvalidArgumentException
     * @throws ModelException
     * @throws RuntimeException
     */
    public function testGetRelatedAds(AdGroups $adGroups)
    {
        $session = self::$session;
        $adGroupsIds = $adGroups->extract('id');

        // DEMO =====================================================================

        /**
         * @var Session $session
         * @var array $adGroupsIds
         * @var Result $result
         */
        $result = $session
            ->getAdGroupsService()
            ->getRelatedAds($adGroupsIds, ['Id','TextAd.Title']);

        // ==========================================================================

        self::$checklists->checkResource($result, Ads::class, [
            'Id' => 'integer',
            'TextAd.Title' => 'string'
        ]);
    }

    /**
     * @depends testAddTextAdGroup_HighestPosition
     *
     * @param AdGroups $adGroups
     * @throws ModelException
     * @throws ServiceException
     */
    public function testAddRelatedAudienceTargets(AdGroups $adGroups)
    {
        $session = self::$session;
        $adGroupsIds = $adGroups->extract('id');

        // DEMO =====================================================================

        /**
         * @var AudienceTarget $audienceTarget
         */
        $audienceTarget = AudienceTarget::make()
            ->setInterestId(42)
            ->setContextBid(20000000);

        /**
         * @var AudienceTarget $audienceTarget
         * @var Session $session
         * @var array $adGroupsIds
         * @var Result $result
         */
        $result = $session
            ->getAdGroupsService()
            ->addRelatedAudienceTargets($adGroupsIds, $audienceTarget);

        // ==========================================================================

        $this->assertEquals(8800, $result->errors->get('0.0.code'));

        $result = self::$fakeSession
            ->getAdGroupsService()
            ->addRelatedAudienceTargets($adGroupsIds, $audienceTarget);

        self::$checklists->checkResource($result, AudienceTargets::class, [
            'Id' => 'integer',
            'AdGroupId' => 'integer',
            'InterestId' => 'integer',
            'ContextBid' => 'integer'
        ]);
    }

    /**
     * @depends testAddTextAdGroup_HighestPosition
     * @depends testAddRelatedAudienceTargets
     *
     * @param AdGroups $adGroups
     * @throws InvalidArgumentException
     * @throws ModelException
     * @throws RuntimeException
     */
    public function testGetRelatedAudienceTargets(AdGroups $adGroups)
    {
        $session = self::$session;
        $adGroupsIds = $adGroups->extract('id');

        // DEMO =====================================================================

        /**
         * @var array $adGroupsIds
         * @var Session $session
         * @var Result $result
         */
        $result = $session
            ->getAdGroupsService()
            ->getRelatedAudienceTargets($adGroupsIds, ['Id','AdGroupId','State']);

        // ==========================================================================

        self::$checklists->checkResource($result, AudienceTargets::class);

        $result = self::$fakeSession
            ->getAdGroupsService()
            ->getRelatedAudienceTargets($adGroupsIds, []);

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
     * @depends testAddTextAdGroup_HighestPosition
     *
     * @param AdGroups $adGroups
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     * @throws RuntimeException
     * @throws RequestException
     */
    public function testSetRelatedBids(AdGroups $adGroups)
    {
        $session = self::$session;
        $adGroupsIds = $adGroups->extract('id');

        // DEMO =====================================================================

        /**
         * @var array $adGroupsIds
         * @var Session $session
         * @var Result $result
         */
        $result = $session
            ->getAdGroupsService()
            ->setRelatedBids($adGroupsIds, 30000000, 10000000);


        // ==========================================================================

        self::$checklists->checkResource($result, Bids::class, [
            'AdGroupId',
            'Bid',
            'ContextBid'
        ]);
    }

    /**
     * @depends testAddTextAdGroup_HighestPosition
     *
     * @param AdGroups $adGroups
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function testSetRelatedContextBids(AdGroups $adGroups)
    {
        $session = self::$session;
        $adGroupsIds = $adGroups->extract('id');

        // DEMO =====================================================================

        $result = $session
            ->getAdGroupsService()
            ->setRelatedContextBids($adGroupsIds, 10000000);

        // ==========================================================================

        self::$checklists->checkResource($result, Bids::class, [
            'AdGroupId' => 'integer',
            'ContextBid' => 'integer'
        ]);
    }

    /**
     * @depends testAddTextAdGroup_WbMaximumClicks
     *
     * @param AdGroups $adGroups
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function testSetRelatedStrategyPriority(AdGroups $adGroups)
    {
        $session = self::$session;
        $adGroupsIds = $adGroups->extract('id');

        // DEMO =====================================================================

        /**
         * @var array $adGroupsIds
         * @var Session $session
         * @var Result $result
         */
        $result = $session
            ->getAdGroupsService()
            ->setRelatedStrategyPriority($adGroupsIds, 'LOW');


        // ==========================================================================

        self::$checklists->checkResource($result, Bids::class, [
            'AdGroupId' => 'integer',
            'StrategyPriority' => 'string'
        ]);
    }

    /**
     * @depends testAddTextAdGroup_HighestPosition
     *
     * @param AdGroups $adGroups
     * @throws InvalidArgumentException
     * @throws ModelException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ServiceException
     */
    public function testSetRelatedBidsAuto(AdGroups $adGroups)
    {
        $session = self::$session;
        $adGroupsIds = $adGroups->extract('id');

        // DEMO =====================================================================

        /**
         * @var BidAuto $bidAuto
         */
        $bidAuto = BidAuto::make()
            ->setScope(['SEARCH'])
            ->setPosition('PREMIUMBLOCK');

        /**
         * @var BidAuto $bidAuto
         * @var array $adGroupsIds
         * @var Session $session
         * @var Result $result
         */
        $result = $session
            ->getAdGroupsService()
            ->setRelatedBidsAuto($adGroupsIds, $bidAuto);

        // ==========================================================================

        self::$checklists->checkResource($result, BidsAuto::class, [
            'AdGroupId' => 'integer',
            'Scope' => 'array',
            'Position' => 'string'
        ]);
    }

    /**
     * @depends testAddTextAdGroup_HighestPosition
     * @depends testSetRelatedBids
     * @depends testSetRelatedContextBids
     * @depends testSetRelatedStrategyPriority
     * @depends testSetRelatedBidsAuto
     *
     * @param AdGroups $adGroups
     * @throws InvalidArgumentException
     * @throws ModelException
     * @throws RuntimeException
     */
    public function testGetRelatedBids(AdGroups $adGroups)
    {
        $session = self::$session;
        $adGroupsIds = $adGroups->extract('id');

        // DEMO =====================================================================

        /**
         * @var Result $result
         * @var Session $session
         * @var array $adGroupsIds
         */
        $result = $session
            ->getAdGroupsService()
            ->getRelatedBids($adGroupsIds, ['Bid','CampaignId','AdGroupId','KeywordId']);

        // ==========================================================================

        self::$checklists->checkResource($result, Bids::class, [
            'Bid' => 'integer',
            'CampaignId' => 'integer',
            'AdGroupId' => 'integer',
            'KeywordId' => 'integer'
        ]);
    }

    /**
     * @depends testAddTextAdGroup_HighestPosition
     *
     * @param AdGroups $adGroups
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ServiceException
     * @throws ReflectionException
     */
    public function testAddRelatedBidModifiers(AdGroups $adGroups)
    {
        $session = self::$session;
        $adGroupsIds = $adGroups->extract('id');

        // DEMO =====================================================================

        /**
         * @var BidModifier $bidModifier
         */
        $bidModifier = BidModifier::make()
            ->setDemographicsAdjustment(
                DemographicsAdjustment::make()
                    ->setAge('AGE_18_24')
                    ->setGender('GENDER_FEMALE')
                    ->setBidModifier(50)
            );

        /**
         * @var BidModifier $bidModifier
         * @var array $adGroupsIds
         * @var Session $session
         * @var Result $result
         */
        $result = $session
            ->getAdGroupsService()
            ->addRelatedBidModifiers($adGroupsIds, $bidModifier);

        // ==========================================================================

        self::$checklists->checkResource($result, BidModifiers::class, [
            'Id' => 'integer',
            'AdGroupId' => 'integer',
            'DemographicsAdjustment.Age' => 'string',
            'DemographicsAdjustment.Gender' => 'string',
            'DemographicsAdjustment.BidModifier' => 'integer'
        ]);
    }

    /**
     * @depends testAddTextAdGroup_HighestPosition
     * @depends testAddRelatedBidModifiers
     *
     * @param AdGroups $adGroups
     * @throws InvalidArgumentException
     * @throws ModelException
     * @throws RuntimeException
     */
    public function testGetRelatedBidModifiers(AdGroups $adGroups)
    {
        $session = self::$session;
        $adGroupsIds = $adGroups->extract('id');

        // DEMO =====================================================================

        /**
         * @var array $adGroupsIds
         * @var Session $session
         * @var Result $result
         */
        $result = $session
            ->getAdGroupsService()
            ->getRelatedBidModifiers($adGroupsIds, [
                'Id',
                'AdGroupId',
                'DemographicsAdjustment.Age',
                'DemographicsAdjustment.Gender',
                'DemographicsAdjustment.BidModifier'
            ]);

        // ==========================================================================

        self::$checklists->checkResource($result, BidModifiers::class, [
            'Id' => 'integer',
            'AdGroupId' => 'integer',
            'DemographicsAdjustment.Age' => 'string',
            'DemographicsAdjustment.Gender' => 'string',
            'DemographicsAdjustment.BidModifier' => 'integer'
        ]);
    }

    /**
     * @depends testAddTextAdGroup_HighestPosition
     * @depends testGetRelatedBidModifiers
     *
     * @param AdGroups $adGroups
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function testDisableBidModifiers(AdGroups $adGroups)
    {
        $session = self::$session;
        $adGroupsIds = $adGroups->extract('id');

        // DEMO =====================================================================

        /**
         * @var array $adGroupsIds
         * @var Session $session
         * @var Result $result
         */
        $result = $session
            ->getAdGroupsService()
            ->disableBidModifiers($adGroupsIds, 'DEMOGRAPHICS_ADJUSTMENT');

        // ==========================================================================

        self::$checklists->checkResource($result, BidModifierToggles::class);
    }

    /**
     * @depends testAddTextAdGroup_HighestPosition
     * @depends testDisableBidModifiers
     *
     * @param AdGroups $adGroups
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function testEnableBidModifiers(AdGroups $adGroups)
    {
        $session = self::$session;
        $adGroupsIds = $adGroups->extract('id');

        // DEMO =====================================================================

        /**
         * @var array $adGroupsIds
         * @var Session $session
         * @var Result $result
         */
        $result = $session
            ->getAdGroupsService()
            ->enableBidModifiers($adGroupsIds, 'DEMOGRAPHICS_ADJUSTMENT');

        // ==========================================================================

        self::$checklists->checkResource($result, BidModifierToggles::class);
    }

    /**
     * @depends testAddTextAdGroup_HighestPosition
     *
     * @param AdGroups $adGroups
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     * @throws ServiceException
     */
    public function testAddRelatedKeywords(AdGroups $adGroups)
    {
        $session = self::$session;
        $adGroupsIds = $adGroups->extract('id');

        // DEMO =====================================================================

        /**
         * @var Session $session
         * @var array $adGroupsIds
         * @var Result $result
         */
        $result = $session
            ->getAdGroupsService()
            ->addRelatedKeywords($adGroupsIds, Keywords::make(
                Keyword::make()->setKeyword('yandex direct -api'),
                Keyword::make()->setKeyword('yandex sdk -direct -api')
            ));

        // ==========================================================================

        self::$checklists->checkResource($result, Keywords::class, [
            'Id' => 'integer',
            'Keyword' => 'string'
        ]);
    }

    /**
     * @depends testAddTextAdGroup_HighestPosition
     * @depends testAddRelatedKeywords
     *
     * @param AdGroups $adGroups
     * @throws InvalidArgumentException
     * @throws ModelException
     * @throws RuntimeException
     */
    public function testGetRelatedKeywords(AdGroups $adGroups)
    {
        $session = self::$session;
        $adGroupsIds = $adGroups->extract('id');

        // DEMO =====================================================================

        /**
         * @var Result $result
         * @var Session $session
         * @var array $adGroupsIds
         */
        $result = $session
            ->getAdGroupsService()
            ->getRelatedKeywords($adGroupsIds, ['Id','Keyword','Status']);

        // ==========================================================================

        self::$checklists->checkResource($result, Keywords::class, [
            'Id' => 'integer',
            'Keyword' => 'string',
            'Status' => 'string'
        ]);
    }

    /**
     * @depends testAddDynamicTextAdGroup_WbMaximumClicks
     *
     * @param AdGroups $adGroups
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     * @throws ServiceException
     */
    public function testAddRelatedWebpages(AdGroups $adGroups)
    {
        $session = self::$session;
        $adGroupsIds = $adGroups->extract('id');

        // DEMO =====================================================================

        /**
         * @var Session $session
         * @var array $adGroupsIds
         * @var Result $result
         */
        $result = $session
            ->getAdGroupsService()
            ->addRelatedWebpages($adGroupsIds, Webpage::make()
                ->setName('MyTargetingCondition')
                ->setConditions(
                    WebpageConditions::make(
                        WebpageCondition::domainContain(['mysite.com']),
                        WebpageCondition::pageNotContain(['home','main'])
                    )
                ));

        // ==========================================================================

        self::$checklists->checkResource($result, Webpages::class, [
            'Id' => 'integer',
            'AdGroupId' => 'integer',
            'Name' => 'string',
            'Conditions.0.Operand' => 'string',
            'Conditions.0.Operator' => 'string',
            'Conditions.0.Arguments' => 'array',
            'Conditions.1.Operand' => 'string',
            'Conditions.1.Operator' => 'string',
            'Conditions.1.Arguments' => 'array'
        ]);
    }

    /**
     * @depends testAddDynamicTextAdGroup_WbMaximumClicks
     * @depends testAddRelatedWebpages
     *
     * @param AdGroups $adGroups
     * @throws InvalidArgumentException
     * @throws ModelException
     * @throws RuntimeException
     */
    public function testGetRelatedWebpages(AdGroups $adGroups)
    {
        $session = self::$session;
        $adGroupsIds = $adGroups->extract('id');

        // DEMO =====================================================================

        /**
         * @var Result $result
         * @var Session $session
         * @var array $adGroupsIds
         */
        $result = $session
            ->getAdGroupsService()
            ->getRelatedWebpages($adGroupsIds, ['Id','Name','CampaignId','AdGroupId']);

        // ==========================================================================

        self::$checklists->checkResource($result, Webpages::class, [
            'Id' => 'integer',
            'AdGroupId' => 'integer',
            'CampaignId' => 'integer',
            'Name' => 'string',
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
     * @depends testAddTextAdGroup_HighestPosition
     *
     * @param AdGroups $adGroups
     * @throws ModelException
     */
    public function testUpdateTextAdGroup_HighestPosition(AdGroups $adGroups)
    {
        $session = self::$session;

        // DEMO =====================================================================

        /**
         * @var AdGroups $adGroups
         * @var AdGroup $adGroup
         */
        $adGroup = $adGroups->first();

        /**
         * @var AdGroup $adGroup
         */
        $adGroup
            ->setName('MyAdGroup')
            ->setNegativeKeywords(['set','negative','keywords'])
            ->setTrackingParams('from=direct&ad={ad_id}');

        /**
         * @var Result $result
         */
        $result = $session
            ->getAdGroupsService()
            ->update($adGroup);

        // ==========================================================================

        self::$checklists->checkResource($result, AdGroups::class);
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Delete
     |
     |-------------------------------------------------------------------------------
    */

    public function testDeleteTextAdGroup_HighestPosition()
    {
        $session = self::$session;
        $campaign = self::$textCampaign_HighestPosition;

        $result = $session->getAdGroupsService()->add(
            AdGroup::make()
                ->setName('MyAdGroup')
                ->setCampaignId($campaign->id)
                ->setRegionIds([225])
        );

        $adGroupsIds = $result->getResource()->extract('id');

        // DEMO =====================================================================

        $result = $session
            ->getAdGroupsService()
            ->delete($adGroupsIds);

        // ==========================================================================

        self::$checklists->checkResult($result);
    }
}