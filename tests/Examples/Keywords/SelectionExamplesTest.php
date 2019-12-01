<?php

namespace YandexDirectSDKTest\Examples\Keywords;

use PHPUnit\Framework\TestCase;
use UPTools\Arr;
use YandexDirectSDK\Collections\Keywords;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\Campaign;
use YandexDirectSDK\Models\Keyword;
use YandexDirectSDKTest\Helpers\Checklists;
use YandexDirectSDKTest\Helpers\Env;

class SelectionExamplesTest extends TestCase
{
    /**
     * @var Keyword[]
     */
    private static $keywords = [];

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

        static::$keywords['KeywordHPMC'] = CreateExamplesTest::createKeyword_TextGroup_HighestPosition_MaximumCoverage();
        static::$keywords['KeywordMCND'] = CreateExamplesTest::createKeyword_TextGroup_WbMaximumClicks_NetworkDefault();
    }

    /**
     * Destructor
     * @return void
     */
    public static function tearDownAfterClass(): void
    {
        Env::setUpSession();

        $adGroupIds = Arr::map(static::$keywords, function (Keyword $keyword){
            return $keyword->adGroupId;
        });

        if (count($adGroupIds) > 1){
            $campaignIds = AdGroup::find($adGroupIds, ['CampaignId'])->extract('campaignId');
        } else {
            $campaignIds = AdGroup::find($adGroupIds, ['CampaignId'])->campaignId;
        }

        Campaign::find($campaignIds)->delete();
        static::$keywords = [];
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

        $id = Arr::first(static::$keywords)->id;

        // [ Example ]

        $keyword = Keyword::find($id, ['Id', 'Keyword', 'Status']);

        // [ Post processing ]

        Checklists::checkModel($keyword, Keyword::class, [
            'Id' => 'required|integer',
            'Keyword' => 'required|string',
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

        $ids = Arr::map(static::$keywords, function(Keyword $keyword){
            return $keyword->id;
        });

        // [ Example ]

        $keywords = Keyword::find($ids, ['Id', 'Keyword', 'Status']);

        // [ Post processing ]

        Checklists::checkModelCollection($keywords, Keywords::class, [
            'Id' => 'required|integer',
            'Keyword' => 'required|string',
            'Status' => 'required|string'
        ]);
    }

    /**
     * @test
     * @return void
     */
    public static function query():void
    {
        // [ Pre processing ]

        $adGroupIds = Arr::map(static::$keywords, function(Keyword $keyword){
            return $keyword->adGroupId;
        });

        // [ Example ]

        $keywords = Keyword::query()
            ->select('Id', 'Keyword', 'Status')
            ->whereIn('AdGroupIds', $adGroupIds)
            ->whereIn('Statuses', 'DRAFT')
            ->get();

        // [ Post processing ]

        Checklists::checkModelCollection($keywords, Keywords::class, [
            'Id' => 'required|integer',
            'Keyword' => 'required|string',
            'Status' => 'required|string:DRAFT'
        ]);
    }

    /**
     * @test
     * @return void
     */
    public static function queryFirst():void
    {
        // [ Pre processing ]

        $adGroupIds = Arr::map(static::$keywords, function(Keyword $keyword){
            return $keyword->adGroupId;
        });

        // [ Example ]

        $keyword = Keyword::query()
            ->select('Id', 'Keyword', 'Status')
            ->whereIn('AdGroupIds', $adGroupIds)
            ->whereIn('Statuses', 'DRAFT')
            ->first();

        // [ Post processing ]

        Checklists::checkModel($keyword, Keyword::class, [
            'Id' => 'required|integer',
            'Keyword' => 'required|string',
            'Status' => 'required|string:DRAFT'
        ]);
    }
}