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

class DeleteExamplesTest extends TestCase
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

    /**
     * Constructor
     * @return void
     */
    public static function setUpBeforeClass(): void
    {
        Env::setUpSession();
        static::$keywords = [];
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
    public static function deleteModel():void
    {
        // [ Pre processing ]

        $keyword = static::$keywords[] = CreateExamplesTest::createKeyword_TextGroup_HighestPosition_MaximumCoverage();

        // [ Example ]

        $result = $keyword->delete();

        // [ Post processing ]

        Checklists::checkResult($result);
    }

    /**
     * @test
     * @return void
     */
    public static function deleteModels():void
    {
        // [ Pre processing ]

        $keywords =  Keywords::make(
            static::$keywords[] = CreateExamplesTest::createKeyword_TextGroup_HighestPosition_MaximumCoverage(),
            static::$keywords[] = CreateExamplesTest::createKeyword_TextGroup_WbMaximumClicks_NetworkDefault()
        );

        // [ Example ]

        $result = $keywords->delete();

        // [ Post processing ]

        Checklists::checkResult($result);
    }

    /**
     * @test
     * @return void
     */
    public static function deleteById():void
    {
        // [ Pre processing ]

        $keywordId = (static::$keywords[] = CreateExamplesTest::createKeyword_TextGroup_HighestPosition_MaximumCoverage())->id;

        // [ Example ]

        $result = Keyword::to($keywordId)->delete();

        // [ Post processing ]

        Checklists::checkResult($result);
    }

    /**
     * @test
     * @return void
     */
    public static function deleteByIds():void
    {
        // [ Pre processing ]

        $keywordIds = Keywords::make(
            static::$keywords[] = CreateExamplesTest::createKeyword_TextGroup_HighestPosition_MaximumCoverage(),
            static::$keywords[] = CreateExamplesTest::createKeyword_TextGroup_WbMaximumClicks_NetworkDefault()
        )->extract('id');

        // [ Example ]

        $result = Keywords::to($keywordIds)->delete();

        // [ Post processing ]

        Checklists::checkResult($result);
    }
}