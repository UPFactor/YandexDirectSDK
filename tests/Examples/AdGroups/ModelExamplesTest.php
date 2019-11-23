<?php

namespace YandexDirectSDKTest\Examples\AdGroups;

use PHPUnit\Framework\TestCase;
use UPTools\Arr;
use YandexDirectSDK\Collections\AdGroups;
use YandexDirectSDK\Collections\Ads;
use YandexDirectSDK\Collections\AudienceTargets;
use YandexDirectSDK\Collections\BidModifiers;
use YandexDirectSDK\Collections\BidModifierToggles;
use YandexDirectSDK\Collections\Bids;
use YandexDirectSDK\Collections\BidsAuto;
use YandexDirectSDK\Collections\Keywords;
use YandexDirectSDK\Collections\TrackingPixels;
use YandexDirectSDK\Collections\WebpageConditions;
use YandexDirectSDK\Collections\Webpages;
use YandexDirectSDK\Models\Ad;
use YandexDirectSDK\Models\AdBuilderAd;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\AudienceTarget;
use YandexDirectSDK\Models\BidAuto;
use YandexDirectSDK\Models\BidModifier;
use YandexDirectSDK\Models\Campaign;
use YandexDirectSDK\Models\CpcVideoAdBuilderAd;
use YandexDirectSDK\Models\CpmBannerAdBuilderAd;
use YandexDirectSDK\Models\CpmVideoAdBuilderAd;
use YandexDirectSDK\Models\DemographicsAdjustment;
use YandexDirectSDK\Models\DynamicTextAd;
use YandexDirectSDK\Models\DynamicTextAdGroup;
use YandexDirectSDK\Models\Keyword;
use YandexDirectSDK\Models\MobileAppAd;
use YandexDirectSDK\Models\MobileAppAdBuilderAd;
use YandexDirectSDK\Models\MobileAppAdGroup;
use YandexDirectSDK\Models\MobileAppImageAd;
use YandexDirectSDK\Models\TextAd;
use YandexDirectSDK\Models\TextAdBuilderAd;
use YandexDirectSDK\Models\TextImageAd;
use YandexDirectSDK\Models\TrackingPixel;
use YandexDirectSDK\Models\Webpage;
use YandexDirectSDK\Models\WebpageCondition;
use YandexDirectSDKTest\Examples\Campaigns\ModelExamplesTest as CampaignsModelExamplesTest;
use YandexDirectSDKTest\Helpers\Checklists;
use YandexDirectSDKTest\Helpers\Env;

class ModelExamplesTest extends TestCase
{
    /**
     * @var Campaign[]
     */
    public static $campaigns = [];

    /**
     * @var AdGroup[]
     */
    public static $adGroups = [];

    public static function init()
    {
        static::$campaigns['TextCampaign_HighestPosition_MaximumCoverage'] = CampaignsModelExamplesTest::testAdd_TextCampaign_HighestPosition_MaximumCoverage();
        static::$campaigns['TextCampaign_WbMaximumClicks_NetworkDefault'] = CampaignsModelExamplesTest::testAdd_TextCampaign_WbMaximumClicks_NetworkDefault();
        static::$campaigns['DynamicTextCampaign_WbMaximumClicks_ServingOff'] = CampaignsModelExamplesTest::testAdd_DynamicTextCampaign_WbMaximumClicks_ServingOff();
        static::$campaigns['MobileAppCampaign_HighestPosition_NetworkDefault'] = CampaignsModelExamplesTest::testAdd_MobileAppCampaign_HighestPosition_NetworkDefault();
        static::$campaigns['CpmBannerCampaign_ServingOff_ManualCpm'] = CampaignsModelExamplesTest::testAdd_CpmBannerCampaign_ServingOff_ManualCpm();
        CampaignsModelExamplesTest::$campaigns = [];
    }

