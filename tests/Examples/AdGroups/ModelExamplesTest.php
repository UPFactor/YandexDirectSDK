<?php

namespace YandexDirectSDKTest\Examples\AdGroups;

use PHPUnit\Framework\TestCase;
use UPTools\Arr;
use YandexDirectSDK\Collections\AdGroups;
use YandexDirectSDK\Collections\Ads;
use YandexDirectSDK\Models\Ad;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\Campaign;
use YandexDirectSDK\Models\DynamicTextAd;
use YandexDirectSDK\Models\DynamicTextAdGroup;
use YandexDirectSDK\Models\MobileAppAd;
use YandexDirectSDK\Models\MobileAppAdGroup;
use YandexDirectSDK\Models\TextAd;
use YandexDirectSDKTest\Examples\Campaigns\ModelExamplesTest as CampaignsModelExamplesTest;
use YandexDirectSDKTest\Helpers\Checklists;
use YandexDirectSDKTest\Helpers\Env;

class ModelExamplesTest extends TestCase
{
    public static $buffer = [];

    public static function init()
    {
        static::$buffer['TextCampaign'] = CampaignsModelExamplesTest::testAdd_TextCampaign_HighestPosition_MaximumCoverage();
        static::$buffer['DynamicTextCampaign'] = CampaignsModelExamplesTest::testAdd_DynamicTextCampaign_HighestPosition_ServingOff();
        static::$buffer['MobileAppCampaign'] = CampaignsModelExamplesTest::testAdd_MobileAppCampaign_HighestPosition_NetworkDefault();
        static::$buffer['CpmBannerCampaign'] = CampaignsModelExamplesTest::testAdd_CpmBannerCampaign_ServingOff_ManualCpm();
        CampaignsModelExamplesTest::$buffer = [];
    }

