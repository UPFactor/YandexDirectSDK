<?php

namespace YandexDirectSDKTest\Examples\Campaigns;

use PHPUnit\Framework\TestCase;
use UPTools\Arr;
use YandexDirectSDK\Collections\Campaigns;
use YandexDirectSDK\Models\Campaign;
use YandexDirectSDKTest\Helpers\Checklists;
use YandexDirectSDKTest\Helpers\Env;

class SelectionExamplesTest extends TestCase
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

    public static function setUpBeforeClass(): void
    {
        Env::setUpSession();

        static::$campaigns['TextCampaignHPMC'] = CreateExamplesTest::createTextCampaign_HighestPosition_MaximumCoverage();
        static::$campaigns['DynamicTextCampaignHPSO'] = CreateExamplesTest::createDynamicTextCampaign_HighestPosition_ServingOff();
        static::$campaigns['MobileAppCampaignHPND'] = CreateExamplesTest::createMobileAppCampaign_HighestPosition_NetworkDefault();
        static::$campaigns['CpmBannerCampaignSOMC'] = CreateExamplesTest::createCpmBannerCampaign_ServingOff_ManualCpm();
    }

    /**
     * Destructor
     * @return void
     */
    public static function tearDownAfterClass(): void
    {
        Env::setUpSession();

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

    /**
     * @test
     * @return void
     */
    public static function findModel():void
    {
        // [ Pre processing ]

        $id = Arr::first(static::$campaigns)->id;

        // [ Example ]

        $campaign = Campaign::find($id, ['Id', 'Name', 'State']);

        // [ Post processing ]

        Checklists::checkModel($campaign, Campaign::class, [
            'Id' => 'required|integer',
            'Name' => 'required|string',
            'State' => 'required|string'
        ]);
    }

    /**
     * @test
     * @return void
     */
    public static function findModels():void
    {
        // [ Pre processing ]

        $ids = Arr::map(static::$campaigns, function(Campaign $campaign){
            return $campaign->id;
        });

        // [ Example ]

        $campaigns = Campaign::find($ids, [
            'Id',
            'Name',
            'State',
            'TextCampaign.BiddingStrategy',
            'DynamicTextCampaign.BiddingStrategy',
            'MobileAppCampaign.BiddingStrategy',
            'CpmBannerCampaign.BiddingStrategy'
        ]);

        // [ Post processing ]

        Checklists::checkModelCollection($campaigns, Campaigns::class, [
            'Id' => 'required|integer',
            'Name' => 'required|string',
            'State' => 'required|string',
            'TextCampaign.BiddingStrategy' => 'required_without_all:DynamicTextCampaign,MobileAppCampaign,CpmBannerCampaign|array',
            'DynamicTextCampaign.BiddingStrategy' => 'required_without_all:TextCampaign,MobileAppCampaign,CpmBannerCampaign|array',
            'MobileAppCampaign.BiddingStrategy' => 'required_without_all:TextCampaign,DynamicTextCampaign,CpmBannerCampaign|array',
            'CpmBannerCampaign.BiddingStrategy' => 'required_without_all:TextCampaign,DynamicTextCampaign,MobileAppCampaign|array'
        ]);
    }

    /**
     * @test
     * @return void
     */
    public static function query():void
    {
        $campaigns = Campaign::query()
            ->select([
                'Id',
                'Name',
                'Type',
                'State',
                'TextCampaign.BiddingStrategy',
                'DynamicTextCampaign.BiddingStrategy',
            ])
            ->whereIn('Types', ['TEXT_CAMPAIGN', 'DYNAMIC_TEXT_CAMPAIGN'])
            ->whereIn('States', ['SUSPENDED','OFF'])
            ->get();

        // [ Post processing ]

        Checklists::checkModelCollection($campaigns, Campaigns::class, [
            'Id' => 'required|integer',
            'Name' => 'required|string',
            'Type' => 'required|string:TEXT_CAMPAIGN,DYNAMIC_TEXT_CAMPAIGN',
            'State' => 'required|string:SUSPENDED,OFF',
            'TextCampaign.BiddingStrategy' => 'required_without:DynamicTextCampaign|array',
            'DynamicTextCampaign.BiddingStrategy' => 'required_without:TextCampaign|array',
        ]);
    }

    /**
     * @test
     * @return void
     */
    public static function queryFirst():void
    {
        $campaign = Campaign::query()
            ->select([
                'Id',
                'Name',
                'Type',
                'State',
                'TextCampaign.BiddingStrategy',
                'DynamicTextCampaign.BiddingStrategy',
            ])
            ->whereIn('Types', ['TEXT_CAMPAIGN', 'DYNAMIC_TEXT_CAMPAIGN'])
            ->whereIn('States', ['SUSPENDED','OFF'])
            ->first();

        // [ Post processing ]

        Checklists::checkModel($campaign, Campaign::class, [
            'Id' => 'required|integer',
            'Name' => 'required|string',
            'Type' => 'required|string:TEXT_CAMPAIGN,DYNAMIC_TEXT_CAMPAIGN',
            'State' => 'required|string:SUSPENDED,OFF',
            'TextCampaign.BiddingStrategy' => 'required_without:DynamicTextCampaign|array',
            'DynamicTextCampaign.BiddingStrategy' => 'required_without:TextCampaign|array',
        ]);
    }
}