    public static function destruct()
    {
        Campaign::find(Arr::map(static::$campaigns, function(Campaign $campaign){
            return $campaign->id;
        }))->delete();

        static::$campaigns = [];
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

    public static function testAdd_TextGroup():AdGroup
    {
        // [ Pre processing ] ==========================================================================================

        $campaign = static::$campaigns['TextCampaign_HighestPosition_MaximumCoverage'];

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

        static::$adGroups['TextGroup_WbMaximumClicks_NetworkDefault'] = AdGroup::make()
            ->setName('TextGroup')
            ->setCampaignId(static::$campaigns['TextCampaign_WbMaximumClicks_NetworkDefault']->id)
            ->setRegionIds([225])
            ->setNegativeKeywords(['set','negative','keywords'])
            ->setTrackingParams('from=direct&ad={ad_id}');

        Checklists::checkResource(static::$adGroups['TextGroup_WbMaximumClicks_NetworkDefault']->add(),AdGroups::class, [
            'Id' => 'required|integer',
            'CampaignId' => 'required|integer',
            'Name' => 'required|string',
            'RegionIds' => 'required|array_of:integer',
            'NegativeKeywords.Items' => 'required|array_of:string',
            'TrackingParams' => 'required|string'
        ]);

        return static::$adGroups['TextGroup_HighestPosition_MaximumCoverage'] = $adGroup;
    }

    public static function testAdd_DynamicTextAdGroup():AdGroup
    {
        // [ Pre processing ] ==========================================================================================

        $campaign = static::$campaigns['DynamicTextCampaign_WbMaximumClicks_ServingOff'];

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

        return static::$adGroups['DynamicTextAdGroup_WbMaximumClicks_ServingOff'] = $adGroup;
    }

    public static function testAdd_MobileAppAdGroup():AdGroup
    {
        // [ Pre processing ] ==========================================================================================

        $campaign = static::$campaigns['MobileAppCampaign_HighestPosition_NetworkDefault'];

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

        return static::$adGroups['MobileAppAdGroup_HighestPosition_NetworkDefault'] = $adGroup;
    }

    public static function testAdd_CpmBannerKeywordsAdGroup():AdGroup
    {
        // [ Pre processing ] ==========================================================================================

        $campaign = static::$campaigns['CpmBannerCampaign_ServingOff_ManualCpm'];

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

        return static::$adGroups['CpmBannerKeywordsAdGroup_ServingOff_ManualCpm'] = $adGroup;
    }

    public static function testAdd_CpmBannerUserProfileAdGroup():AdGroup
    {
        // [ Pre processing ] ==========================================================================================

        $campaign = static::$campaigns['CpmBannerCampaign_ServingOff_ManualCpm'];

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

        return static::$adGroups['CpmBannerUserProfileAdGroup_ServingOff_ManualCpm'] = $adGroup;
    }

    public static function testAdd_CpmVideoAdGroup():AdGroup
    {
        // [ Pre processing ] ==========================================================================================

        $campaign = static::$campaigns['CpmBannerCampaign_ServingOff_ManualCpm'];

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

        return static::$adGroups['CpmVideoAdGroup_ServingOff_ManualCpm'] = $adGroup;
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Getting
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAdd_TextGroup
     * @depends testAdd_DynamicTextAdGroup
     * @depends testAdd_MobileAppAdGroup
     */
    public static function testFind():void
    {
        // [ Pre processing ] ==========================================================================================

        $id = static::$adGroups['TextGroup_HighestPosition_MaximumCoverage']->id;

        $ids = Arr::map(static::$adGroups, function(AdGroup $adGroup){
            return $adGroup->id;
        });

        // [ Example ] =================================================================================================

        /**
         * @var integer $id
         * @var AdGroup $adGroup
         */
        $adGroup = AdGroup::find($id, ['Id', 'Name', 'Status']);

        // [ Example ] =================================================================================================

        /**
         * @var integer[] $id
         * @var AdGroups $adGroups
         */
        $adGroups = AdGroup::find($ids, [
            'Id',
            'Name',
            'Type',
            'MobileAppAdGroup.StoreUrl',
            'DynamicTextAdGroup.DomainUrl',
        ]);

        // [ Post processing ] =========================================================================================

        Checklists::checkModel($adGroup, [
            'Id' => 'required|integer',
            'Name' => 'required|string',
            'Status' => 'required|string'
        ]);

        Checklists::checkModelCollection($adGroups, [
            'Id' => 'required|integer',
            'Name' => 'required|string',
            'Type' => 'required|string',
            'MobileAppAdGroup.StoreUrl' => 'required_if:Type,MOBILE_APP_AD_GROUP|string',
            'DynamicTextAdGroup.DomainUrl' => 'required_if:Type,DYNAMIC_TEXT_AD_GROUP|string'
        ]);
    }

    /**
     * @depends testAdd_TextGroup
     * @depends testAdd_DynamicTextAdGroup
     * @depends testAdd_MobileAppAdGroup
     */
    public static function testQuery():void
    {
        // [ Pre processing ] ==========================================================================================

        $campaignIds = Arr::map(static::$campaigns, function(Campaign $campaign){
            return $campaign->id;
        });

        // [ Example ] =================================================================================================

        $result = AdGroup::query()
            ->select([
                'Id',
                'Name',
                'CampaignId',
                'Type',
                'Status',
                'MobileAppAdGroup.StoreUrl',
                'DynamicTextAdGroup.DomainUrl'
            ])
            ->whereIn('CampaignIds', $campaignIds)
            ->whereIn('Types', ['TEXT_AD_GROUP', 'MOBILE_APP_AD_GROUP', 'DYNAMIC_TEXT_AD_GROUP'])
            ->whereIn('Statuses', 'DRAFT')
            ->get();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, AdGroups::class, [
            'Id' => 'required|integer',
            'Name' => 'required|string',
            'Type' => 'required|string:TEXT_AD_GROUP,MOBILE_APP_AD_GROUP,DYNAMIC_TEXT_AD_GROUP',
            'Status' => 'required|string:DRAFT',
            'MobileAppAdGroup.StoreUrl' => 'required_if:Type,MOBILE_APP_AD_GROUP|string',
            'DynamicTextAdGroup.DomainUrl' => 'required_if:Type,DYNAMIC_TEXT_AD_GROUP|string'
        ]);
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Related
     |
     |-------------------------------------------------------------------------------
    */

    /*
     | Add related ads
     | -------------------------------------------------------------------------------
     */

    /**
     * @depends testAdd_TextGroup
     * @param AdGroup $adGroup
     */
    public static function testAddRelatedAds_TextGroup_TextAd(AdGroup $adGroup):void
    {
        // [ Pre processing ] ==========================================================================================

        $imgLocalPath = Env::getFilesPath('img1080x607.png');

        // [ Example ] =================================================================================================

        $ad = Ad::make()
            ->setTextAd(
                TextAd::make()
                    ->setTitle('My Title')
                    ->setTitle2('My Title2')
                    ->setText('My text')
                    ->setHref('https://mysite.com/page/')
                    ->setMobile('NO')
                    ->setAdImage('TextAd Image', $imgLocalPath)
            );

        $result = $adGroup->addRelatedAds($ad);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Ads::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'TextAd' => 'required|array',
            'TextAd.Title' => 'required|string',
            'TextAd.Title2' => 'required|string',
            'TextAd.Text' => 'required|string',
            'TextAd.Mobile' => 'required|string',
            'TextAd.AdImageHash' => 'required|string'
        ]);

        Checklists::checkResource(static::$adGroups['TextGroup_WbMaximumClicks_NetworkDefault']->addRelatedAds($ad), Ads::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'TextAd' => 'required|array',
            'TextAd.Title' => 'required|string',
            'TextAd.Title2' => 'required|string',
            'TextAd.Text' => 'required|string',
            'TextAd.Mobile' => 'required|string',
            'TextAd.AdImageHash' => 'required|string'
        ]);
    }

    /**
     * @depends testAdd_TextGroup
     * @param AdGroup $adGroup
     */
    public static function testAddRelatedAds_TextGroup_TextImageAd(AdGroup $adGroup):void
    {
        // [ Pre processing ] ==========================================================================================

        $imgLocalPath = Env::getFilesPath('img240x400.png');

        // [ Example ] =================================================================================================

        $ad = Ad::make()
            ->setTextImageAd(
                TextImageAd::make()
                    ->setHref('https://mysite.com/page/')
                    ->setAdImage('TextAd Image', $imgLocalPath)
            );

        $result = $adGroup->addRelatedAds($ad);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Ads::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'TextImageAd.AdImageHash' => 'required|string',
            'TextImageAd.Href' => 'required|string'
        ]);

        Checklists::checkResource(static::$adGroups['TextGroup_WbMaximumClicks_NetworkDefault']->addRelatedAds($ad), Ads::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'TextImageAd.AdImageHash' => 'required|string',
            'TextImageAd.Href' => 'required|string'
        ]);
    }

    /**
     * @depends testAdd_TextGroup
     * @param AdGroup $adGroup
     */
    public static function testAddRelatedAds_TextGroup_TextAdBuilderAd(AdGroup $adGroup):void
    {
        $ad = Ad::make()
            ->setTextAdBuilderAd(
                TextAdBuilderAd::make()
                    ->setCreative(
                        AdBuilderAd::make()->setCreativeId('1234567')
                    )
                    ->setHref('https://mysite.com/page/')
            );

        $result = $adGroup->addRelatedAds($ad);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource(
            $result,
            Ads::class,
            [
                'TextAdBuilderAd.Creative.CreativeId' => 'required|integer',
                'TextAdBuilderAd.Href' => 'required|string'
            ],
            null,
            [
                '0' => 'required|array|size:1',
                '0.0.code' => 'required|integer:8800'
            ]
        );
    }

    /**
     * @depends testAdd_TextGroup
     * @param AdGroup $adGroup
     */
    public static function testAddRelatedAds_TextGroup_CpcVideoAdBuilderAd(AdGroup $adGroup):void
    {
        $ad = Ad::make()
            ->setCpcVideoAdBuilderAd(
                CpcVideoAdBuilderAd::make()
                    ->setHref('https://mysite.com/page/')
                    ->setCreative(
                        AdBuilderAd::make()->setCreativeId('1234567')
                    )
            );

        $result = $adGroup->addRelatedAds($ad);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource(
            $result,
            Ads::class,
            [
                'CpcVideoAdBuilderAd.Href' => 'required',
                'CpcVideoAdBuilderAd.Creative.CreativeId' => 'required|integer'
            ],
            null,
            [
                '0' => 'required|array|size:1',
                '0.0.code' => 'required|integer:8800'
            ]
        );
    }

    /**
     * @depends testAdd_DynamicTextAdGroup
     * @param AdGroup $adGroup
     */
    public static function testAddRelatedAds_DynamicTextAdGroup_DynamicTextAd(AdGroup $adGroup):void
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
     * @depends testAdd_MobileAppAdGroup
     * @param AdGroup $adGroup
     */
    public static function testAddRelatedAds_MobileAppAdGroup_MobileAppAd(AdGroup $adGroup):void
    {
        // [ Pre processing ] ==========================================================================================

        $imgLocalPath = Env::getFilesPath('img1080x607.png');

        // [ Example ] =================================================================================================

        $ad = Ad::make()
            ->setMobileAppAd(
                MobileAppAd::make()
                    ->setTitle('My Title')
                    ->setText('My text')
                    ->setAction('INSTALL')
                    ->setAgeLabel('AGE_18')
                    ->setAdImage('MobileAppAd Image', $imgLocalPath)
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
     * @param AdGroup $adGroup
     */
    public static function testAddRelatedAds_MobileAppAdGroup_MobileAppImageAd(AdGroup $adGroup):void
    {
        // [ Pre processing ] ==========================================================================================

        $imgLocalPath = Env::getFilesPath('img240x400.png');

        // [ Example ] =================================================================================================

        $ad = Ad::make()
            ->setMobileAppImageAd(
                MobileAppImageAd::make()
                    ->setAdImage('MobileAppAd Image', $imgLocalPath)
            );

        $result = $adGroup->addRelatedAds($ad);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Ads::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'MobileAppImageAd.AdImageHash' => 'required|string'
        ]);
    }

    /**
     * @depends testAdd_MobileAppAdGroup
     * @param AdGroup $adGroup
     */
    public static function testAddRelatedAds_MobileAppAdGroup_MobileAppAdBuilderAd(AdGroup $adGroup):void
    {
        $ad = Ad::make()
            ->setMobileAppAdBuilderAd(
                MobileAppAdBuilderAd::make()
                    ->setCreative(
                        AdBuilderAd::make()->setCreativeId('1234567')
                    )
            );

        $result = $adGroup->addRelatedAds($ad);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource(
            $result,
            Ads::class,
            [
                'MobileAppAdBuilderAd.Creative.CreativeId' => 'required|integer'
            ],
            null,
            [
                '0' => 'required|array|size:1',
                '0.0.code' => 'required|integer:8800'
            ]
        );
    }

    /**
     * @depends testAdd_CpmBannerKeywordsAdGroup
     * @param AdGroup $adGroup
     */
    public static function testAddRelatedAds_CpmBannerKeywordsAdGroup_CpmBannerAdBuilderAd(AdGroup $adGroup):void
    {
        $ad = Ad::make()
            ->setCpmBannerAdBuilderAd(
                CpmBannerAdBuilderAd::make()
                    ->setHref('https://mysite.com/page/')
                    ->setTrackingPixels(
                        TrackingPixels::make(
                            TrackingPixel::make()
                                ->setTrackingPixel('https://mc.yandex.ru/pixel/12345678901234567890?md=%aw_random%')
                        )
                    )
                    ->setCreative(
                        AdBuilderAd::make()->setCreativeId('1234567')
                    )
            );

        $result = $adGroup->addRelatedAds($ad);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource(
            $result,
            Ads::class,
            [
                'CpmBannerAdBuilderAd.Href' => 'required',
                'CpmBannerAdBuilderAd.TrackingPixels.Items' => 'required|array',
                'CpmBannerAdBuilderAd.TrackingPixels.Items.*.TrackingPixel' => 'string',
                'CpmBannerAdBuilderAd.Creative.CreativeId' => 'required|integer'
            ],
            null,
            [
                '0' => 'required|array|size:1',
                '0.0.code' => 'required|integer:8800'
            ]
        );
    }

    /**
     * @depends testAdd_CpmBannerUserProfileAdGroup
     * @param AdGroup $adGroup
     */
    public static function testAddRelatedAds_CpmBannerUserProfileAdGroup_CpmBannerAdBuilderAd(AdGroup $adGroup):void
    {
        $ad = Ad::make()
            ->setCpmBannerAdBuilderAd(
                CpmBannerAdBuilderAd::make()
                    ->setHref('https://mysite.com/page/')
                    ->setTrackingPixels(
                        TrackingPixels::make(
                            TrackingPixel::make()
                                ->setTrackingPixel('https://mc.yandex.ru/pixel/12345678901234567890?md=%aw_random%')
                        )
                    )
                    ->setCreative(
                        AdBuilderAd::make()->setCreativeId('1234567')
                    )
            );

        $result = $adGroup->addRelatedAds($ad);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource(
            $result,
            Ads::class,
            [
                'CpmBannerAdBuilderAd.Href' => 'required',
                'CpmBannerAdBuilderAd.TrackingPixels.Items' => 'required|array',
                'CpmBannerAdBuilderAd.TrackingPixels.Items.*.TrackingPixel' => 'string',
                'CpmBannerAdBuilderAd.Creative.CreativeId' => 'required|integer'
            ],
            null,
            [
                '0' => 'required|array|size:1',
                '0.0.code' => 'required|integer:8800'
            ]
        );
    }

    /**
     * @depends testAdd_CpmVideoAdGroup
     * @param AdGroup $adGroup
     */
    public static function testAddRelatedAds_CpmVideoAdGroup_CpmVideoAdBuilderAd(AdGroup $adGroup):void
    {
        $ad = Ad::make()
            ->setCpmVideoAdBuilderAd(
                CpmVideoAdBuilderAd::make()
                    ->setHref('https://mysite.com/page/')
                    ->setTrackingPixels(
                        TrackingPixels::make(
                            TrackingPixel::make()
                                ->setTrackingPixel('https://mc.yandex.ru/pixel/12345678901234567890?md=%aw_random%')
                        )
                    )
                    ->setCreative(
                        AdBuilderAd::make()->setCreativeId('1234567')
                    )
            );

        $result = $adGroup->addRelatedAds($ad);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource(
            $result,
            Ads::class,
            [
                'CpmVideoAdBuilderAd.Href' => 'required',
                'CpmVideoAdBuilderAd.TrackingPixels.Items' => 'required|array',
                'CpmVideoAdBuilderAd.TrackingPixels.Items.*.TrackingPixel' => 'string',
                'CpmVideoAdBuilderAd.Creative.CreativeId' => 'required|integer'
            ],
            null,
            [
                '0' => 'required|array|size:1',
                '0.0.code' => 'required|integer:8800'
            ]
        );
    }

    /*
     | Get related ads
     | -------------------------------------------------------------------------------
     */

    /**
     * @depends testAdd_TextGroup
     * @depends testAddRelatedAds_TextGroup_TextAd
     * @param AdGroup $adGroup
     */
    public static function testGetRelatedAds_TextGroup(AdGroup $adGroup):void
    {
        $result = $adGroup->getRelatedAds([
            'Id',
            'AdGroupId',
            'Type',
            'TextAd.Title',
            'TextAd.Title2',
            'TextAd.Text'
        ]);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Ads::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'Type' => 'required|string',
            'TextAd' => 'required_if:Type,TEXT_AD|array',
            'TextAd.Title' => 'required_if:Type,TEXT_AD|string',
            'TextAd.Title2' => 'required_if:Type,TEXT_AD|string',
            'TextAd.Text' => 'required_if:Type,TEXT_AD|string',
        ]);
    }

    /**
     * @depends testAdd_DynamicTextAdGroup
     * @depends testAddRelatedAds_DynamicTextAdGroup_DynamicTextAd
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
     * @depends testAddRelatedAds_MobileAppAdGroup_MobileAppAd
     * @param AdGroup $adGroup
     */
    public static function testGetRelatedAds_MobileAppAdGroup(AdGroup $adGroup):void
    {
        $result = $adGroup->getRelatedAds([
            'Id',
            'AdGroupId',
            'Type',
            'MobileAppAd.Title',
            'MobileAppAd.Text',
        ]);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Ads::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'Type' => 'required|string',
            'MobileAppAd' => 'required_if:Type,MOBILE_APP_AD|array',
            'MobileAppAd.Title' => 'required_if:Type,MOBILE_APP_AD|string',
            'MobileAppAd.Text' => 'required_if:Type,MOBILE_APP_AD|string'
        ]);
    }

    /**
     * @depends testAdd_CpmBannerKeywordsAdGroup
     * @depends testAddRelatedAds_CpmBannerKeywordsAdGroup_CpmBannerAdBuilderAd
     * @param AdGroup $adGroup
     */
    public static function testGetRelatedAds_CpmBannerKeywordsAdGroup(AdGroup $adGroup):void
    {
        $result = $adGroup->getRelatedAds([
            'Id',
            'AdGroupId',
            'CpmBannerAdBuilderAd.Href',
            'CpmBannerAdBuilderAd.TrackingPixels',
            'CpmBannerAdBuilderAd.Creative',
        ]);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Ads::class);
        static::assertTrue($result->data->isEmpty());
    }

    /**
     * @depends testAdd_CpmBannerUserProfileAdGroup
     * @depends testAddRelatedAds_CpmBannerUserProfileAdGroup_CpmBannerAdBuilderAd
     * @param AdGroup $adGroup
     */
    public static function testGetRelatedAds_CpmBannerUserProfileAdGroup(AdGroup $adGroup):void
    {
        $result = $adGroup->getRelatedAds([
            'Id',
            'AdGroupId',
            'CpmBannerAdBuilderAd.Href',
            'CpmBannerAdBuilderAd.TrackingPixels',
            'CpmBannerAdBuilderAd.Creative',
        ]);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Ads::class);
        static::assertTrue($result->data->isEmpty());
    }

    /**
     * @depends testAdd_CpmVideoAdGroup
     * @depends testAddRelatedAds_CpmVideoAdGroup_CpmVideoAdBuilderAd
     * @param AdGroup $adGroup
     */
    public static function testGetRelatedAds_CpmVideoAdGroup(AdGroup $adGroup):void
    {
        $result = $adGroup->getRelatedAds([
            'Id',
            'AdGroupId',
            'CpmBannerAdBuilderAd.Href',
            'CpmBannerAdBuilderAd.TrackingPixels',
            'CpmBannerAdBuilderAd.Creative',
        ]);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Ads::class);
        static::assertTrue($result->data->isEmpty());
    }

    /*
     | Add related keywords
     | -------------------------------------------------------------------------------
     */

    /**
     * @depends testAdd_TextGroup
     * @depends testAddRelatedAds_TextGroup_TextAd
     * @param AdGroup $adGroup
     */
    public static function testAddRelatedKeywords_TextGroup(AdGroup $adGroup):void
    {
        // [ Pre processing ] ==========================================================================================

        $adGroup2 = static::$adGroups['TextGroup_WbMaximumClicks_NetworkDefault'];

        // [ Example ] =================================================================================================

        $result = $adGroup->addRelatedKeywords(
            Keywords::make(
                Keyword::make()
                    ->setBid(10000000)
                    ->setContextBid(5000000)
                    ->setUserParam1('param1-by-keyword-1')
                    ->setUserParam2('param2-by-keyword-1')
                    ->setKeyword('yandex direct -api'),
                Keyword::make()
                    ->setBid(11000000)
                    ->setContextBid(6000000)
                    ->setUserParam1('param1-by-keyword-2')
                    ->setUserParam2('param2-by-keyword-2')
                    ->setKeyword('yandex sdk -direct -api')
            )
        );

        // [ Example ] =================================================================================================

        $result2 = $adGroup2->addRelatedKeywords(
            Keywords::makeByList(['yandex direct -api','yandex sdk -direct -api'])
        );

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Keywords::class, [
            'Id' => 'required|integer',
            'Bid' => 'required|integer',
            'ContextBid' => 'required|integer',
            'UserParam1' => 'required|string',
            'UserParam2' => 'required|string',
            'Keyword' => 'required|string'
        ]);

        Checklists::checkResource($result2, Keywords::class, [
            'Id' => 'required|integer',
            'Keyword' => 'required|string'
        ]);
    }

    /**
     * @depends testAdd_MobileAppAdGroup
     * @depends testAddRelatedAds_MobileAppAdGroup_MobileAppAd
     * @param AdGroup $adGroup
     */
    public static function testAddRelatedKeywords_MobileAppAdGroup(AdGroup $adGroup):void
    {
        $result = $adGroup->addRelatedKeywords(
            Keywords::make(
                Keyword::make()
                    ->setUserParam1('param1-by-keyword-1')
                    ->setUserParam2('param2-by-keyword-1')
                    ->setKeyword('yandex direct -api'),
                Keyword::make()
                    ->setUserParam1('param1-by-keyword-2')
                    ->setUserParam2('param2-by-keyword-2')
                    ->setKeyword('yandex sdk -direct -api')
            )
        );

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Keywords::class, [
            'Id' => 'required|integer',
            'UserParam1' => 'required|string',
            'UserParam2' => 'required|string',
            'Keyword' => 'required|string'
        ]);
    }

    /**
     * @depends testAdd_CpmBannerKeywordsAdGroup
     * @depends testAddRelatedAds_CpmBannerKeywordsAdGroup_CpmBannerAdBuilderAd
     * @param AdGroup $adGroup
     */
    public static function testAddRelatedKeywords_CpmBannerKeywordsAdGroup(AdGroup $adGroup):void
    {
        $result = $adGroup->addRelatedKeywords(
            Keywords::make(
                Keyword::make()
                    ->setUserParam1('param1-by-keyword-1')
                    ->setUserParam2('param2-by-keyword-1')
                    ->setKeyword('yandex direct -api'),
                Keyword::make()
                    ->setUserParam1('param1-by-keyword-2')
                    ->setUserParam2('param2-by-keyword-2')
                    ->setKeyword('yandex sdk -direct -api')
            )
        );

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Keywords::class, [
            'Id' => 'required|integer',
            'UserParam1' => 'required|string',
            'UserParam2' => 'required|string',
            'Keyword' => 'required|string'
        ]);
    }

    /*
     | Get related keywords
     | -------------------------------------------------------------------------------
     */

    /**
     * @depends testAdd_TextGroup
     * @depends testAddRelatedKeywords_TextGroup
     * @param AdGroup $adGroup
     */
    public static function testGetRelatedKeywords_TextGroup(AdGroup $adGroup):void
    {
        $result = $adGroup->getRelatedKeywords([
            'Id',
            'Bid',
            'ContextBid',
            'UserParam1',
            'UserParam2',
            'Keyword',
            'Status'
        ]);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Keywords::class, [
            'Id' => 'required|integer',
            'Bid' => 'required|integer',
            'ContextBid' => 'required|integer',
            'UserParam1' => 'required|string',
            'UserParam2' => 'required|string',
            'Keyword' => 'required|string',
            'Status' => 'required|string'
        ]);
    }

    /**
     * @depends testAdd_TextGroup
     * @depends testAddRelatedKeywords_MobileAppAdGroup
     * @param AdGroup $adGroup
     */
    public static function testGetRelatedKeywords_MobileAppAdGroup(AdGroup $adGroup):void
    {
        $result = $adGroup->getRelatedKeywords(['Id','Keyword','Status']);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Keywords::class, [
            'Id' => 'required|integer',
            'Keyword' => 'required|string',
            'Status' => 'required|string'
        ]);
    }

    /**
     * @depends testAdd_TextGroup
     * @depends testAddRelatedKeywords_CpmBannerKeywordsAdGroup
     * @param AdGroup $adGroup
     */
    public static function testGetRelatedKeywords_CpmBannerKeywordsAdGroup(AdGroup $adGroup):void
    {
        $result = $adGroup->getRelatedKeywords(['Id','Keyword','Status']);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Keywords::class, [
            'Id' => 'required|integer',
            'Keyword' => 'required|string',
            'Status' => 'required|string'
        ]);
    }

    /*
     | Related audience targets
     | -------------------------------------------------------------------------------
     */

    /**
     * @depends testAdd_TextGroup
     * @param AdGroup $adGroup
     */
    public static function testAddRelatedAudienceTargets(AdGroup $adGroup):void
    {
        $result = $adGroup->addRelatedAudienceTargets(
            AudienceTarget::make()
                ->setInterestId(42)
                ->setContextBid(20000000)
        );

        // [ Post processing ] =========================================================================================

        Checklists::checkResource(
            $result,
            AudienceTargets::class,
            [
                'InterestId' => 'required|integer',
                'ContextBid' => 'required|integer'
            ],
            null,
            [
                '0' => 'required|array|size:1',
                '0.0.code' => 'required|integer:8800'
            ]
        );
    }

    /**
     * @depends testAdd_TextGroup
     * @depends testAddRelatedAudienceTargets
     * @param AdGroup $adGroup
     */
    public static function testGetRelatedAudienceTargets(AdGroup $adGroup):void
    {
        $result = $adGroup->getRelatedAudienceTargets([
            'Id',
            'AdGroupId',
            'InterestId',
            'ContextBid',
            'State'
        ]);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, AudienceTargets::class);
        static::assertTrue($result->data->isEmpty());
    }

    /*
     | Related bids
     | -------------------------------------------------------------------------------
     */

    /**
     * @depends testAdd_TextGroup
     * @depends testAddRelatedKeywords_TextGroup
     * @param AdGroup $adGroup
     */
    public static function testSetRelatedBids(AdGroup $adGroup):void
    {
        $result = $adGroup->setRelatedBids(30000000, 10000000);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Bids::class, [
            'AdGroupId' => 'required|integer',
            'Bid' => 'required|integer',
            'ContextBid' => 'required|integer'
        ]);
    }

    /**
     * @depends testAdd_TextGroup
     * @depends testAddRelatedKeywords_TextGroup
     * @param AdGroup $adGroup
     */
    public static function testSetRelatedContextBids(AdGroup $adGroup):void
    {
        $result = $adGroup->setRelatedContextBids(10000000);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Bids::class, [
            'AdGroupId' => 'required|integer',
            'ContextBid' => 'required|integer'
        ]);
    }

    /**
     * @depends testAdd_TextGroup
     * @depends testAddRelatedKeywords_TextGroup
     */
    public static function testSetRelatedStrategyPriority():void
    {
        // [ Pre processing ] ==========================================================================================

        $adGroup = static::$adGroups['TextGroup_WbMaximumClicks_NetworkDefault'];

        // [ Example ] =================================================================================================

        $result = $adGroup->setRelatedStrategyPriority('HIGH');

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Bids::class, [
            'AdGroupId' => 'required|integer',
            'StrategyPriority' => 'required|string'
        ]);
    }

    /**
     * @depends testAdd_TextGroup
     * @depends testAddRelatedKeywords_TextGroup
     * @param AdGroup $adGroup
     */
    public static function testSetRelatedBidsAuto(AdGroup $adGroup):void
    {
        $result = $adGroup->setRelatedBidsAuto(
            BidAuto::make()
                ->setScope(['SEARCH'])
                ->setPosition('PREMIUMBLOCK')
        );

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, BidsAuto::class, [
            'AdGroupId' => 'required|integer',
            'Scope' => 'required|array',
            'Position' => 'string'
        ]);
    }

    /**
     * @depends testAdd_TextGroup
     * @depends testSetRelatedBids
     * @param AdGroup $adGroup
     */
    public static function testGetRelatedBids(AdGroup $adGroup):void
    {
        $result = $adGroup->getRelatedBids(['Bid','CampaignId','AdGroupId','KeywordId']);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Bids::class, [
            'Bid' => 'required|integer',
            'CampaignId' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'KeywordId' => 'required|integer'
        ]);
    }

    /*
     | Related bid modifiers
     | -------------------------------------------------------------------------------
     */

    /**
     * @depends testAdd_TextGroup
     * @depends testAddRelatedKeywords_TextGroup
     * @param AdGroup $adGroup
     */
    public static function testAddRelatedBidModifiers(AdGroup $adGroup):void
    {
        $bidModifier = BidModifier::make()
            ->setDemographicsAdjustment(
                DemographicsAdjustment::make()
                    ->setAge('AGE_18_24')
                    ->setGender('GENDER_FEMALE')
                    ->setBidModifier(50)
            );

        $result = $adGroup->addRelatedBidModifiers($bidModifier);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, BidModifiers::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'DemographicsAdjustment.Age' => 'required|string',
            'DemographicsAdjustment.Gender' => 'required|string',
            'DemographicsAdjustment.BidModifier' => 'required|integer',
        ]);
    }

    /**
     * @depends testAdd_TextGroup
     * @depends testAddRelatedBidModifiers
     * @param AdGroup $adGroup
     */
    public static function testGetRelatedBidModifiers(AdGroup $adGroup):void
    {
        $result = $adGroup->getRelatedBidModifiers([
            'Id',
            'CampaignId',
            'AdGroupId',
            'DemographicsAdjustment.Age',
            'DemographicsAdjustment.Gender',
            'DemographicsAdjustment.BidModifier'
        ]);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, BidModifiers::class, [
            'Id' => 'required|integer',
            'CampaignId' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'DemographicsAdjustment.Age' => 'required|string',
            'DemographicsAdjustment.Gender' => 'required|string',
            'DemographicsAdjustment.BidModifier' => 'required|integer',
        ]);
    }

    /**
     * @depends testAdd_TextGroup
     * @depends testAddRelatedBidModifiers
     * @param AdGroup $adGroup
     */
    public static function testDisableBidModifiers(AdGroup $adGroup):void
    {
        $result = $adGroup->disableBidModifiers('DEMOGRAPHICS_ADJUSTMENT');

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, BidModifierToggles::class);
        sleep(10);
    }

    /**
     * @depends testAdd_TextGroup
     * @depends testDisableBidModifiers
     * @param AdGroup $adGroup
     */
    public static function testEnableBidModifiers(AdGroup $adGroup):void
    {
        $result = $adGroup->enableBidModifiers('DEMOGRAPHICS_ADJUSTMENT');

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, BidModifierToggles::class);
        sleep(10);
    }

    /*
     | Related webpages
     | -------------------------------------------------------------------------------
     */

    /**
     * @depends testAdd_DynamicTextAdGroup
     * @param AdGroup $adGroup
     */
    public static function testAddRelatedWebpages(AdGroup $adGroup):void
    {
        $result = $adGroup->addRelatedWebpages(
            Webpage::make()
                ->setName('MyTargetingCondition')
                ->setConditions(
                    WebpageConditions::make(
                        WebpageCondition::domainContain(['mysite.com']),
                        WebpageCondition::pageNotContain(['home', 'main'])
                    )
                )
        );

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Webpages::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'Name' => 'string',
            'Conditions' => 'required|size:2',
            'Conditions.*.Operand' => 'required|string',
            'Conditions.*.Operator' => 'required|string',
            'Conditions.*.Arguments' => 'required|array_of:string'
        ]);
    }

    /**
     * @depends testAdd_DynamicTextAdGroup
     * @depends testAddRelatedWebpages
     * @param AdGroup $adGroup
     */
    public static function testGetRelatedWebpages(AdGroup $adGroup):void
    {
        $result = $adGroup->getRelatedWebpages([
            'Id',
            'Name',
            'CampaignId',
            'AdGroupId',
            'Conditions'
        ]);

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Webpages::class, [
            'Id' => 'required|integer',
            'CampaignId' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'Name' => 'string',
            'Conditions' => 'required|size:2',
            'Conditions.*.Operand' => 'required|string',
            'Conditions.*.Operator' => 'required|string',
            'Conditions.*.Arguments' => 'required|array_of:string'
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
     * @depends testAdd_MobileAppAdGroup
     * @param AdGroup $adGroup
     */
    public static function testUpdateTextAdGroup(AdGroup $adGroup):void
    {
        $adGroup
            ->setName('MyAdGroup')
            ->setNegativeKeywords(['new','negative','keyword'])
            ->setTrackingParams('from=yandex-direct&ad={ad_id}')
            ->mobileAppAdGroup
                ->setTargetDeviceType(['DEVICE_TYPE_MOBILE'])
                ->setTargetCarrier('WI_FI_ONLY');

        $result = $adGroup->update();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, AdGroups::class);
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Delete
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAdd_TextGroup
     * @param AdGroup $adGroup
     */
    public static function testDeleteTextAdGroup(AdGroup $adGroup):void
    {
        // [ Pre processing ] ==========================================================================================

        $adGroupID = $adGroup->id;

        // [ Example ] =================================================================================================

        $result = AdGroup::find($adGroupID)->delete();

        // [ Post processing ] =========================================================================================

        Checklists::checkResult($result);
    }
}