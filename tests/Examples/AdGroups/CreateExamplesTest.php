<?php

namespace YandexDirectSDKTest\Examples\AdGroups;

use PHPUnit\Framework\TestCase;
use UPTools\Arr;
use YandexDirectSDK\Collections\AdGroups;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\Campaign;
use YandexDirectSDK\Models\DynamicTextAdGroup;
use YandexDirectSDK\Models\MobileAppAdGroup;
use YandexDirectSDKTest\Examples\Campaigns\CreateExamplesTest as CampaignCreateExamplesTest;
use YandexDirectSDKTest\Helpers\Checklists;
use YandexDirectSDKTest\Helpers\Env;

class CreateExamplesTest extends TestCase
{
    /**
     * @var Campaign[]
     */
    private static $campaigns = [];

    /*
     |-------------------------------------------------------------------------------
     |
     | Handlers
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * Constructor
     * @return void
     */
    public static function setUpBeforeClass(): void
    {
        Env::setUpSession();
        static::$campaigns = [];
    }

    /**
     * Destructor
     * @return void
     */
    public static function tearDownAfterClass(): void
    {
        Campaign::find(Arr::map(static::$campaigns, function(Campaign $campaign){
            return $campaign->id;
        }))->delete();

        static::$campaigns = [];
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Examples
     |
     |-------------------------------------------------------------------------------
    */

    /*
     | Make
     | -------------------------------------------------------------------------------
     */

    /**
     * @test
     * @return void
     */
    public static function makeTextGroup_HighestPosition_MaximumCoverage():void
    {
        // [ Pre processing ]

        static::$campaigns[] = $campaign = CampaignCreateExamplesTest::createTextCampaign_HighestPosition_MaximumCoverage();

        // [ Example ]

        $adGroup = AdGroup::make([
            'Name' => 'TextGroup',
            'CampaignId' => $campaign->id,
            'RegionIds' => [225],
            'NegativeKeywords' => [
                'Items' => ['set','negative','keywords']
            ],
            'TrackingParams' => 'from=direct&ad={ad_id}'
        ]);

        $result = $adGroup->create();

        // [ Post processing ]

        Checklists::checkResource($result, AdGroups::class, [
            'Id' => 'required|integer',
            'CampaignId' => 'required|integer',
            'Name' => 'required|string',
            'RegionIds' => 'required|array_of:integer',
            'NegativeKeywords.Items' => 'required|array_of:string',
            'TrackingParams' => 'required|string'
        ]);

        $adGroup->delete();
    }

    /**
     * @test
     * @return void
     */
    public static function makeDynamicTextAdGroup_WbMaximumClicks_ServingOff():void
    {
        // [ Pre processing ]

        static::$campaigns[] = $campaign = CampaignCreateExamplesTest::createDynamicTextCampaign_WbMaximumClicks_ServingOff();

        // [ Example ]

        $adGroup = AdGroup::make([
            'Name' => 'DynamicTextAdGroup',
            'CampaignId' => $campaign->id,
            'RegionIds' => [225],
            'NegativeKeywords' => [
                'Items' => ['set','negative','keywords']
            ],
            'TrackingParams' => 'from=direct&ad={ad_id}',
            'DynamicTextAdGroup' => [
                'DomainUrl' => 'yandex.ru'
            ]
        ]);

        $result = $adGroup->create();

        // [ Post processing ]

        Checklists::checkResource($result, AdGroups::class, [
            'Id' => 'required|integer',
            'CampaignId' => 'required|integer',
            'Name' => 'required|string',
            'RegionIds' => 'required|array_of:integer',
            'NegativeKeywords.Items' => 'required|array_of:string',
            'TrackingParams' => 'required|string',
            'DynamicTextAdGroup.DomainUrl' => 'required|string'
        ]);

        $adGroup->delete();
    }

    /**
     * @test
     * @return void
     */
    public static function makeCpmVideoAdGroup_ServingOff_ManualCpm():void
    {
        // [ Pre processing ]

        static::$campaigns[] = $campaign = CampaignCreateExamplesTest::createCpmBannerCampaign_ServingOff_ManualCpm();

        // [ Example ]

        $adGroup = AdGroup::make([
            'Name' => 'CpmVideoAdGroup',
            'CampaignId' => $campaign->id,
            'RegionIds' => [225],
            'TrackingParams' => 'from=direct&ad={ad_id}',
            'CpmVideoAdGroup' => []
        ]);

        $result = $adGroup->create();

        // [ Post processing ]

        Checklists::checkResource($result, AdGroups::class, [
            'Id' => 'required|integer',
            'CampaignId' => 'required|integer',
            'Name' => 'required|string',
            'RegionIds' => 'required|array_of:integer',
            'TrackingParams' => 'required|string',
            'CpmVideoAdGroup' => 'required'
        ]);

        $adGroup->delete();
    }

    /*
     | Create
     | -------------------------------------------------------------------------------
     */

    /**
     * @test
     * @return AdGroup
     */
    public static function createTextGroup_HighestPosition_MaximumCoverage():AdGroup
    {
        // [ Pre processing ]

        static::$campaigns[] = $campaign = CampaignCreateExamplesTest::createTextCampaign_HighestPosition_MaximumCoverage();

        // [ Example ]

        $adGroup = AdGroup::make()
            ->setName('TextGroup')
            ->setCampaignId($campaign->id)
            ->setRegionIds([225])
            ->setNegativeKeywords(['set','negative','keywords'])
            ->setTrackingParams('from=direct&ad={ad_id}');

        $result = $adGroup->create();

        // [ Post processing ]

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

    /**
     * @test
     * @return AdGroup
     */
    public static function createTextGroup_WbMaximumClicks_NetworkDefault():AdGroup
    {
        // [ Pre processing ]

        static::$campaigns[] = $campaign = CampaignCreateExamplesTest::createTextCampaign_WbMaximumClicks_NetworkDefault();

        // [ Example ]

        $adGroup = AdGroup::make()
            ->setName('TextGroup')
            ->setCampaignId($campaign->id)
            ->setRegionIds([225])
            ->setNegativeKeywords(['set','negative','keywords'])
            ->setTrackingParams('from=direct&ad={ad_id}');

        $result = $adGroup->create();

        // [ Post processing ]

        Checklists::checkResource($result,AdGroups::class, [
            'Id' => 'required|integer',
            'CampaignId' => 'required|integer',
            'Name' => 'required|string',
            'RegionIds' => 'required|array_of:integer',
            'NegativeKeywords.Items' => 'required|array_of:string',
            'TrackingParams' => 'required|string'
        ]);

        return $adGroup;
    }

    /**
     * @test
     * @return AdGroup
     */
    public static function createDynamicTextAdGroup_HighestPosition_ServingOff():AdGroup
    {
        // [ Pre processing ]

        static::$campaigns[] = $campaign = CampaignCreateExamplesTest::createDynamicTextCampaign_HighestPosition_ServingOff();

        // [ Example ]

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

        $result = $adGroup->create();

        // [ Post processing ]

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

    /**
     * @test
     * @return AdGroup
     */
    public static function createDynamicTextAdGroup_WbMaximumClicks_ServingOff():AdGroup
    {
        // [ Pre processing ]

        static::$campaigns[] = $campaign = CampaignCreateExamplesTest::createDynamicTextCampaign_WbMaximumClicks_ServingOff();

        // [ Example ]

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

        $result = $adGroup->create();

        // [ Post processing ]

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

    /**
     * @test
     * @return AdGroup
     */
    public static function createMobileAppAdGroup_HighestPosition_NetworkDefault():AdGroup
    {
        // [ Pre processing ]

        static::$campaigns[] = $campaign = CampaignCreateExamplesTest::createMobileAppCampaign_HighestPosition_NetworkDefault();

        // [ Example ]

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

        $result = $adGroup->create();

        // [ Post processing ]

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

    /**
     * @test
     * @return AdGroup
     */
    public static function createCpmBannerKeywordsAdGroup_ServingOff_ManualCpm():AdGroup
    {
        // [ Pre processing ]

        static::$campaigns[] = $campaign = CampaignCreateExamplesTest::createCpmBannerCampaign_ServingOff_ManualCpm();

        // [ Example ]

        $adGroup = AdGroup::make()
            ->setName('CpmBannerKeywordsAdGroup')
            ->setCampaignId($campaign->id)
            ->setRegionIds([225])
            ->setNegativeKeywords(['set','negative','keywords'])
            ->setTrackingParams('from=direct&ad={ad_id}')
            ->setCpmBannerKeywordsAdGroup();

        $result = $adGroup->create();

        // [ Post processing ]

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

    /**
     * @test
     * @return AdGroup
     */
    public static function createCpmBannerUserProfileAdGroup_ServingOff_ManualCpm():AdGroup
    {
        // [ Pre processing ]

        static::$campaigns[] = $campaign = CampaignCreateExamplesTest::createCpmBannerCampaign_ServingOff_ManualCpm();

        // [ Example ]

        $adGroup = AdGroup::make()
            ->setName('CpmBannerUserProfileAdGroup')
            ->setCampaignId($campaign->id)
            ->setRegionIds([225])
            ->setTrackingParams('from=direct&ad={ad_id}')
            ->setCpmBannerUserProfileAdGroup();

        $result = $adGroup->create();

        // [ Post processing ]

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

    /**
     * @test
     * @return AdGroup
     */
    public static function createCpmVideoAdGroup_ServingOff_ManualCpm():AdGroup
    {
        // [ Pre processing ]

        static::$campaigns[] = $campaign = CampaignCreateExamplesTest::createCpmBannerCampaign_ServingOff_ManualCpm();

        // [ Example ]

        $adGroup = AdGroup::make()
            ->setName('CpmVideoAdGroup')
            ->setCampaignId($campaign->id)
            ->setRegionIds([225])
            ->setTrackingParams('from=direct&ad={ad_id}')
            ->setCpmVideoAdGroup();

        $result = $adGroup->create();

        // [ Post processing ]

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
}