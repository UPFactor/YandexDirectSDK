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
use YandexDirectSDK\Collections\WebpageConditions;
use YandexDirectSDK\Collections\Webpages;
use YandexDirectSDK\Components\Data;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\ModelCollectionException;
use YandexDirectSDK\Exceptions\RequestException;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Exceptions\ServiceException;
use YandexDirectSDK\Models\Ad;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\Bid;
use YandexDirectSDK\Models\BidAuto;
use YandexDirectSDK\Models\BidModifier;
use YandexDirectSDK\Models\Campaign;
use YandexDirectSDK\Models\DemographicsAdjustment;
use YandexDirectSDK\Models\DynamicTextAdGroup;
use YandexDirectSDK\Models\Keyword;
use YandexDirectSDK\Models\TextAd;
use YandexDirectSDK\Models\Webpage;
use YandexDirectSDK\Models\WebpageCondition;
use YandexDirectSDK\Session;
use YandexDirectSDKTest\Helpers\SessionTools;

/**
 * Class AdGroupsExamplesTest
 * @package YandexDirectSDKTest\Examples
 */
class AdGroupsExamplesTest extends TestCase
{
    /**
     * @var CampaignsExamplesTest
     */
    public static $campaignsExTest;

    /**
     * @var Session
     */
    public static $session;

    /**
     * @var Campaigns
     */
    public static $textCampaigns;

    /**
     * @var Campaign
     */
    public static $textCampaign;

    /**
     * @var Campaigns
     */
    public static $dynamicTextCampaigns;

    /**
     * @var Campaign
     */
    public static $dynamicTextCampaign;

