<?php

namespace YandexDirectSDKTest\Examples\Keywords;

use PHPUnit\Framework\TestCase;
use UPTools\Arr;
use YandexDirectSDK\Collections\Keywords;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\Campaign;
use YandexDirectSDK\Models\Keyword;
use YandexDirectSDKTest\Helpers\Checklists;
use YandexDirectSDKTest\Helpers\Env;

class ActionsExamplesTest extends TestCase
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
            'Keyword' => [static::$keywords['KeywordMCND'] ?? static::$keywords['KeywordMCND'] = CreateExamplesTest::createKeyword_TextGroup_WbMaximumClicks_NetworkDefault()],
            'Keywords' => [
                Keywords::wrap([
                    static::$keywords['KeywordMCND'] ?? static::$keywords['KeywordMCND'] = CreateExamplesTest::createKeyword_TextGroup_WbMaximumClicks_NetworkDefault(),
                    static::$keywords['KeywordHPMC'] ?? static::$keywords['KeywordHPMC'] = CreateExamplesTest::createKeyword_TextGroup_HighestPosition_MaximumCoverage()
                ])
            ]
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
     * @param Keyword|Keywords|ModelCommonInterface $keywords
     * @return void
     */
    public static function suspend(ModelCommonInterface $keywords):void
    {
        $result = $keywords->suspend();

        // [ Post processing ]

        Checklists::checkResult($result);
        sleep(10);
    }

    /**
     * @test
     * @dataProvider keywordProvider
     * @param Keyword|Keywords|ModelCommonInterface $keywords
     * @return void
     */
    public static function resume(ModelCommonInterface $keywords):void
    {
        $result = $keywords->resume();

        // [ Post processing ]

        Checklists::checkResult($result);
    }
}