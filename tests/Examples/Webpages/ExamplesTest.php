<?php

namespace YandexDirectSDKTest\Examples\Webpages;

use PHPUnit\Framework\TestCase;
use YandexDirectSDK\Collections\WebpageBids;
use YandexDirectSDK\Collections\WebpageConditions;
use YandexDirectSDK\Collections\Webpages;
use YandexDirectSDK\Interfaces\ModelCollection as ModelCollectionInterface;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\Campaign;
use YandexDirectSDK\Models\Webpage;
use YandexDirectSDK\Models\WebpageBid;
use YandexDirectSDK\Models\WebpageCondition;
use YandexDirectSDKTest\Examples\AdGroups\CreateExamplesTest;
use YandexDirectSDKTest\Helpers\Checklists;
use YandexDirectSDKTest\Helpers\Env;

class ExamplesTest extends TestCase
{
    /**
     * @var AdGroup
     */
    private static $adGroupHPSO;

    /**
     * @var AdGroup
     */
    private static $adGroupMCSO;

    /**
     * @var Campaign
     */
    private static $campaignHPSO;

    /**
     * @var Campaign
     */
    private static $campaignMCSO;

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

        static::$adGroupHPSO = CreateExamplesTest::createDynamicTextAdGroup_HighestPosition_ServingOff();
        static::$adGroupMCSO = CreateExamplesTest::createDynamicTextAdGroup_WbMaximumClicks_ServingOff();
        static::$campaignHPSO = Campaign::find(static::$adGroupHPSO->campaignId);
        static::$campaignMCSO = Campaign::find(static::$adGroupMCSO->campaignId);
    }

    /**
     * Destructor
     * @return void
     */
    public static function tearDownAfterClass(): void
    {
        static::$campaignHPSO->delete();
        static::$campaignMCSO->delete();
        static::$adGroupHPSO = null;
        static::$adGroupMCSO = null;
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Examples
     |
     |-------------------------------------------------------------------------------
    */

    /*
     | create
     | -------------------------------------------------------------------------------
     */

    /**
     * @test
     * @return void
     */
    public static function createWebpage_UsingFullConditions():void
    {
        // [ Pre processing ]

        $adGroupId = static::$adGroupHPSO->id;

        // [ Example ]

        $result = Webpage::make()
            ->setName('Apple products')
            ->setAdGroupId($adGroupId)
            ->setBid(20000000)
            ->setConditions(
                WebpageConditions::make(
                    WebpageCondition::make()
                        ->setOperand('DOMAIN')
                        ->setOperator('CONTAINS_ANY')
                        ->setArguments(['mysite.com']),
                    WebpageCondition::make()
                        ->setOperand('URL')
                        ->setOperator('NOT_CONTAINS_ALL')
                        ->setArguments(['page','tag']),
                    WebpageCondition::make()
                        ->setOperand('PAGE_TITLE')
                        ->setOperator('CONTAINS_ANY')
                        ->setArguments(['iphone','macbook'])
                )
            )
            ->create();

        // [ Post processing ]

        Checklists::checkResource($result, Webpages::class, [
            'Id' => 'required|integer'
        ]);

        Checklists::checkResult(
            $result->resource->delete()
        );
    }

    /**
     * @test
     * @return void
     */
    public static function createWebpage_UsingShortConditions():void
    {
        // [ Pre processing ]

        $adGroupId = static::$adGroupMCSO->id;

        // [ Example ]

        $result = Webpage::make()
            ->setName('Apple products')
            ->setAdGroupId($adGroupId)
            ->setStrategyPriority('HIGH')
            ->setConditions(
                WebpageConditions::make(
                    WebpageCondition::domainContain(['mysite.com']),
                    WebpageCondition::urlNotContain(['page','tag']),
                    WebpageCondition::pageTitleContain(['iphone','macbook'])
                )
            )
            ->create();

        // [ Post processing ]

        Checklists::checkResource($result, Webpages::class, [
            'Id' => 'required|integer'
        ]);

        Checklists::checkResult(
            $result->resource->delete()
        );
    }

    /**
     * @test
     * @return Webpages|ModelCollectionInterface
     */
    public static function createWebpages():Webpages
    {
        // [ Pre processing ]

        $firstAdGroupId = static::$adGroupMCSO->id;
        $secondAdGroupId = static::$adGroupHPSO->id;

        // [ Example ]

        $webpages = Webpages::wrap([
            Webpage::make()
                ->setName('Apple products')
                ->setAdGroupId($firstAdGroupId)
                ->setStrategyPriority('HIGH')
                ->setConditions(
                    WebpageConditions::make(
                        WebpageCondition::domainContain(['mysite.com']),
                        WebpageCondition::urlNotContain(['page','tag']),
                        WebpageCondition::pageTitleContain(['iphone','macbook'])
                    )
                ),
            Webpage::make()
                ->setName('China products')
                ->setAdGroupId($secondAdGroupId)
                ->setBid(20000000)
                ->setConditions(
                    WebpageConditions::make(
                        WebpageCondition::domainContain(['mysite.com']),
                        WebpageCondition::urlNotContain(['page','tag']),
                        WebpageCondition::pageTitleContain(['xiaomi','huawei'])
                    )
                )
        ]);

        $result = $webpages->create();

        // [ Post processing ]

        Checklists::checkResource($result, Webpages::class, [
            'Id' => 'required|integer'
        ]);

        return $result->resource;
    }

    /*
     | selection
     | -------------------------------------------------------------------------------
     */

    /**
     * @test
     * @depends createWebpages
     * @param Webpages $webpages
     */
    public static function findModel(Webpages $webpages):void
    {
        $webpageId = $webpages->first()->id;

        // [ Example ]

        $webpage = Webpage::find($webpageId, ['Id','Name','Conditions','State']);

        // [ Post processing ]

        Checklists::checkModel($webpage, Webpage::class, [
            'Id' => 'required|integer',
            'Name' => 'required|string',
            'State' => 'required|string',
            'Conditions' => 'required|array',
            'Conditions.*.Operand' => 'required|string',
            'Conditions.*.Operator' => 'required|string',
            'Conditions.*.Arguments' => 'required|array_of:string',
        ]);
    }

    /**
     * @test
     * @depends createWebpages
     * @param Webpages $webpages
     */
    public static function findModels(Webpages $webpages):void
    {
        $webpageIds = $webpages->extract('id');

        // [ Example ]

        $webpages = Webpage::find($webpageIds, ['Id','Name','Conditions','State']);

        // [ Post processing ]

        Checklists::checkModelCollection($webpages, Webpages::class, [
            'Id' => 'required|integer',
            'Name' => 'required|string',
            'State' => 'required|string',
            'Conditions' => 'required|array',
            'Conditions.*.Operand' => 'required|string',
            'Conditions.*.Operator' => 'required|string',
            'Conditions.*.Arguments' => 'required|array_of:string',
        ]);
    }

    /**
     * @test
     * @depends createWebpages
     * @return void
     */
    public static function query():void
    {
        $adGroupsIds = [
            static::$adGroupHPSO->id,
            static::$adGroupMCSO->id
        ];

        // [ Example ]

        $webpages = Webpage::query()
            ->select('Id','Name','Conditions','State')
            ->whereIn('AdGroupIds', $adGroupsIds)
            ->whereIn('States', ['OFF','SUSPENDED'])
            ->get();

        // [ Post processing ]

        Checklists::checkModelCollection($webpages, Webpages::class, [
            'Id' => 'required|integer',
            'Name' => 'required|string',
            'State' => 'required|string:OFF,SUSPENDED',
            'Conditions' => 'required|array',
            'Conditions.*.Operand' => 'required|string',
            'Conditions.*.Operator' => 'required|string',
            'Conditions.*.Arguments' => 'required|array_of:string',
        ]);
    }

    /**
     * @test
     * @depends createWebpages
     * @return void
     */
    public static function queryFirst():void
    {
        $campaignsIds = [
            static::$campaignHPSO->id,
            static::$campaignMCSO->id
        ];

        // [ Example ]

        $webpage = Webpage::query()
            ->select('Id','Name','Conditions','State')
            ->whereIn('CampaignIds', $campaignsIds)
            ->whereIn('States', ['OFF','SUSPENDED'])
            ->first();

        // [ Post processing ]

        Checklists::checkModel($webpage, Webpage::class, [
            'Id' => 'required|integer',
            'Name' => 'required|string',
            'State' => 'required|string:OFF,SUSPENDED',
            'Conditions' => 'required|array',
            'Conditions.*.Operand' => 'required|string',
            'Conditions.*.Operator' => 'required|string',
            'Conditions.*.Arguments' => 'required|array_of:string',
        ]);
    }

    /*
     | actions
     | -------------------------------------------------------------------------------
     */

    /**
     * @test
     * @depends createWebpages
     * @param Webpages $webpages
     * @return void
     */
    public static function suspend(Webpages $webpages):void
    {
        // [ Example ]

        $result = $webpages->suspend();

        // [ Post processing ]

        Checklists::checkResult($result);
        sleep(10);
    }

    /**
     * @test
     * @depends createWebpages
     * @param Webpages $webpages
     * @return void
     */
    public static function resume(Webpages $webpages):void
    {
        // [ Example ]

        $result = $webpages->resume();

        // [ Post processing ]

        Checklists::checkResult($result);
        sleep(10);
    }

    /*
     | relations
     | -------------------------------------------------------------------------------
     */

    /**
     * @test
     * @depends createWebpages
     * @param Webpages $webpages
     */
    public static function setRelationBids(Webpages $webpages):void
    {
        $webpages = Webpages::make($webpages->last());

        // [ Example ]

        $result = $webpages->setRelatedBids(30000000);

        // [ Post processing ]

        Checklists::checkResource($result, WebpageBids::class, [
            'Id' => 'required|integer',
            'Bid' => 'required|integer'
        ]);
    }

    /**
     * @test
     * @depends createWebpages
     * @param Webpages $webpages
     */
    public static function setRelationStrategyPriority(Webpages $webpages):void
    {
        $webpages = Webpages::make($webpages->first());

        // [ Example ]

        $result = $webpages->setRelatedStrategyPriority('NORMAL');

        // [ Post processing ]

        Checklists::checkResource($result, WebpageBids::class, [
            'Id' => 'required|integer',
            'StrategyPriority' => 'required|string'
        ]);
    }

    /*
     | applyBids
     | -------------------------------------------------------------------------------
     */

    /**
     * @test
     * @depends createWebpages
     * @return void
     */
    public static function applyBids_UseWebpageBidModel():void
    {
        $adGroupId = static::$adGroupHPSO->id;

        // [ Example ]

        $result = WebpageBid::make()
            ->setAdGroupId($adGroupId)
            ->setBid(25000000)
            ->apply();

        // [ Post processing ]

        Checklists::checkResource($result, WebpageBids::class, [
            'AdGroupId' => 'required|integer'
        ]);
    }

    /**
     * @test
     * @depends createWebpages
     * @return void
     */
    public static function applyBids_UseWebpageBidCollection():void
    {
        $firstAdGroupId = static::$adGroupHPSO->id;
        $secondAdGroupId = static::$adGroupMCSO->id;

        // [ Example ]

        $webpageBids = WebpageBids::make(
            WebpageBid::make()
                ->setAdGroupId($firstAdGroupId)
                ->setBid(25000000),
            WebpageBid::make()
                ->setAdGroupId($secondAdGroupId)
                ->setStrategyPriority('NORMAL')
        );

        $result = $webpageBids->apply();

        // [ Post processing ]

        Checklists::checkResource($result, WebpageBids::class, [
            'AdGroupId' => 'required|integer'
        ]);
    }

    /*
     | delete
     | -------------------------------------------------------------------------------
     */

    /**
     * @test
     * @depends createWebpages
     * @param Webpages $webpages
     * @return void
     */
    public static function delete(Webpages $webpages):void
    {
        $result = $webpages->delete();

        // [ Post processing ]

        Checklists::checkResult($result);
    }
}