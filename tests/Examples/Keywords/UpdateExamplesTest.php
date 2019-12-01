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

class UpdateExamplesTest extends TestCase
{
    /**
     * @var Keyword[]
     */
    private static $keywords;

    /*
     |-------------------------------------------------------------------------------
     |
     | Handlers
     |
     |-------------------------------------------------------------------------------
    */

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
     | DataProvider
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * DataProvider
     * @return array
     */
    public static function keywordProvider()
    {
        Env::setUpSession();

        return [
            'Keyword' => [static::$keywords['KeywordMCND'] ?? static::$keywords['KeywordMCND'] = CreateExamplesTest::createKeyword_TextGroup_WbMaximumClicks_NetworkDefault()]
        ];
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
     * @dataProvider keywordProvider
     * @param Keyword $keyword
     */
    public static function update(Keyword $keyword):void
    {
        $result = $keyword
            ->setKeyword('new keyword')
            ->setUserParam1('new-param1')
            ->setUserParam2('new-param2')
            ->update();

        // [ Post processing ]

        Checklists::checkResource($result, Keywords::class);
    }
}