    /**
     * @return void
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public static function setUpBeforeClass():void
    {
        $campaignsExTest = new CampaignsExamplesTest();
        $campaignsExTest::setUpBeforeClass();

        self::$campaignsExTest = $campaignsExTest;
        self::$session = $campaignsExTest::$session;
        self::$textCampaigns = $campaignsExTest->testAddCampaigns_byService();
        self::$textCampaign = self::$textCampaigns->first();
        self::$dynamicTextCampaigns = $campaignsExTest->testAddDynamicTextCampaigns_byService();
        self::$dynamicTextCampaign = self::$dynamicTextCampaigns->first();
    }

    /**
     * @return void
     */
    public static function tearDownAfterClass():void
    {
        self::$campaignsExTest::tearDownAfterClass();
        self::$textCampaigns->delete();
        self::$dynamicTextCampaigns->delete();

        self::$session = null;
        self::$textCampaigns = null;
        self::$textCampaign = null;
        self::$dynamicTextCampaigns = null;
        self::$dynamicTextCampaign = null;
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Add ad groups
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @return AdGroups
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testAddAdGroup_byService(){

        $session = self::$session;
        $campaign = self::$textCampaign;

        // Demo =====================================================================

        /**
         * Add a AdGroup to Yandex.Direct.
         * @var Session $session
         * @var Campaign $campaign — Campaign model
         * @var Result $result
         */
        $result = $session->getAdGroupsService()->add(
            //Creating a ad group collection and adding a ad group model to it.
            AdGroups::make()->push(
                //Creating a ad group model and setting its properties.
                AdGroup::make()
                    ->setName('MyAdGroup')
                    ->setCampaignId($campaign->id) //Specify the campaign for the group
                    ->setRegionIds([225])
                    ->setNegativeKeywords(['set','negative','keywords'])
                    ->setTrackingParams('from=direct&ad={ad_id}')
            )
            //You can add more ad groups to the collection.
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
         * Convert result to ad groups collection.
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
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(AdGroups::class, $adGroups);

        return $adGroups;
    }

    /**
     * @return AdGroups
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testAddDynamicTextAdGroup_byService(){

        $session = self::$session;
        $campaign = self::$dynamicTextCampaign;

        // Demo =====================================================================

        /**
         * Add a DynamicTextAdGroup to Yandex.Direct.
         * @var Campaign $campaign — Campaign model
         * @var Result $result
         */
        $result = $session->getAdGroupsService()->add(
            AdGroups::make()->push(
                AdGroup::make()
                    ->setName('DynamicTextAdGroup')
                    ->setCampaignId($campaign->id)
                    ->setRegionIds([225])
                    ->setDynamicTextAdGroup(
                        DynamicTextAdGroup::make()->setDomainUrl('mysite.com')
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
         * Convert result to ad groups collection.
         * @var AdGroups $adGroups
         */
        $adGroups = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(AdGroups::class, $adGroups);

        return $adGroups;
    }

    /**
     * @depends testAddAdGroup_byService
     */
    public function testAddAdGroup_byModel(){
        $session = self::$session;
        $campaign = self::$textCampaign;

        // Demo =====================================================================

        /**
         * Create a AdGroup model.
         * @var AdGroup $adGroup
         */
        $adGroup = AdGroup::make()
            ->setName('MyAdGroup')
            ->setCampaignId($campaign->id) //Specify the campaign for the group
            ->setRegionIds([225])
            ->setNegativeKeywords(['set','negative','keywords'])
            ->setTrackingParams('from=direct&ad={ad_id}');

        /**
         * Associate a ad group model with a session.
         * @var Session $session
         */
        $adGroup->setSession($session);

        /**
         * Add a ad group to Yandex.Direct.
         * @var Result $result
         */
        $result = $adGroup->add();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(AdGroup::class, $adGroup);
        $this->assertNotNull($adGroup->id);
    }

    /**
     * @depends testAddAdGroup_byService
     *
     * @return void
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testAddAdGroup_byCollection(){
        $session = self::$session;
        $campaign = self::$textCampaign;

        // Demo =====================================================================

        /**
         * Create an empty collection and connect session.
         * @var Session $session
         * @var AdGroups $adGroups.
         */
        $adGroups = AdGroups::make()->setSession($session);

        /**
         * Add ad group models to the collection.
         */
        $adGroups->push(
            AdGroup::make()
                ->setName('MyAdGroup')
                ->setCampaignId($campaign->id) //Specify the campaign for the group
                ->setRegionIds([225])
                ->setNegativeKeywords(['set','negative','keywords'])
                ->setTrackingParams('from=direct&ad={ad_id}')
        );

        $adGroups->push(
            AdGroup::make()
                ->setName('MyOtherAdGroup')
                ->setCampaignId($campaign->id) //Specify the campaign for the group
                ->setRegionIds([225])
        );

        /**
         * Add an ad groups to Yandex.Direct.
         * @var Result $result
         */
        $result = $adGroups->add();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(AdGroups::class, $adGroups);
        $this->assertNotNull($adGroups->first()->{'id'});
        $this->assertNotNull($adGroups->last()->{'id'});
    }

    /**
     * @depends testAddAdGroup_byService
     *
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function testAddAdGroup_byArray(){
        $session = self::$session;
        $campaign = self::$textCampaign;

        // Demo =====================================================================

        /**
         * Add ad groups to Yandex.Direct.
         * @var Session $session
         * @var Result $result
         */
        $result = $session->getAdGroupsService()->call('add', [
            'AdGroups' => [
                [
                    'Name' => 'MyAdGroup',
                    'CampaignId' => $campaign->id, //Specify the campaign for the group
                    'RegionIds' => [225],
                    'TrackingParams' => 'from=direct&ad={ad_id}',
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
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Get ad groups
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddAdGroup_byService
     *
     * @return AdGroups
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testGetAdGroup_byService(){
        $session = self::$session;
        $campaign = self::$textCampaign;

        // Demo =====================================================================

        /**
         * Getting a list of result.
         * @var Result $result
         */
        $result = $session->getAdGroupsService()->query()
            ->select(
                'Id',
                'Name',
                'RegionIds',
                'MobileAppAdGroup.StoreUrl',
                'MobileAppAdGroup.AppIconModeration'
            )
            ->whereIn('Ids', [$campaign->id])
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
         * Convert result to ad group collection.
         * @var AdGroups $adGroups
         */
        $adGroups = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(AdGroups::class, $adGroups);

        return $adGroups;
    }

    /**
     * @depends testAddAdGroup_byService
     *
     * @return AdGroups
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testGetAdGroup_byModel(){
        $session = self::$session;
        $campaign = self::$textCampaign;

        // Demo =====================================================================

        /**
         * Getting a list of result.
         * @var Result $result
         */
        $result = AdGroup::make()->setSession($session)->query()
            ->select('Id','Name','RegionIds')
            ->whereIn('Ids', [$campaign->id])
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
         * Convert result to ad group collection.
         * @var AdGroups $adGroups
         */
        $adGroups = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(AdGroups::class, $adGroups);

        return $adGroups;
    }

    /**
     * @depends testAddAdGroup_byService
     *
     * @return AdGroups
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws RuntimeException
     */
    public function testGetAdGroup_byCollection(){
        $session = self::$session;
        $campaign = self::$textCampaign;

        // Demo =====================================================================

        /**
         * Getting a list of result.
         * @var Result $result
         */
        $result = AdGroups::make()->setSession($session)->query()
            ->select('Id','Name','RegionIds')
            ->whereIn('Ids', [$campaign->id])
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
         * Convert result to ad group collection.
         * @var AdGroups $adGroups
         */
        $adGroups = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(AdGroups::class, $adGroups);

        return $adGroups;
    }


    /*
     |-------------------------------------------------------------------------------
     |
     | Related objects
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddAdGroup_byService
     *
     * @param AdGroups $adGroups
     * @return Ads
     * @throws ServiceException
     */
    public function testAddRelatedAds_byService(AdGroups $adGroups){
        $session = self::$session;
        $adGroupsIds = $adGroups->extract('id');

        // Demo =====================================================================

        /**
         * Create Ad model.
         * @var Ad $ad
         */
        $ad = Ad::make()
            ->setTextAd(
                TextAd::make()
                    ->setTitle('Title of my ad')
                    ->setTitle2('Title of my second ad')
                    ->setText('My ad text')
                    ->setHref('https://mysite.com/page/')
                    ->setMobile('NO')
            );

        /**
         * Create a new Ad for ad groups with ids [$adGroupsIds].
         * @var Ad $ad
         * @var array $adGroupsIds
         * @var Result $result
         */
        $result = $session
            ->getAdGroupsService()
            ->addRelatedAds($adGroupsIds, $ad);

        /**
         * Convert result to ads collection.
         * @var Ads $ads
         */
        $ads = $result->getResource();

        // End Demo =====================================================================

        $this->assertIsArray($adGroupsIds);
        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Ads::class, $ads);

        return $ads;
    }

    /**
     * @depends testAddAdGroup_byService
     *
     * @param $adGroups
     * @return Ads
     */
    public function testAddRelatedAds_byModel(AdGroups $adGroups){
        $adGroup = $adGroups->first();

        // Demo =====================================================================

        /**
         * Create a new ad for ad group [$adGroup].
         * @var Result $result
         * @var AdGroup $adGroup
         */
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

        /**
         * Convert result to ads collection.
         * @var Ads $ads
         */
        $ads = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Ads::class, $ads);

        return $ads;
    }

    /**
     * @depends testAddAdGroup_byService
     *
     * @param $adGroups
     * @return Ads
     */
    public function testAddRelatedAds_byCollection(AdGroups $adGroups){

        // Demo =====================================================================

        /**
         * Create ad for each ad group in the collection [$adGroups].
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

        /**
         * Convert result to ads collection.
         * @var Ads $ads
         */
        $ads = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Ads::class, $ads);

        return $ads;
    }

    /**
     * @depends testAddAdGroup_byService
     *
     * @param AdGroups $adGroups
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testGetRelatedAds_byService(AdGroups $adGroups){
        $session = self::$session;
        $adGroupsIds = $adGroups->extract('id');

        // Demo =====================================================================

        /**
         * Get Ads by ad groups ids [$adGroupsIds]
         * @var Result $result
         * @var array $adGroupsIds
         */
        $result = $session
            ->getAdGroupsService()
            ->getRelatedAds($adGroupsIds, ['Id','TextAd.Title']);

        /**
         * Convert result to Ads collection.
         * @var Ads $ads
         */
        $ads = $result->getResource();

        // End Demo =====================================================================

        $this->assertIsArray($adGroupsIds);
        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Ads::class, $ads);
    }

    /**
     * @depends testAddAdGroup_byService
     *
     * @param AdGroups $adGroups
     */
    public function testGetRelatedAds_byModel(AdGroups $adGroups){
        $adGroup = $adGroups->first();

        // Demo =====================================================================

        /**
         * Get Ads by adGroup model [$adGroup]
         * @var Result $result
         * @var AdGroup $adGroup
         */
        $result = $adGroup->getRelatedAds(['Id','TextAd.Title']);

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
     * @depends testAddAdGroup_byService
     *
     * @param AdGroups $adGroups
     */
    public function testGetRelatedAds_byCollection(AdGroups $adGroups){
        // Demo =====================================================================

        /**
         * Get Ads by AdGroup collection [$adGroups]
         * @var Result $result
         * @var Campaigns $adGroups
         */
        $result = $adGroups->getRelatedAds(['Id','TextAd.Title']);

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
     * @depends testAddAdGroup_byService
     *
     * @param $adGroups
     */
    public function testAddRelatedAudienceTargets_byService(AdGroups $adGroups){
        $this->markTestIncomplete('Not implemented');
    }

    /**
     * @depends testAddAdGroup_byService
     *
     * @param $adGroups
     */
    public function testAddRelatedAudienceTargets_byModel(AdGroups $adGroups){
        $this->markTestIncomplete('Not implemented');
    }

    /**
     * @depends testAddAdGroup_byService
     *
     * @param $adGroups
     */
    public function testAddRelatedAudienceTargets_byCollection(AdGroups $adGroups){
        $this->markTestIncomplete('Not implemented');
    }

    /**
     * @depends testAddAdGroup_byService
     *
     * @param AdGroups $adGroups
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testGetRelatedAudienceTargets_byService(AdGroups $adGroups){
        $session = self::$session;
        $adGroupsIds = $adGroups->extract('id');

        // Demo =====================================================================

        /**
         * Get AudienceTargets by ad groups ids [$adGroupsIds]
         * @var Result $result
         * @var array $adGroupsIds
         */
        $result = $session
            ->getAdGroupsService()
            ->getRelatedAudienceTargets($adGroupsIds, ['Id','AdGroupId','CampaignId']);

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
     * @depends testAddAdGroup_byService
     *
     * @param $adGroups
     */
    public function testGetRelatedAudienceTargets_byModel(AdGroups $adGroups){
        $adGroup = $adGroups->first();

        // Demo =====================================================================

        /**
         * Get AudienceTargets by adGroup model [$adGroup]
         * @var Result $result
         * @var AdGroup $adGroup
         */
        $result = $adGroup->getRelatedAudienceTargets(['Id','AdGroupId','CampaignId']);

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
     * @depends testAddAdGroup_byService
     *
     * @param $adGroups
     */
    public function testGetRelatedAudienceTargets_byCollection(AdGroups $adGroups){

        // Demo =====================================================================

        /**
         * Get AudienceTargets for all adGroups in the collection [$adGroups]
         * @var Result $result
         * @var AdGroups $adGroups
         */
        $result = $adGroups->getRelatedAudienceTargets(['Id','AdGroupId','CampaignId']);

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
     * @depends testAddAdGroup_byService
     *
     * @param AdGroups $adGroups
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ServiceException
     */
    public function testSetRelatedBids_byService(AdGroups $adGroups){
        $session = self::$session;
        $adGroupsIds = $adGroups->extract('id');

        // Demo =====================================================================

        /**
         * Create Bid model
         * @var Bid $bid
         */
        $bid = Bid::make()
            ->setBid(30000000)
            ->setContextBid(10000000);


        /**
         * Sets the bid and priority for the key phrases of each
         * ad group with ids. [$adGroupsIds]
         * @var Result $result
         * @var array $adGroupsIds
         */
        $result = $session
            ->getAdGroupsService()
            ->setRelatedBids($adGroupsIds, $bid);

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
     * @depends testAddAdGroup_byService
     *
     * @param $adGroups
     */
    public function testSetRelatedBids_byModel(AdGroups $adGroups){
        $adGroup = $adGroups->first();

        // Demo =====================================================================

        /**
         * Sets the bid and priority for the adGroup model. [$adGroup]
         * @var Result $result
         * @var AdGroup $adGroup
         */
        $result = $adGroup->setRelatedBids(
            Bid::make()
                ->setBid(30000000)
                ->setContextBid(10000000)
        );

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
     * @depends testAddAdGroup_byService
     *
     * @param $adGroups
     */
    public function testSetRelatedBids_byCollection(AdGroups $adGroups){

        // Demo =====================================================================

        /**
         * Sets the bid and priority for the key phrases of each ad group
         * in the collection. [$adGroups]
         * @var Result $result
         * @var AdGroups $adGroups
         */
        $result = $adGroups->setRelatedBids(
            Bid::make()
                ->setBid(30000000)
                ->setContextBid(10000000)
        );

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
     * @depends testAddAdGroup_byService
     *
     * @param AdGroups $adGroups
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ServiceException
     */
    public function testSetRelatedBidsAuto_byService(AdGroups $adGroups){
        $session = self::$session;
        $adGroupsIds = $adGroups->extract('id');

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
         * each ad group with ids [$adGroupsIds].
         * @var Result $result
         * @var array $adGroupsIds
         */
        $result = $session
            ->getAdGroupsService()
            ->setRelatedBidsAuto($adGroupsIds, $bidAuto);

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
     * @depends testAddAdGroup_byService
     *
     * @param $adGroups
     */
    public function testSetRelatedBidsAuto_byModel(AdGroups $adGroups){
        $adGroup = $adGroups->first();

        // Demo =====================================================================

        /**
         * Sets the bid constructor options for the adGroup model. [$adGroup]
         * @var Result $result
         * @var AdGroup $adGroup
         */
        $result = $adGroup->setRelatedBidsAuto(
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
     * @depends testAddAdGroup_byService
     *
     * @param $adGroups
     */
    public function testSetRelatedBidsAuto_byCollection(AdGroups $adGroups){

        // Demo =====================================================================

        /**
         * Sets the bid constructor options for the keywords of
         * each ad group in the collection [$adGroups].
         * @var Result $result
         * @var AdGroups $adGroups
         */
        $result = $adGroups->setRelatedBidsAuto(
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
     * @depends testAddAdGroup_byService
     *
     * @param AdGroups $adGroups
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testGetRelatedBids_byService(AdGroups $adGroups){
        $session = self::$session;
        $adGroupIds = $adGroups->extract('id');

        // Demo =====================================================================

        /**
         * Get Bids by ad group ids [$adGroupIds]
         * @var Result $result
         * @var array $adGroupIds
         */
        $result = $session
            ->getAdGroupsService()
            ->getRelatedBids($adGroupIds, ['Bid','AdGroupId','CampaignId']);

        /**
         * Convert result to Bids collection.
         * @var Bids $bids
         */
        $bids = $result->getResource();

        // End Demo =====================================================================

        $this->assertIsArray($adGroupIds);
        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Bids::class, $bids);
    }

    /**
     * @depends testAddAdGroup_byService
     *
     * @param $adGroups
     */
    public function testGetRelatedBids_byModel(AdGroups $adGroups){
        $adGroup = $adGroups->first();

        // Demo =====================================================================

        /**
         * Get Bids by adGroup model [$adGroup]
         * @var Result $result
         * @var AdGroup $adGroup
         */
        $result = $adGroup->getRelatedBids(['Bid','AdGroupId','CampaignId']);

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
     * @depends testAddAdGroup_byService
     *
     * @param $adGroups
     */
    public function testGetRelatedBids_byCollection(AdGroups $adGroups){

        // Demo =====================================================================

        /**
         * Get Bids for all ad group in the collection [$adGroups]
         * @var Result $result
         * @var AdGroups $adGroups
         */
        $result = $adGroups->getRelatedBids(['Bid','AdGroupId','CampaignId']);

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
     * @depends testAddAdGroup_byService
     *
     * @param AdGroups $adGroups
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ServiceException
     * @throws ReflectionException
     */
    public function testAddRelatedBidModifiers_byService(AdGroups $adGroups){
        $session = self::$session;
        $adGroupIds = $adGroups->extract('id');

        // Demo =====================================================================

        /**
         * Create BidModifier Model.
         * @var BidModifier $bidModifier
         */
        $bidModifier = BidModifier::make()->setDemographicsAdjustment(
            DemographicsAdjustment::make()
                ->setAge('AGE_18_24')
                ->setGender('GENDER_FEMALE')
                ->setBidModifier(50)
        );

        /**
         * Sets a new bid modifier for adGroups with ids [$adGroupIds].
         * @var Result $result
         * @var array $adGroupIds
         */
        $result = $session
            ->getAdGroupsService()
            ->addRelatedBidModifiers($adGroupIds, $bidModifier);

        /**
         * Convert result to BidModifiers collection.
         * @var BidModifiers $bidModifiers
         */
        $bidModifiers = $result->getResource();

        // End Demo =================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(BidModifiers::class, $bidModifiers);
    }

    /**
     * @depends testAddAdGroup_byService
     *
     * @param AdGroups $adGroups
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testAddRelatedBidModifiers_byModel(AdGroups $adGroups){
        $adGroup = $adGroups->first();

        // Demo =====================================================================

        /**
         * Sets a new bid modifier for adGroup model [$adGroup].
         * @var AdGroup $adGroup
         * @var Result $result
         */
        $result = $adGroup->addRelatedBidModifiers(
            BidModifier::make()->setDemographicsAdjustment(
                DemographicsAdjustment::make()
                    ->setAge('AGE_0_17')
                    ->setGender('GENDER_FEMALE')
                    ->setBidModifier(50)
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
    }

    /**
     * @depends testAddAdGroup_byService
     *
     * @param AdGroups $adGroups
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testAddRelatedBidModifiers_byCollection(AdGroups $adGroups){

        // Demo =====================================================================

        /**
         * Sets a new bid modifier for ad group collection [$adGroups].
         * @var AdGroups $adGroups
         * @var Result $result
         */
        $result = $adGroups->addRelatedBidModifiers(
            BidModifier::make()->setDemographicsAdjustment(
                DemographicsAdjustment::make()
                    ->setAge('AGE_35_44')
                    ->setGender('GENDER_FEMALE')
                    ->setBidModifier(50)
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
    }

    /**
     * @depends testAddAdGroup_byService
     * @depends testAddRelatedBidModifiers_byService
     *
     * @param AdGroups $adGroups
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testGetRelatedBidModifiers_byService(AdGroups $adGroups){
        $session = self::$session;
        $adGroupIds = $adGroups->extract('id');

        // Demo =====================================================================

        /**
         * Get BidModifiers by ad groups ids [$adGroupIds]
         * @var Result $result
         * @var array $adGroupIds
         */
        $result = $session
            ->getAdGroupsService()
            ->getRelatedBidModifiers($adGroupIds, ['Id','CampaignId','AdGroupId']);

        /**
         * Convert result to BidModifiers collection.
         * @var BidModifiers $bidModifiers
         */
        $bidModifiers = $result->getResource();

        // End Demo =====================================================================

        $this->assertIsArray($adGroupIds);
        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(BidModifiers::class, $bidModifiers);
    }

    /**
     * @depends testAddAdGroup_byService
     * @depends testAddRelatedBidModifiers_byService
     *
     * @param $adGroups
     */
    public function testGetRelatedBidModifiers_byModel(AdGroups $adGroups){
        $adGroup = $adGroups->first();

        // Demo =====================================================================

        /**
         * Get BidModifiers by adGroup model [$adGroup]
         * @var Result $result
         * @var AdGroup $adGroup
         */
        $result = $adGroup->getRelatedBidModifiers(['Id','CampaignId','AdGroupId']);

        /**
         * Convert result to BidModifiers collection.
         * @var BidModifiers $bidModifiers
         */
        $bidModifiers = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(BidModifiers::class, $bidModifiers);
    }

    /**
     * @depends testAddAdGroup_byService
     * @depends testAddRelatedBidModifiers_byService
     *
     * @param $adGroups
     */
    public function testGetRelatedBidModifiers_byCollection(AdGroups $adGroups){

        // Demo =====================================================================

        /**
         * Get BidModifiers by ad group collection [$adGroups]
         * @var Result $result
         * @var AdGroups $adGroups
         */
        $result = $adGroups->getRelatedBidModifiers(['Id','CampaignId','AdGroupId']);

        /**
         * Convert result to BidModifiers collection.
         * @var BidModifiers $bidModifiers
         */
        $bidModifiers = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(BidModifiers::class, $bidModifiers);
    }

    /**
     * @depends testAddAdGroup_byService
     * @depends testAddRelatedBidModifiers_byService
     *
     * @param AdGroups $adGroups
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function testDisableBidModifiers_byService(AdGroups $adGroups){
        $session = SessionTools::init();
        $adGroupIds = $adGroups->extract('id');

        // Demo =====================================================================

        /**
         * Turn off the set of adjustments for adGroups with ids [$adGroupIds].
         * @var Result $result
         * @var array $adGroupIds
         */
        $result = $session
            ->getAdGroupsService()
            ->disableBidModifiers($adGroupIds, 'DEMOGRAPHICS_ADJUSTMENT');

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
     * @depends testAddAdGroup_byService
     * @depends testAddRelatedBidModifiers_byService
     *
     * @param $adGroups
     */
    public function testDisableBidModifiers_byModel(AdGroups $adGroups){
        $adGroup = $adGroups->first();

        // Demo =====================================================================

        /**
         * Turn off the set of adjustments for adGroup model [$adGroup].
         * @var Result $result
         * @var AdGroup $adGroup
         */
        $result = $adGroup->disableBidModifiers('DEMOGRAPHICS_ADJUSTMENT');

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
     * @depends testAddAdGroup_byService
     * @depends testAddRelatedBidModifiers_byService
     *
     * @param $adGroups
     */
    public function testDisableBidModifiers_byCollection(AdGroups $adGroups){

        // Demo =====================================================================

        /**
         * Turn off the set of adjustments for all adGroups in the collection [$adGroups].
         * @var Result $result
         * @var AdGroups $adGroups
         */
        $result = $adGroups->disableBidModifiers('DEMOGRAPHICS_ADJUSTMENT');

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
     * @depends testAddAdGroup_byService
     * @depends testAddRelatedBidModifiers_byService
     *
     * @param AdGroups $adGroups
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function testEnableBidModifiers_byService(AdGroups $adGroups){
        $session = SessionTools::init();
        $adGroupIds = $adGroups->extract('id');

        // Demo =====================================================================

        /**
         * Turn on the set of adjustments for adGroups with ids [$adGroupIds].
         * @var Result $result
         * @var array $adGroupIds
         */
        $result = $session
            ->getAdGroupsService()
            ->enableBidModifiers($adGroupIds, 'DEMOGRAPHICS_ADJUSTMENT');

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
     * @depends testAddAdGroup_byService
     * @depends testAddRelatedBidModifiers_byService
     *
     * @param $adGroups
     */
    public function testEnableBidModifiers_byModel(AdGroups $adGroups){
        $adGroup = $adGroups->first();

        // Demo =====================================================================

        /**
         * Turn on the set of adjustments for adGroup model [$adGroup].
         * @var Result $result
         * @var AdGroup $adGroup
         */
        $result = $adGroup->enableBidModifiers('DEMOGRAPHICS_ADJUSTMENT');

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
     * @depends testAddAdGroup_byService
     * @depends testAddRelatedBidModifiers_byService
     *
     * @param $adGroups
     */
    public function testEnableBidModifiers_byCollection(AdGroups $adGroups){

        // Demo =====================================================================

        /**
         * Turn on the set of adjustments for all adGroups in the collection [$adGroups].
         * @var Result $result
         * @var AdGroups $adGroups
         */
        $result = $adGroups->enableBidModifiers('DEMOGRAPHICS_ADJUSTMENT');

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
     * @depends testAddAdGroup_byService
     *
     * @param AdGroups $adGroups
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ServiceException
     */
    public function testAddRelatedKeywords_byService(AdGroups $adGroups){
        $session = self::$session;
        $adGroupIds = $adGroups->extract('id');

        // Demo =====================================================================

        /**
         * Set keywords for ad groups with ids [$adGroupIds].
         * @var Result $result
         * @var array $adGroupIds
         */
        $result = $session
            ->getAdGroupsService()
            ->addRelatedKeywords($adGroupIds, Keywords::make(
                Keyword::make()->setKeyword('yandex direct -api'),
                Keyword::make()->setKeyword('yandex sdk -direct -api')
            ));

        /**
         * Convert result to keyword collection.
         * @var Keywords $keywords
         */
        $keywords = $result->getResource();

        // End Demo =================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Keywords::class, $keywords);

        $keywords->delete();
    }

    /**
     * @depends testAddAdGroup_byService
     *
     * @param AdGroups $adGroups
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testAddRelatedKeywords_byModel(AdGroups $adGroups){
        $adGroup = $adGroups->first();

        // Demo =====================================================================

        /**
         * Sets keywords for adGroup model [$adGroup].
         * @var AdGroup $adGroup
         * @var Result $result
         */
        $result = $adGroup->addRelatedKeywords(Keywords::make(
            Keyword::make()->setKeyword('yandex direct -api'),
            Keyword::make()->setKeyword('yandex sdk -direct -api')
        ));

        /**
         * Convert result to keyword collection.
         * @var Keywords $keywords
         */
        $keywords = $result->getResource();

        // End Demo =================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Keywords::class, $keywords);

        $keywords->delete();
    }

    /**
     * @depends testAddAdGroup_byService
     *
     * @param AdGroups $adGroups
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testAddRelatedKeywords_byCollection(AdGroups $adGroups){

        // Demo =====================================================================

        /**
         * Sets keywords for each group in the collection [$adGroups].
         * @var AdGroups $adGroups
         * @var Result $result
         */
        $result = $adGroups->addRelatedKeywords(Keywords::make(
            Keyword::make()->setKeyword('yandex direct -api'),
            Keyword::make()->setKeyword('yandex sdk -direct -api')
        ));

        /**
         * Convert result to keyword collection.
         * @var Keywords $keywords
         */
        $keywords = $result->getResource();

        // End Demo =================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Keywords::class, $keywords);

        $keywords->delete();
    }

    /**
     * @depends testAddAdGroup_byService
     *
     * @param AdGroups $adGroups
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testGetRelatedKeywords_byService(AdGroups $adGroups){
        $session = SessionTools::init();
        $adGroupIds = $adGroups->extract('id');

        // Demo =====================================================================

        /**
         * Get Keywords by ad group ids [$adGroupIds]
         * @var Result $result
         * @var array $adGroupIds
         */
        $result = $session
            ->getAdGroupsService()
            ->getRelatedKeywords($adGroupIds, ['Id','Keyword','Status']);

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
     * @depends testAddAdGroup_byService
     *
     * @param $adGroups
     */
    public function testGetRelatedKeywords_byModel(AdGroups $adGroups){
        $adGroup = $adGroups->first();

        // Demo =====================================================================

        /**
         * Get Keywords by adGroup model [$adGroup]
         * @var Result $result
         * @var AdGroup $adGroup
         */
        $result = $adGroup->getRelatedKeywords(['Id','Keyword','Status']);

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
     * @depends testAddAdGroup_byService
     *
     * @param $adGroups
     */
    public function testGetRelatedKeywords_byCollection(AdGroups $adGroups){

        // Demo =====================================================================

        /**
         * Get Keywords for all adGroups in the collection [$adGroups]
         * @var Result $result
         * @var AdGroups $adGroups
         */
        $result = $adGroups->getRelatedKeywords(['Id','Keyword','Status']);

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
     * @depends testAddDynamicTextAdGroup_byService
     *
     * @param AdGroups $adGroups
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ServiceException
     */
    public function testAddRelatedWebpages_byService(AdGroups $adGroups){
        $session = self::$session;
        $adGroupIds = $adGroups->extract('id');

        // Demo =====================================================================

        /**
         * Set targeting conditions for dynamic ads in groups
         * with ids [$adGroupIds].
         *
         * @var Result $result
         * @var array $adGroupIds
         */
        $result = $session
            ->getAdGroupsService()
            ->addRelatedWebpages($adGroupIds, Webpage::make()
                ->setName('MyTargetingCondition')
                ->setConditions(
                    WebpageConditions::make(
                        WebpageCondition::domainContain(['mysite.com']),
                        WebpageCondition::pageNotContain(['home','main'])
                    )
                ));

        /**
         * Convert result to Webpages collection.
         * @var Webpages $webpages
         */
        $webpages = $result->getResource();

        // End Demo =================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Webpages::class, $webpages);

        $webpages->delete();
    }

    /**
     * @depends testAddDynamicTextAdGroup_byService
     *
     * @param AdGroups $adGroups
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testAddRelatedWebpages_byModel(AdGroups $adGroups){
        $adGroup = $adGroups->first();

        // Demo =====================================================================

        /**
         * Set targeting conditions for dynamic announcements of
         * a given ad group model [$adGroup].
         *
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

        /**
         * Convert result to Webpages collection.
         * @var Webpages $webpages
         */
        $webpages = $result->getResource();

        // End Demo =================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Webpages::class, $webpages);

        $webpages->delete();
    }

    /**
     * @depends testAddDynamicTextAdGroup_byService
     *
     * @param AdGroups $adGroups
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testAddDynamicTextAdGroup_byService_byCollection(AdGroups $adGroups){

        // Demo =====================================================================

        /**
         * Set targeting conditions for dynamic announcements of
         * a given ad group collection [$adGroups].
         *
         * @var AdGroups $adGroups
         * @var Result $result
         */
        $result = $adGroups->addRelatedWebpages(
            Webpage::make()
                ->setName('MyTargetingCondition')
                ->setConditions(
                    WebpageConditions::make(
                        WebpageCondition::domainContain(['mysite.com']),
                        WebpageCondition::pageNotContain(['home','main'])
                    )
                )
        );

        /**
         * Convert result to Webpages collection.
         * @var Webpages $webpages
         */
        $webpages = $result->getResource();

        // End Demo =================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Webpages::class, $webpages);

        $webpages->delete();
    }

    /**
     * @depends testAddAdGroup_byService
     *
     * @param AdGroups $adGroups
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testGetRelatedWebpages_byService(AdGroups $adGroups){
        $session = SessionTools::init();
        $adGroupIds = $adGroups->extract('id');

        // Demo =====================================================================

        /**
         * Get parameters targeting dynamic ads for all adGroups with ids [$adGroupIds].
         * @var Result $result
         * @var array $adGroupIds
         */
        $result = $session
            ->getAdGroupsService()
            ->getRelatedWebpages($adGroupIds, ['AdGroupId','Bid','CampaignId']);

        /**
         * Convert result to Webpages collection.
         * @var Webpages $webpages
         */
        $webpages = $result->getResource();

        // End Demo =====================================================================

        $this->assertIsArray($adGroupIds);
        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Webpages::class, $webpages);
    }

    /**
     * @depends testAddAdGroup_byService
     *
     * @param $adGroups
     */
    public function testGetRelatedWebpages_byModel(AdGroups $adGroups){
        $adGroup = $adGroups->first();

        // Demo =====================================================================

        /**
         * Get parameters targeting dynamic ads for adGroup model [$adGroup].
         * @var Result $result
         * @var AdGroup $adGroup
         */
        $result = $adGroup->getRelatedWebpages(['AdGroupId','Bid','CampaignId']);

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
     * @depends testAddAdGroup_byService
     *
     * @param $adGroups
     */
    public function testGetRelatedWebpages_byCollection(AdGroups $adGroups){

        // Demo =====================================================================

        /**
         * Get parameters targeting dynamic ads for all adGroups
         * in the collection [$adGroups].
         * @var Result $result
         * @var AdGroups $adGroups
         */
        $result = $adGroups->getRelatedWebpages(['AdGroupId','Bid','CampaignId']);

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
     | Update ad groups
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddAdGroup_byService
     *
     * @param AdGroups $adGroups
     */
    public function testUpdateAdGroup_byService(AdGroups $adGroups){
        $session = SessionTools::init();

        // Demo =====================================================================

        /**
         * Get the first ad group from the collection.
         * @var AdGroups $adGroups - Ad group collection
         * @var AdGroup $adGroup - Ad group model
         */
        $adGroup = $adGroups->first();

        /**
         * Edit ad group properties.
         * @var AdGroup $adGroup
         */
        $adGroup
            ->setName('Another name')
            ->setNegativeKeywords(['negative', 'keywords']);

        /**
         * Saving changes to Yandex.Direct.
         * @var Result $result
         */
        $result = $session
            ->getAdGroupsService()
            ->update($adGroup);

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
    }

    /**
     * @depends testAddAdGroup_byService
     *
     * @param AdGroups $adGroups
     */
    public function testUpdateCampaigns_byModel(AdGroups $adGroups){

        // Demo =====================================================================

        /**
         * Get the first ad group from the collection.
         * @var AdGroups $adGroups - Ad group collection
         * @var AdGroup $adGroup - Ad group model
         */
        $adGroup = $adGroups->first();

        /**
         * Edit ad group properties and saving changes to Yandex.Direct.
         * @var AdGroup $adGroup
         * @var Result $result
         */
        $result = $adGroup
            ->setName('Another name')
            ->setNegativeKeywords(['negative', 'keywords'])
            ->update();

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
     * @depends testAddDynamicTextAdGroup_byService
     *
     * @param AdGroups $adGroups
     */
    public function testDeleteAdGroup(AdGroups $adGroups){

        /**
         * @var AdGroups $adGroups
         */
        $result = $adGroups->delete();

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
    }
}