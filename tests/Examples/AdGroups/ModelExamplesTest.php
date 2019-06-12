<?php


namespace YandexDirectSDKTest\Examples\AdGroups;

use PHPUnit\Framework\TestCase;
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
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Exceptions\ServiceException;
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
    public static $textAdGroup_HighestPosition;

    /**
     * @var AdGroups
     */
    public static $textAdGroup_WbMaximumClicks;

    /**
     * @var AdGroups
     */
    public static $dynamicTextAdGroup_HighestPosition;

    /**
     * @var AdGroups
     */
    public static $dynamicTextAdGroup_WbMaximumClicks;

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
        self::$textAdGroup_HighestPosition = null;
        self::$textAdGroup_WbMaximumClicks = null;
        self::$dynamicTextAdGroup_HighestPosition = null;
        self::$dynamicTextAdGroup_WbMaximumClicks = null;
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
     * @return AdGroup
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
        $adGroup = AdGroup::make()
            ->setName('MyAdGroup')
            ->setCampaignId($campaign->id)
            ->setRegionIds([225])
            ->setNegativeKeywords(['set','negative','keywords'])
            ->setTrackingParams('from=direct&ad={ad_id}');

        $adGroup->setSession($session);
        $adGroup->add();

        // ==========================================================================

        self::$checklists->checkModel($adGroup, ['Id' => 'integer']);
        self::$textAdGroup_HighestPosition = $adGroup;

        $result = $adGroup->addRelatedAds(
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

        $result = $adGroup->addRelatedKeywords(
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

        return $adGroup;
    }

    /**
     * @return AdGroup
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     */
    public function testAddTextAdGroup_WbMaximumClicks()
    {
        $session = self::$session;
        $campaign = self::$textCampaign_WbMaximumClicks;

        // DEMO =====================================================================

        /**
         * @var Campaign $campaign
         * @var Session $session
         */
        $adGroup = AdGroup::make()
            ->setName('MyAdGroup')
            ->setCampaignId($campaign->id)
            ->setRegionIds([225])
            ->setNegativeKeywords(['set','negative','keywords'])
            ->setTrackingParams('from=direct&ad={ad_id}');

        $adGroup->setSession($session);
        $adGroup->add();

        // ==========================================================================

        self::$checklists->checkModel($adGroup, ['Id' => 'integer']);
        self::$textAdGroup_WbMaximumClicks = $adGroup;

        $result = $adGroup->addRelatedAds(
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

        $result = $adGroup->addRelatedKeywords(
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

        return $adGroup;
    }

    /**
     * @return AdGroup
     * @throws ModelException
     */
    public function testAddDynamicTextAdGroup_HighestPosition()
    {
        $session = self::$session;
        $campaign = self::$dynamicTextCampaign_HighestPosition;

        // DEMO =====================================================================

        /**
         * @var Campaign $campaign
         * @var Session $session
         */
        $adGroup = AdGroup::make()
            ->setName('MyAdGroup')
            ->setCampaignId($campaign->id)
            ->setRegionIds([225])
            ->setDynamicTextAdGroup(
                DynamicTextAdGroup::make()
                    ->setDomainUrl('yandex.com')
            );

        $adGroup->setSession($session);
        $adGroup->add();

        // ==========================================================================

        self::$checklists->checkModel($adGroup, ['Id' => 'integer']);
        self::$dynamicTextAdGroup_HighestPosition = $adGroup;

        $result = $adGroup->addRelatedAds(
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

        return $adGroup;
    }

    /**
     * @return AdGroup
     * @throws ModelException
     */
    public function testAddDynamicTextAdGroup_WbMaximumClicks()
    {
        $session = self::$session;
        $campaign = self::$dynamicTextCampaign_WbMaximumClicks;

        // DEMO =====================================================================

        /**
         * @var Campaign $campaign
         * @var Session $session
         */
        $adGroup = AdGroup::make()
            ->setName('MyAdGroup')
            ->setCampaignId($campaign->id)
            ->setRegionIds([225])
            ->setDynamicTextAdGroup(
                DynamicTextAdGroup::make()
                    ->setDomainUrl('yandex.com')
            );

        $adGroup->setSession($session);
        $adGroup->add();

        // ==========================================================================

        self::$checklists->checkModel($adGroup, ['Id' => 'integer']);
        self::$dynamicTextAdGroup_WbMaximumClicks = $adGroup;

        $result = $adGroup->addRelatedAds(
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

        return $adGroup;
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
     * @param AdGroup $adGroup
     * @throws ModelException
     */
    public function testAddRelatedAds_HighestPosition(AdGroup $adGroup)
    {
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
         * @var AdGroup $adGroup
         * @var Result $result
         */
        $result = $adGroup->addRelatedAds($ad);

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
     * @param AdGroup $adGroup
     * @throws ModelException
     */
    public function testGetRelatedAds(AdGroup $adGroup)
    {
        // DEMO =====================================================================

        /**
         * @var AdGroup $adGroup
         * @var Result $result
         */
        $result = $adGroup->getRelatedAds(['Id','TextAd.Title']);

        // ==========================================================================

        self::$checklists->checkResource($result, Ads::class, [
            'Id' => 'integer',
            'TextAd.Title' => 'string'
        ]);
    }

    /**
     * @depends testAddTextAdGroup_HighestPosition
     *
     * @param AdGroup $adGroup
     * @throws ModelException
     * @throws ServiceException
     */
    public function testAddRelatedAudienceTargets(AdGroup $adGroup)
    {
        // DEMO =====================================================================

        /**
         * @var AudienceTarget $audienceTarget
         */
        $audienceTarget = AudienceTarget::make()
            ->setInterestId(42)
            ->setContextBid(20000000);

        /**
         * @var AudienceTarget $audienceTarget
         * @var AdGroup $adGroup
         * @var Result $result
         */
        $result = $adGroup->addRelatedAudienceTargets($audienceTarget);

        // ==========================================================================

        $this->assertEquals(8800, $result->errors->get('0.0.code'));

        $result = self::$fakeSession
            ->getAdGroupsService()
            ->addRelatedAudienceTargets($adGroup->id, $audienceTarget);

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
     * @param AdGroup $adGroup
     * @throws InvalidArgumentException
     * @throws ModelException
     * @throws RuntimeException
     */
    public function testGetRelatedAudienceTargets(AdGroup $adGroup)
    {
        // DEMO =====================================================================

        /**
         * @var AdGroup $adGroup
         * @var Result $result
         */
        $result = $adGroup->getRelatedAudienceTargets(['Id','AdGroupId','State']);

        // ==========================================================================

        self::$checklists->checkResource($result, AudienceTargets::class);

        $result = self::$fakeSession
            ->getAdGroupsService()
            ->getRelatedAudienceTargets($adGroup->id, []);

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
     * @param AdGroup $adGroup
     * @throws ModelException
     */
    public function testSetRelatedBids(AdGroup $adGroup)
    {
        // DEMO =====================================================================

        /**
         * @var AdGroup $adGroup
         * @var Result $result
         */
        $result = $adGroup->setRelatedBids(30000000, 10000000);


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
     * @param AdGroup $adGroup
     * @throws ModelException
     */
    public function testSetRelatedContextBids(AdGroup $adGroup)
    {
        // DEMO =====================================================================

        /**
         * @var AdGroup $adGroup
         * @var Result $result
         */
        $result = $adGroup->setRelatedContextBids(10000000);

        // ==========================================================================

        self::$checklists->checkResource($result, Bids::class, [
            'AdGroupId' => 'integer',
            'ContextBid' => 'integer'
        ]);
    }

    /**
     * @depends testAddTextAdGroup_WbMaximumClicks
     *
     * @param AdGroup $adGroup
     * @throws ModelException
     */
    public function testSetRelatedStrategyPriority(AdGroup $adGroup)
    {
        // DEMO =====================================================================

        /**
         * @var AdGroup $adGroup
         * @var Result $result
         */
        $result = $adGroup->setRelatedStrategyPriority('LOW');


        // ==========================================================================

        self::$checklists->checkResource($result, Bids::class, [
            'AdGroupId' => 'integer',
            'StrategyPriority' => 'string'
        ]);
    }

    /**
     * @depends testAddTextAdGroup_HighestPosition
     *
     * @param AdGroup $adGroup
     * @throws ModelException
     */
    public function testSetRelatedBidsAuto(AdGroup $adGroup)
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
         * @var AdGroup $adGroup
         * @var Result $result
         */
        $result = $adGroup->setRelatedBidsAuto($bidAuto);

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
     * @param AdGroup $adGroup
     * @throws ModelException
     */
    public function testGetRelatedBids(AdGroup $adGroup)
    {
        // DEMO =====================================================================

        /**
         * @var AdGroup $adGroup
         * @var Result $result
         */
        $result = $adGroup->getRelatedBids(['Bid','CampaignId','AdGroupId','KeywordId']);

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
     * @param AdGroup $adGroup
     * @throws ModelException
     */
    public function testAddRelatedBidModifiers(AdGroup $adGroup)
    {
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
         * @var AdGroup $adGroup
         * @var Result $result
         */
        $result = $adGroup->addRelatedBidModifiers($bidModifier);

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
     * @param AdGroup $adGroup
     * @throws ModelException
     */
    public function testGetRelatedBidModifiers(AdGroup $adGroup)
    {
        // DEMO =====================================================================

        /**
         * @var AdGroup $adGroup
         * @var Result $result
         */
        $result = $adGroup->getRelatedBidModifiers([
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
     * @param AdGroup $adGroup
     * @throws ModelException
     */
    public function testDisableBidModifiers(AdGroup $adGroup)
    {
        // DEMO =====================================================================

        /**
         * @var AdGroup $adGroup
         * @var Result $result
         */
        $result = $adGroup->disableBidModifiers('DEMOGRAPHICS_ADJUSTMENT');

        // ==========================================================================

        self::$checklists->checkResource($result, BidModifierToggles::class);
    }

    /**
     * @depends testAddTextAdGroup_HighestPosition
     * @depends testDisableBidModifiers
     *
     * @param AdGroup $adGroup
     * @throws ModelException
     */
    public function testEnableBidModifiers(AdGroup $adGroup)
    {
        // DEMO =====================================================================

        /**
         * @var AdGroup $adGroup
         * @var Result $result
         */
        $result = $adGroup->enableBidModifiers('DEMOGRAPHICS_ADJUSTMENT');

        // ==========================================================================

        self::$checklists->checkResource($result, BidModifierToggles::class);
    }

    /**
     * @depends testAddTextAdGroup_HighestPosition
     *
     * @param AdGroup $adGroup
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     */
    public function testAddRelatedKeywords(AdGroup $adGroup)
    {
        // DEMO =====================================================================

        /**
         * @var AdGroup $adGroup
         * @var Result $result
         */
        $result = $adGroup->addRelatedKeywords(
            Keywords::make(
                Keyword::make()->setKeyword('yandex direct -api'),
                Keyword::make()->setKeyword('yandex sdk -direct -api')
            )
        );

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
     * @param AdGroup $adGroup
     * @throws ModelException
     */
    public function testGetRelatedKeywords(AdGroup $adGroup)
    {
        // DEMO =====================================================================

        /**
         * @var Result $result
         * @var AdGroup $adGroup
         */
        $result = $adGroup->getRelatedKeywords(['Id','Keyword','Status']);

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
     * @param AdGroup $adGroup
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     */
    public function testAddRelatedWebpages(AdGroup $adGroup)
    {
        // DEMO =====================================================================

        /**
         * @var AdGroup $adGroup
         * @var Result $result
         */
        $result = $adGroup->addRelatedWebpages(
            Webpage::make()
                ->setName('MyTargetingCondition')
                ->setConditions(
                    WebpageConditions::make(
                        WebpageCondition::domainContain(['mysite.com']),
                        WebpageCondition::pageNotContain(['home','main'])
                    )
                )
        );

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
     * @param AdGroup $adGroup
     * @throws ModelException
     */
    public function testGetRelatedWebpages(AdGroup $adGroup)
    {
        // DEMO =====================================================================

        /**
         * @var Result $result
         * @var AdGroup $adGroup
         */
        $result = $adGroup->getRelatedWebpages(['Id','Name','CampaignId','AdGroupId']);

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
     * @param AdGroup $adGroup
     * @throws ModelException
     */
    public function testUpdateTextAdGroup_HighestPosition(AdGroup $adGroup)
    {
        // DEMO =====================================================================

        /**
         * @var AdGroup $adGroup
         */
        $adGroup
            ->setName('MyAdGroup')
            ->setNegativeKeywords(['set','negative','keywords'])
            ->setTrackingParams('from=direct&ad={ad_id}');

        /**
         * @var AdGroup $adGroup
         * @var Result $result
         */
        $result = $adGroup->update();

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

        $adGroup = AdGroup::make()
            ->setName('MyAdGroup')
            ->setCampaignId($campaign->id)
            ->setRegionIds([225]);

        $adGroup
            ->setSession($session)
            ->add();

        // DEMO =====================================================================

        /**
         * @var AdGroup $adGroup
         */
        $result = $adGroup->delete();

        // ==========================================================================

        self::$checklists->checkResult($result);
    }
}