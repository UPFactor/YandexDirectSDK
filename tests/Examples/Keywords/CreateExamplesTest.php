<?php

namespace YandexDirectSDKTest\Examples\Keywords;

use PHPUnit\Framework\TestCase;
use UPTools\Arr;
use YandexDirectSDK\Collections\Keywords;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\Campaign;
use YandexDirectSDK\Models\Keyword;
use YandexDirectSDKTest\Examples\AdGroups\CreateExamplesTest as AdGroupsCreateExamplesTest;
use YandexDirectSDKTest\Helpers\Checklists;
use YandexDirectSDKTest\Helpers\Env;

class CreateExamplesTest extends TestCase
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

    /**
     * Constructor
     * @return void
     */
    public static function setUpBeforeClass(): void
    {
        Env::setUpSession();

        static::$adGroups = [
            'TextGroupHPMC' => AdGroupsCreateExamplesTest::createTextGroup_HighestPosition_MaximumCoverage(),
            'TextGroupMCND' => AdGroupsCreateExamplesTest::createTextGroup_WbMaximumClicks_NetworkDefault()
        ];
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

    /*
     | Make
     | -------------------------------------------------------------------------------
     */

    /**
     * @test
     * @return void
     */
    public static function makeKeywords():void
    {
        // [ Pre processing ]

        static::$adGroups[] = $adGroup = AdGroupsCreateExamplesTest::createTextGroup_HighestPosition_MaximumCoverage();

        // [ Example ]

        $keywords = Keywords::wrap([
            [
                'AdGroupId' => $adGroup->id,
                'Keyword' => 'keyword1'
            ],
            [
                'AdGroupId' => $adGroup->id,
                'Keyword' => 'keyword2'
            ]
        ]);

        $result = $keywords->create();

        // [ Post processing ]

        Checklists::checkResource($result, Keywords::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'Keyword' => 'required|string'
        ]);

        Checklists::checkResult(
            $keywords->delete()
        );
    }

    /**
     * @test
     * @return void
     */
    public static function makeKeyword_TextGroup_HighestPosition_MaximumCoverage():void
    {
        // [ Pre processing ]

        static::$adGroups[] = $adGroup = AdGroupsCreateExamplesTest::createTextGroup_HighestPosition_MaximumCoverage();

        // [ Example ]

        $keyword = Keyword::make([
            'Keyword' => 'yandex direct -api',
            'AdGroupId' => $adGroup->id,
            'Bid' => 30000000,
            'ContextBid' => 10000000,
            'UserParam1' => 'param1-by-keyword-1',
            'UserParam2' => 'param2-by-keyword-1',
        ]);

        $result = $keyword->create();

        // [ Post processing ]

        Checklists::checkResource($result, Keywords::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'Keyword' => 'required|string',
            'Bid' => 'required|integer',
            'ContextBid' => 'required|integer',
            'UserParam1' => 'required|string',
            'UserParam2' => 'required|string'
        ]);

        Checklists::checkResult(
            $keyword->delete()
        );
    }

    /**
     * @test
     * @return void
     */
    public static function makeKeyword_TextGroup_WbMaximumClicks_NetworkDefault():void
    {
        // [ Pre processing ]

        static::$adGroups[] = $adGroup = AdGroupsCreateExamplesTest::createTextGroup_WbMaximumClicks_NetworkDefault();

        // [ Example ]

        $keyword = Keyword::make([
            'Keyword' => 'yandex direct -api',
            'AdGroupId' => $adGroup->id,
            'StrategyPriority' => 'NORMAL',
            'UserParam1' => 'param1-by-keyword-1',
            'UserParam2' => 'param2-by-keyword-1',
        ]);

        $result = $keyword->create();

        // [ Post processing ]

        Checklists::checkResource($result, Keywords::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'Keyword' => 'required|string',
            'StrategyPriority' => 'required|string',
            'UserParam1' => 'required|string',
            'UserParam2' => 'required|string'
        ]);

        Checklists::checkResult(
            $keyword->delete()
        );
    }


    /*
     | Create
     | -------------------------------------------------------------------------------
     */

    /**
     * @test
     * @return Keywords
     */
    public static function createKeywords():Keywords
    {
        // [ Pre processing ]

        static::$adGroups[] = $adGroup = AdGroupsCreateExamplesTest::createTextGroup_HighestPosition_MaximumCoverage();

        // [ Example ]

        $keywords = Keywords::wrap([
            Keyword::make()
                ->setAdGroupId($adGroup->id)
                ->setKeyword('keyword1'),
            Keyword::make()
                ->setAdGroupId($adGroup->id)
                ->setKeyword('keyword2')
        ]);

        $keywords->push(
            Keyword::make()
                ->setAdGroupId($adGroup->id)
                ->setKeyword('keyword3')
        );

        $result = $keywords->create();

        // [ Post processing ]

        Checklists::checkResource($result, Keywords::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'Keyword' => 'required|string'
        ]);

        return $keywords;
    }

    /**
     * @test
     * @return Keyword
     */
    public static function createKeyword_TextGroup_HighestPosition_MaximumCoverage():Keyword
    {
        // [ Pre processing ]

        static::$adGroups[] = $adGroup = AdGroupsCreateExamplesTest::createTextGroup_HighestPosition_MaximumCoverage();

        // [ Example ]

        $keyword = Keyword::make()
            ->setAdGroupId($adGroup->id)
            ->setKeyword('yandex direct -api')
            ->setBid(30000000)
            ->setContextBid(10000000)
            ->setUserParam1('param1-by-keyword-1')
            ->setUserParam2('param2-by-keyword-1');

        $result = $keyword->create();

        // [ Post processing ]

        Checklists::checkResource($result, Keywords::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'Keyword' => 'required|string',
            'Bid' => 'required|integer',
            'ContextBid' => 'required|integer',
            'UserParam1' => 'required|string',
            'UserParam2' => 'required|string'
        ]);

        return $keyword;
    }

    /**
     * @test
     * @return Keyword
     */
    public static function createKeyword_TextGroup_WbMaximumClicks_NetworkDefault():Keyword
    {
        // [ Pre processing ]

        static::$adGroups[] = $adGroup = AdGroupsCreateExamplesTest::createTextGroup_WbMaximumClicks_NetworkDefault();

        // [ Example ]

        $keyword = Keyword::make()
            ->setAdGroupId($adGroup->id)
            ->setKeyword('yandex direct -api')
            ->setStrategyPriority('NORMAL')
            ->setUserParam1('param1-by-keyword-1')
            ->setUserParam2('param2-by-keyword-1');

        $result = $keyword->create();

        // [ Post processing ]

        Checklists::checkResource($result, Keywords::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'Keyword' => 'required|string',
            'StrategyPriority' => 'required|string',
            'UserParam1' => 'required|string',
            'UserParam2' => 'required|string'
        ]);

        return $keyword;
    }
}