    public static function destruct()
    {
        Campaign::find(Arr::map(static::$buffer, function(Campaign $campaign){
            return $campaign->id;
        }))->delete();

        static::$buffer = [];
    }

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
        static::init();
    }

    public static function tearDownAfterClass(): void
    {
        static::destruct();
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Add
     |
     |-------------------------------------------------------------------------------
    */

    public static function testAdd_TextGroup()
    {
        // [ Pre processing ] ==========================================================================================

        $campaign = static::$buffer['TextCampaign'];

        // [ Example ] =================================================================================================

        $adGroup = AdGroup::make()
            ->setName('TextGroup')
            ->setCampaignId($campaign->id)
            ->setRegionIds([225])
            ->setNegativeKeywords(['set','negative','keywords'])
            ->setTrackingParams('from=direct&ad={ad_id}');

        $result = $adGroup->add();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, AdGroups::class, [
            'Id' => 'required|integer',
            'CampaignId' => 'required|integer',
            'Name' => 'required|string',
            'RegionIds' => 'required|array_of:integer',
            'NegativeKeywords.Items' => 'required|array_of:string',
            'TrackingParams' => 'required|string'
        ]);

        return $adGroup;
    }

    public static function testAdd_DynamicTextAdGroup()
    {
        // [ Pre processing ] ==========================================================================================

        $campaign = static::$buffer['DynamicTextCampaign'];

        // [ Example ] =================================================================================================

        $adGroup = AdGroup::make()
            ->setName('DynamicTextAdGroup')
            ->setCampaignId($campaign->id)
            ->setRegionIds([225])
            ->setNegativeKeywords(['set','negative','keywords'])
            ->setTrackingParams('from=direct&ad={ad_id}')
            ->setDynamicTextAdGroup(
                DynamicTextAdGroup::make()
                    ->setDomainUrl('yandex.ru')
            );

        $result = $adGroup->add();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, AdGroups::class, [
            'Id' => 'required|integer',
            'CampaignId' => 'required|integer',
            'Name' => 'required|string',
            'RegionIds' => 'required|array_of:integer',
            'NegativeKeywords.Items' => 'required|array_of:string',
            'TrackingParams' => 'required|string',
            'DynamicTextAdGroup.DomainUrl' => 'required|string'
        ]);

        return $adGroup;
    }

    public static function testAdd_MobileAppAdGroup()
    {
        // [ Pre processing ] ==========================================================================================

        $campaign = static::$buffer['MobileAppCampaign'];

        // [ Example ] =================================================================================================

        $adGroup = AdGroup::make()
            ->setName('MobileAppAdGroup')
            ->setCampaignId($campaign->id)
            ->setRegionIds([225])
            ->setNegativeKeywords(['set','negative','keywords'])
            ->setTrackingParams('from=direct&ad={ad_id}')
            ->setMobileAppAdGroup(
                MobileAppAdGroup::make()
                    ->setStoreUrl('https://play.google.com/store/apps/details?id=ru.yandex.direct')
                    ->setTargetDeviceType(['DEVICE_TYPE_MOBILE','DEVICE_TYPE_TABLET'])
                    ->setTargetCarrier('WI_FI_AND_CELLULAR')
                    ->setTargetOperatingSystemVersion('2.3')
            );

        $result = $adGroup->add();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, AdGroups::class, [
            'Id' => 'required|integer',
            'CampaignId' => 'required|integer',
            'Name' => 'required|string',
            'RegionIds' => 'required|array_of:integer',
            'NegativeKeywords.Items' => 'required|array_of:string',
            'TrackingParams' => 'required|string',
            'MobileAppAdGroup.StoreUrl' => 'required|string',
            'MobileAppAdGroup.TargetDeviceType.Items.*' => 'required|string',
            'MobileAppAdGroup.TargetCarrier' => 'required|string',
            'MobileAppAdGroup.TargetOperatingSystemVersion' => 'required|string'
        ]);

        return $adGroup;
    }

    public static function testAdd_CpmBannerKeywordsAdGroup()
    {
        // [ Pre processing ] ==========================================================================================

        $campaign = static::$buffer['CpmBannerCampaign'];

        // [ Example ] =================================================================================================

        $adGroup = AdGroup::make()
            ->setName('CpmBannerKeywordsAdGroup')
            ->setCampaignId($campaign->id)
            ->setRegionIds([225])
            ->setNegativeKeywords(['set','negative','keywords'])
            ->setTrackingParams('from=direct&ad={ad_id}')
            ->setCpmBannerKeywordsAdGroup();

        $result = $adGroup->add();

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

        return $adGroup;
    }

    public static function testAdd_CpmBannerUserProfileAdGroup()
    {
        // [ Pre processing ] ==========================================================================================

        $campaign = static::$buffer['CpmBannerCampaign'];

        // [ Example ] =================================================================================================

        $adGroup = AdGroup::make()
            ->setName('CpmBannerUserProfileAdGroup')
            ->setCampaignId($campaign->id)
            ->setRegionIds([225])
            ->setTrackingParams('from=direct&ad={ad_id}')
            ->setCpmBannerUserProfileAdGroup();

        $result = $adGroup->add();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, AdGroups::class, [
            'Id' => 'required|integer',
            'CampaignId' => 'required|integer',
            'Name' => 'required|string',
            'RegionIds' => 'required|array_of:integer',
            'TrackingParams' => 'required|string',
            'CpmBannerUserProfileAdGroup' => 'required'
        ]);

        return $adGroup;
    }

    public static function testAdd_CpmVideoAdGroup()
    {
        // [ Pre processing ] ==========================================================================================

        $campaign = static::$buffer['CpmBannerCampaign'];

        // [ Example ] =================================================================================================

        $adGroup = AdGroup::make()
            ->setName('CpmVideoAdGroup')
            ->setCampaignId($campaign->id)
            ->setRegionIds([225])
            ->setTrackingParams('from=direct&ad={ad_id}')
            ->setCpmVideoAdGroup();

        $result = $adGroup->add();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, AdGroups::class, [
            'Id' => 'required|integer',
            'CampaignId' => 'required|integer',
            'Name' => 'required|string',
            'RegionIds' => 'required|array_of:integer',
            'TrackingParams' => 'required|string',
            'CpmVideoAdGroup' => 'required'
        ]);

        return $adGroup;
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Getting
     |
     |-------------------------------------------------------------------------------
    */

    public static function testFind():void
    {}

    public static function testQuery():void
    {}

    /*
     |-------------------------------------------------------------------------------
     |
     | Related
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAdd_TextGroup
     * @param AdGroup $adGroup
     */
    public static function testAddRelatedAds_TextGroup(AdGroup $adGroup):void
    {
        $ad = Ad::make()
            ->setTextAd(
                TextAd::make()
                    ->setTitle('My Title')
                    ->setTitle2('My Title2')
                    ->setText('My text')
                    ->setHref('https://mysite.com/page/')
                    ->setMobile('NO')
            );

        $result = $adGroup->addRelatedAds($ad);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Ads::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'TextAd.Title' => 'required|string',
            'TextAd.Title2' => 'required|string',
            'TextAd.Text' => 'required|string',
            'TextAd.Mobile' => 'required|string'
        ]);
    }

    /**
     * @depends testAdd_TextGroup
     * @depends testAddRelatedAds_TextGroup
     * @param AdGroup $adGroup
     */
    public static function testGetRelatedAds_TextGroup(AdGroup $adGroup):void
    {
        $result = $adGroup->getRelatedAds([
            'Id',
            'AdGroupId',
            'TextAd.Title',
            'TextAd.Title2'
        ]);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Ads::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'TextAd.Title' => 'required|string',
            'TextAd.Title2' => 'required|string'
        ]);
    }

    /**
     * @depends testAdd_DynamicTextAdGroup
     * @param AdGroup $adGroup
     */
    public static function testAddRelatedAds_DynamicTextAdGroup(AdGroup $adGroup):void
    {
        $ad = Ad::make()
            ->setDynamicTextAd(
                DynamicTextAd::make()
                    ->setText('My text')
            );

        $result = $adGroup->addRelatedAds($ad);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Ads::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'DynamicTextAd.Text' => 'required|string'
        ]);
    }

    /**
     * @depends testAdd_DynamicTextAdGroup
     * @depends testAddRelatedAds_DynamicTextAdGroup
     * @param AdGroup $adGroup
     */
    public static function testGetRelatedAds_DynamicTextAdGroup(AdGroup $adGroup):void
    {
        $result = $adGroup->getRelatedAds([
            'Id',
            'AdGroupId',
            'DynamicTextAd.Text'
        ]);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Ads::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'DynamicTextAd.Text' => 'required|string'
        ]);
    }

    /**
     * @depends testAdd_MobileAppAdGroup
     * @param AdGroup $adGroup
     */
    public static function testAddRelatedAds_MobileAppAdGroup(AdGroup $adGroup):void
    {
        $ad = Ad::make()
            ->setMobileAppAd(
                MobileAppAd::make()
                    ->setAdImage('My Image', '../../Files/img1080x607.png')
                    ->setTitle('My Title')
                    ->setText('My text')
                    ->setAction('INSTALL')
                    ->setAgeLabel('AGE_18')
            );

        $result = $adGroup->addRelatedAds($ad);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Ads::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'MobileAppAd.AdImageHash' => 'required|string',
            'MobileAppAd.Title' => 'required|string',
            'MobileAppAd.Text' => 'required|string',
            'MobileAppAd.Action' => 'required|string',
            'MobileAppAd.AgeLabel' => 'required|string'
        ]);
    }

    /**
     * @depends testAdd_MobileAppAdGroup
     * @depends testAddRelatedAds_MobileAppAdGroup
     * @param AdGroup $adGroup
     */
    public static function testGetRelatedAds_MobileAppAdGroup(AdGroup $adGroup):void
    {
        $result = $adGroup->getRelatedAds([
            'Id',
            'AdGroupId',
            'MobileAppAd.Title',
            'MobileAppAd.Text',
            'MobileAppAd.AdImageHash'
        ]);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Ads::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'MobileAppAd.Title' => 'required|string',
            'MobileAppAd.Text' => 'required|string',
            'MobileAppAd.AdImageHash' => 'required|string'
        ]);
    }

    /**
     * @depends testAdd_CpmBannerKeywordsAdGroup
     * @param AdGroup $adGroup
     */
    public static function testAddRelatedAds_CpmBannerKeywordsAdGroup(AdGroup $adGroup):void
    {}

    /**
     * @depends testAdd_CpmBannerKeywordsAdGroup
     * @depends testAddRelatedAds_CpmBannerKeywordsAdGroup
     * @param AdGroup $adGroup
     */
    public static function tesGetRelatedAds_CpmBannerKeywordsAdGroup(AdGroup $adGroup):void
    {}

    /**
     * @depends testAdd_CpmBannerUserProfileAdGroup
     * @param AdGroup $adGroup
     */
    public static function testAddRelatedAds_CpmBannerUserProfileAdGroup(AdGroup $adGroup):void
    {}

    /**
     * @depends testAdd_CpmBannerUserProfileAdGroup
     * @depends testAddRelatedAds_CpmBannerUserProfileAdGroup
     * @param AdGroup $adGroup
     */
    public static function testGetRelatedAds_CpmBannerUserProfileAdGroup(AdGroup $adGroup):void
    {}

    /**
     * @depends testAdd_CpmVideoAdGroup
     * @param AdGroup $adGroup
     */
    public static function testAddRelatedAds_CpmVideoAdGroup(AdGroup $adGroup):void
    {}

    /**
     * @depends testAdd_CpmVideoAdGroup
     * @depends testAddRelatedAds_CpmVideoAdGroup
     * @param AdGroup $adGroup
     */
    public static function testGetRelatedAds_CpmVideoAdGroup(AdGroup $adGroup):void
    {}

    /**
     * @depends testAddRelatedAds
     * @param AdGroup $adGroup
     */
    public static function testGetRelatedAds(AdGroup $adGroup):void
    {}

    public static function testAddRelatedKeywords():void
    {}

    public static function testGetRelatedKeywords():void
    {}

    public static function testAddRelatedAudienceTargets():void
    {}

    public static function testGetRelatedAudienceTargets():void
    {}

    public static function testSetRelatedBids():void
    {}

    public static function testSetRelatedContextBids():void
    {}

    public static function testSetRelatedStrategyPriority():void
    {}

    public static function testSetRelatedBidsAuto():void
    {}

    public static function testGetRelatedBids():void
    {}

    public static function testAddRelatedBidModifiers():void
    {}

    public static function testGetRelatedBidModifiers():void
    {}

    public static function testDisableBidModifiers():void
    {}

    public static function testEnableBidModifiers():void
    {}

    public static function testAddRelatedWebpages():void
    {}

    public static function testGetRelatedWebpages():void
    {}

    /*
     |-------------------------------------------------------------------------------
     |
     | Update
     |
     |-------------------------------------------------------------------------------
    */

    public static function testUpdateTextAdGroup():void
    {}

    /*
     |-------------------------------------------------------------------------------
     |
     | Delete
     |
     |-------------------------------------------------------------------------------
    */

    public static function testDeleteTextAdGroup():void
    {}
}