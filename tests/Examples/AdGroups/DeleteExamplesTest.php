<?php

namespace YandexDirectSDKTest\Examples\AdGroups;

use PHPUnit\Framework\TestCase;
use UPTools\Arr;
use YandexDirectSDK\Collections\AdGroups;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\Campaign;
use YandexDirectSDKTest\Helpers\Checklists;
use YandexDirectSDKTest\Helpers\Env;

class DeleteExamplesTest extends TestCase
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
        static::$adGroups = [];
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
    public static function deleteModel():void
    {
        // [ Pre processing ]

        $adGroup = static::$adGroups[] = CreateExamplesTest::createTextGroup_HighestPosition_MaximumCoverage();

        // [ Example ]

        $result = $adGroup->delete();

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

        $adGroups = AdGroups::make(
            static::$adGroups[] = CreateExamplesTest::createTextGroup_HighestPosition_MaximumCoverage(),
            static::$adGroups[] = CreateExamplesTest::createTextGroup_WbMaximumClicks_NetworkDefault()
        );

        // [ Example ]

        $result = $adGroups->delete();

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

        $adGroupId = (static::$adGroups[] = CreateExamplesTest::createTextGroup_HighestPosition_MaximumCoverage())->id;

        // [ Example ]

        $result = AdGroup::to($adGroupId)->delete();

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

        $adGroupIds = AdGroups::make(
            static::$adGroups[] = CreateExamplesTest::createTextGroup_HighestPosition_MaximumCoverage(),
            static::$adGroups[] = CreateExamplesTest::createTextGroup_WbMaximumClicks_NetworkDefault()
        )->extract('id');

        // [ Example ]

        $result = AdGroups::to($adGroupIds)->delete();

        // [ Post processing ]

        Checklists::checkResult($result);
    }
}