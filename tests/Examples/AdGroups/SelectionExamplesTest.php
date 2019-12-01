<?php

namespace YandexDirectSDKTest\Examples\AdGroups;

use PHPUnit\Framework\TestCase;
use UPTools\Arr;
use YandexDirectSDK\Collections\AdGroups;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\Campaign;
use YandexDirectSDKTest\Helpers\Checklists;
use YandexDirectSDKTest\Helpers\Env;

class SelectionExamplesTest extends TestCase
{
    /**
     * @var AdGroup[]
     */
    private static $adGroups = [];

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

        static::$adGroups['TextGroupHPMC'] = CreateExamplesTest::createTextGroup_HighestPosition_MaximumCoverage();
        static::$adGroups['DynamicTextAdGroupMCSO'] = CreateExamplesTest::createDynamicTextAdGroup_WbMaximumClicks_ServingOff();
        static::$adGroups['MobileAppAdGroupHPND'] = CreateExamplesTest::createMobileAppAdGroup_HighestPosition_NetworkDefault();
    }

    /**
     * Destructor
     * @return void
     */
    public static function tearDownAfterClass(): void
    {
        Env::setUpSession();

        Campaign::find(Arr::map(static::$adGroups, function(AdGroup $adGroup){
            return $adGroup->campaignId;
        }))->delete();

        static::$adGroups = [];
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Examples
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @test
     * @return void
     */
    public static function findModel():void
    {
        // [ Pre processing ]

        $id = Arr::first(static::$adGroups)->id;

        // [ Example ]

        $adGroup = AdGroup::find($id, ['Id', 'Name', 'Status']);

        // [ Post processing ]

        Checklists::checkModel($adGroup, AdGroup::class, [
            'Id' => 'required|integer',
            'Name' => 'required|string',
            'Status' => 'required|string'
        ]);
    }

    /**
     * @test
     * @return void
     */
    public static function findModels():void
    {
        // [ Pre processing ]

        $ids = Arr::map(static::$adGroups, function(AdGroup $adGroup){
            return $adGroup->id;
        });

        // [ Example ]

        $adGroups = AdGroup::find($ids, [
            'Id',
            'Name',
            'Type',
            'MobileAppAdGroup.StoreUrl',
            'DynamicTextAdGroup.DomainUrl',
        ]);

        // [ Post processing ]

        Checklists::checkModelCollection($adGroups, AdGroups::class, [
            'Id' => 'required|integer',
            'Name' => 'required|string',
            'Type' => 'required|string',
            'MobileAppAdGroup.StoreUrl' => 'required_if:Type,MOBILE_APP_AD_GROUP|string',
            'DynamicTextAdGroup.DomainUrl' => 'required_if:Type,DYNAMIC_TEXT_AD_GROUP|string'
        ]);
    }

    /**
     * @test
     * @return void
     */
    public static function query():void
    {
        // [ Pre processing ]

        $campaignIds = Arr::map(static::$adGroups, function(AdGroup $adGroup){
            return $adGroup->campaignId;
        });

        // [ Example ]

        $adGroups = AdGroup::query()
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

        // [ Post processing ]

        Checklists::checkModelCollection($adGroups, AdGroups::class, [
            'Id' => 'required|integer',
            'Name' => 'required|string',
            'Type' => 'required|string:TEXT_AD_GROUP,MOBILE_APP_AD_GROUP,DYNAMIC_TEXT_AD_GROUP',
            'Status' => 'required|string:DRAFT',
            'MobileAppAdGroup.StoreUrl' => 'required_if:Type,MOBILE_APP_AD_GROUP|string',
            'DynamicTextAdGroup.DomainUrl' => 'required_if:Type,DYNAMIC_TEXT_AD_GROUP|string'
        ]);
    }

    /**
     * @test
     * @return void
     */
    public static function queryFirst():void
    {
        // [ Pre processing ]

        $campaignIds = Arr::map(static::$adGroups, function(AdGroup $adGroup){
            return $adGroup->campaignId;
        });

        // [ Example ]

        $adGroup = AdGroup::query()
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
            ->first();

        // [ Post processing ]

        Checklists::checkModel($adGroup, AdGroup::class, [
            'Id' => 'required|integer',
            'Name' => 'required|string',
            'Type' => 'required|string:TEXT_AD_GROUP,MOBILE_APP_AD_GROUP,DYNAMIC_TEXT_AD_GROUP',
            'Status' => 'required|string:DRAFT',
            'MobileAppAdGroup.StoreUrl' => 'required_if:Type,MOBILE_APP_AD_GROUP|string',
            'DynamicTextAdGroup.DomainUrl' => 'required_if:Type,DYNAMIC_TEXT_AD_GROUP|string'
        ]);
    }
}