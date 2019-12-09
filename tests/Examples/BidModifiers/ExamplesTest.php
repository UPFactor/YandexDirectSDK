<?php

namespace YandexDirectSDKTest\Examples\BidModifiers;

use PHPUnit\Framework\TestCase;
use YandexDirectSDK\Collections\AdGroups;
use YandexDirectSDK\Collections\BidModifiers;
use YandexDirectSDK\Collections\BidModifierSets;
use YandexDirectSDK\Collections\Campaigns;
use YandexDirectSDK\Collections\Keywords;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\BidModifier;
use YandexDirectSDK\Models\BidModifierSet;
use YandexDirectSDK\Models\BidModifierToggle;
use YandexDirectSDK\Models\Campaign;
use YandexDirectSDK\Models\DemographicsAdjustment;
use YandexDirectSDK\Models\MobileAdjustment;
use YandexDirectSDK\Models\RegionalAdjustment;
use YandexDirectSDKTest\Examples\Keywords\CreateExamplesTest;
use YandexDirectSDKTest\Helpers\Checklists;
use YandexDirectSDKTest\Helpers\Env;

class ExamplesTest extends TestCase
{
    /**
     * @var Keywords
     */
    private static $keywords;

    /**
     * @var AdGroups
     */
    private static $adGroups;

    /**
     * @var Campaigns
     */
    private static $campaigns;

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

        static::$keywords = Keywords::wrap([
            CreateExamplesTest::createKeyword_TextGroup_HighestPosition_MaximumCoverage(),
            CreateExamplesTest::createKeyword_TextGroup_HighestPosition_MaximumCoverage()
        ]);

