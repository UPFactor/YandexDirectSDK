<?php

namespace YandexDirectSDKTest\Examples\Ads;

use PHPUnit\Framework\TestCase;
use UPTools\Arr;
use YandexDirectSDK\Collections\Ads;
use YandexDirectSDK\Models\Ad;
use YandexDirectSDK\Models\Campaign;
use YandexDirectSDKTest\Helpers\Checklists;
use YandexDirectSDKTest\Helpers\Env;

class SelectionExamplesTest extends TestCase
{
    /**
     * @var Ad[]
     */
    private static $ads = [];

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

        static::$ads['TextAd'] = CreateExamplesTest::createTextAd();
        static::$ads['DynamicTextAd'] = CreateExamplesTest::createDynamicTextAd();
    }

    /**
     * Destructor
     * @return void
     */
    public static function tearDownAfterClass(): void
    {
        Env::setUpSession();

        $adIds = Arr::map(static::$ads, function (Ad $ad){
            return $ad->id;
        });

        if (count($adIds) > 1){
            $campaignIds = Ads::find($adIds, ['CampaignId'])->extract('campaignId');
        } else {
            $campaignIds = Ads::find($adIds, ['CampaignId'])->campaignId;
        }

        Campaign::find($campaignIds)->delete();
        static::$ads = [];
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

        $id = Arr::first(static::$ads)->id;

        // [ Example ]

        $ad = Ad::find($id, ['Id', 'Status']);

        // [ Post processing ]

        Checklists::checkModel($ad, Ad::class, [
            'Id' => 'required|integer',
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

        $ids = Arr::map(static::$ads, function(Ad $ad){
            return $ad->id;
        });

        // [ Example ]

        $ads = Ad::find($ids, [
            'Id',
            'Status',
            'Type',
            'TextAd.Text',
            'DynamicTextAd.Text'
        ]);

        // [ Post processing ]

        Checklists::checkModelCollection($ads, Ads::class, [
            'Id' => 'required|integer',
            'Status' => 'required|string',
            'TextAd.Text' => 'required_if:Type,TEXT_AD|string',
            'DynamicTextAd.Text' => 'required_if:Type,DYNAMIC_TEXT_AD|string'
        ]);
    }

    /**
     * @test
     * @return void
     */
    public static function query():void
    {
        // [ Pre processing ]

        $adGroupIds = Arr::map(static::$ads, function(Ad $ad){
            return $ad->adGroupId;
        });

        // [ Example ]

        $ads = Ad::query()
            ->select([
                'Id',
                'Status',
                'Type',
                'TextAd.Text',
                'DynamicTextAd.Text'
            ])
            ->whereIn('AdGroupIds', $adGroupIds)
            ->whereIn('Types', ['TEXT_AD', 'DYNAMIC_TEXT_AD'])
            ->whereIn('Statuses', 'DRAFT')
            ->get();

        // [ Post processing ]

        Checklists::checkModelCollection($ads, Ads::class, [
            'Id' => 'required|integer',
            'Type' => 'required|string:TEXT_AD,MOBILE_APP_AD,DYNAMIC_TEXT_AD',
            'Status' => 'required|string:DRAFT',
            'TextAd.Text' => 'required_if:Type,TEXT_AD|string',
            'DynamicTextAd.Text' => 'required_if:Type,DYNAMIC_TEXT_AD|string'
        ]);
    }

    /**
     * @test
     * @return void
     */
    public static function queryFirst():void
    {
        // [ Pre processing ]

        $adGroupIds = Arr::map(static::$ads, function(Ad $ad){
            return $ad->adGroupId;
        });

        // [ Example ]

        $ad = Ad::query()
            ->select([
                'Id',
                'Status',
                'Type',
                'TextAd.Text',
                'DynamicTextAd.Text'
            ])
            ->whereIn('AdGroupIds', $adGroupIds)
            ->whereIn('Types', ['TEXT_AD', 'DYNAMIC_TEXT_AD'])
            ->whereIn('Statuses', 'DRAFT')
            ->first();

        // [ Post processing ]

        Checklists::checkModel($ad, Ad::class, [
            'Id' => 'required|integer',
            'Type' => 'required|string:TEXT_AD,MOBILE_APP_AD,DYNAMIC_TEXT_AD',
            'Status' => 'required|string:DRAFT',
            'TextAd.Text' => 'required_if:Type,TEXT_AD|string',
            'DynamicTextAd.Text' => 'required_if:Type,DYNAMIC_TEXT_AD|string'
        ]);
    }
}