        static::$adGroups = AdGroup::find(static::$keywords->extract('adGroupId'), ['Id', 'CampaignId']);
        static::$campaigns = Campaign::find(static::$adGroups->extract('campaignId'));
    }

    /**
     * Destructor
     * @return void
     */
    public static function tearDownAfterClass(): void
    {
        static::$campaigns->delete();
        static::$campaigns = null;
        static::$keywords = null;
        static::$adGroups = null;
        static::$campaigns = null;
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
    public static function createBidModifier():void
    {
        // [ Pre processing ]

        $adGroupId = static::$adGroups->first()->id;

        // [ Example ]

        $result = BidModifier::make()
            ->setAdGroupId($adGroupId)
            ->setMobileAdjustment(
                MobileAdjustment::make()
                    ->setBidModifier(100)
            )
            ->create();

        // [ Post processing ]

        Checklists::checkResource($result, BidModifiers::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'MobileAdjustment' => 'required|array',
            'MobileAdjustment.BidModifier' => 'required|integer:100',
        ]);

        $result->resource->delete();
    }

    /**
     * @test
     * @return void
     */
    public static function createBidModifiers():void
    {
        // [ Pre processing ]

        $campaignId = static::$campaigns->first()->id;
        $adGroupId = static::$adGroups->first()->id;

        // [ Example ]

        $bidModifiers = BidModifiers::wrap([
            BidModifier::make()
                ->setAdGroupId($adGroupId)
                ->setDemographicsAdjustment(
                    DemographicsAdjustment::make()
                        ->setGender('GENDER_MALE')
                        ->setAge('AGE_25_34')
                        ->setBidModifier(101)
                ),
            BidModifier::make()
                ->setAdGroupId($adGroupId)
                ->setDemographicsAdjustment(
                    DemographicsAdjustment::make()
                        ->setAge('AGE_45_54')
                        ->setBidModifier(140)
                ),
            BidModifier::make()
                ->setCampaignId($campaignId)
                ->setRegionalAdjustment(
                    RegionalAdjustment::make()
                        ->setRegionId(225)
                        ->setBidModifier(140)
                )
        ]);

        $result = $bidModifiers->create();

        // [ Post processing ]

        Checklists::checkResource($result, BidModifiers::class, [
            'Id' => 'required|integer'
        ]);
    }

    /*
     | selection
     | -------------------------------------------------------------------------------
     */

    /**
     * @test
     * @depends createBidModifiers
     * @return void
     */
    public static function query():void
    {
        $campaignIds = static::$campaigns->extract('id');

        // [ Example ]

        $bidModifiers = BidModifier::query()
            ->select('Id','Type','Level')
            ->whereIn('CampaignIds', $campaignIds)
            ->whereIn('Types', ['MOBILE_ADJUSTMENT','REGIONAL_ADJUSTMENT'])
            ->whereIn('Levels', ['CAMPAIGN','AD_GROUP'])
            ->get();

        // [ Post processing ]

        Checklists::checkModelCollection($bidModifiers, BidModifiers::class, [
            'Id' => 'required|integer',
            'Type' => 'required|string:MOBILE_ADJUSTMENT,REGIONAL_ADJUSTMENT',
            'Level' => 'required|string:CAMPAIGN,AD_GROUP'
        ]);
    }

    /**
     * @test
     * @depends createBidModifiers
     * @return void
     */
    public static function queryFirst():void
    {
        $campaignIds = static::$campaigns->extract('id');

        // [ Example ]

        $bidModifier = BidModifier::query()
            ->select('Id','Type','Level')
            ->whereIn('CampaignIds', $campaignIds)
            ->whereIn('Types', ['MOBILE_ADJUSTMENT','REGIONAL_ADJUSTMENT'])
            ->whereIn('Levels', ['CAMPAIGN','AD_GROUP'])
            ->first();

        // [ Post processing ]

        Checklists::checkModel($bidModifier, BidModifier::class, [
            'Id' => 'required|integer',
            'Type' => 'required|string:MOBILE_ADJUSTMENT,REGIONAL_ADJUSTMENT',
            'Level' => 'required|string:CAMPAIGN,AD_GROUP'
        ]);
    }

    /*
     | applyCoefficient
     | -------------------------------------------------------------------------------
     */

    /**
     * @test
     * @depends createBidModifiers
     * @return void
     */
    public static function applyCoefficient_UseCampaignCollection():void
    {
        // [ Pre processing ]

        $campaignIds = static::$campaigns->extract('id');

        // [ Example ]

        $result = Campaigns::to($campaignIds)
            ->getRelatedBidModifiers()
            ->applyCoefficient('50');

        // [ Post processing ]

        Checklists::checkResource($result, BidModifierSets::class, [
            'Id' => 'required|integer'
        ]);
    }

    /**
     * @test
     * @depends createBidModifiers
     * @return void
     */
    public static function applyCoefficient_UseBidModifierModel():void
    {
        // [ Pre processing ]

        $campaignIds = static::$campaigns->extract('id');

        // [ Example ]

        $bidModifiers = BidModifier::query()
            ->select('Id','Type','Level')
            ->whereIn('CampaignIds', $campaignIds)
            ->whereIn('Types', ['MOBILE_ADJUSTMENT','REGIONAL_ADJUSTMENT'])
            ->whereIn('Levels', ['CAMPAIGN','AD_GROUP'])
            ->get();

        $result = $bidModifiers->applyCoefficient(40);

        // [ Post processing ]

        Checklists::checkModelCollection($bidModifiers, BidModifiers::class, [
            'Id' => 'required|integer',
            'Type' => 'required|string:MOBILE_ADJUSTMENT,REGIONAL_ADJUSTMENT',
            'Level' => 'required|string:CAMPAIGN,AD_GROUP'
        ]);

        Checklists::checkResource($result, BidModifierSets::class, [
            'Id' => 'required|integer'
        ]);
    }

    /**
     * @test
     * @depends createBidModifiers
     * @return void
     */
    public static function applyCoefficient_UseBidModifierSetModel():void
    {
        // [ Pre processing ]

        $bidModifierId = static::$campaigns
            ->getRelatedBidModifiers()
            ->first()
            ->id;

        // [ Example ]

        $result = BidModifierSet::make()
            ->setId($bidModifierId)
            ->setBidModifier(150)
            ->apply();

        // [ Post processing ]

        Checklists::checkResource($result, BidModifierSets::class, [
            'Id' => 'required|integer'
        ]);
    }

    /*
     | toggle
     | -------------------------------------------------------------------------------
     */

    /**
     * @test
     * @depends createBidModifiers
     * @return void
     */
    public static function toggle():void
    {
        // [ Pre processing ]

        $adGroupId = static::$adGroups->first()->id;

        // [ Example ]

        $result = BidModifierToggle::make()
            ->setAdGroupId($adGroupId)
            ->setType('DEMOGRAPHICS_ADJUSTMENT')
            ->setEnabled('NO')
            ->apply();

        // [ Post processing ]

        Checklists::checkResult($result);

    }

    /*
     | delete
     | -------------------------------------------------------------------------------
     */

    /**
     * @test
     * @depends createBidModifiers
     * @return void
     */
    public static function delete():void
    {
        // [ Pre processing ]

        $campaignIds = static::$campaigns->extract('id');

        // [ Example ]

        $bidModifiers = BidModifier::query()
            ->select('Id')
            ->whereIn('CampaignIds', $campaignIds)
            ->whereIn('Levels', ['CAMPAIGN','AD_GROUP'])
            ->get();

        $result = $bidModifiers->delete();

        // [ Post processing ]

        Checklists::checkModelCollection($bidModifiers, BidModifiers::class, [
            'Id' => 'required|integer'
        ]);

        Checklists::checkResult($result);
    }
}