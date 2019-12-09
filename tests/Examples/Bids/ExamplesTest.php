<?php

namespace YandexDirectSDKTest\Examples\Bids;

use PHPUnit\Framework\TestCase;
use YandexDirectSDK\Collections\AdGroups;
use YandexDirectSDK\Collections\Bids;
use YandexDirectSDK\Collections\BidsAuto;
use YandexDirectSDK\Collections\Campaigns;
use YandexDirectSDK\Collections\Keywords;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\Bid;
use YandexDirectSDK\Models\BidAuto;
use YandexDirectSDK\Models\Campaign;
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
     | Apply
     | -------------------------------------------------------------------------------
     */

    /**
     * @test
     * @return void
     */
    public static function applyBid()
    {
        // [ Pre processing ]

        $adGroupId = static::$adGroups->first()->id;

        // [ Example ]

        $result = Bid::make()
            ->setAdGroupId($adGroupId)
            ->setBid(30000000)
            ->setContextBid(10000000)
            ->apply();

        // [ Post processing ]

        Checklists::checkResource($result, Bids::class, [
            'AdGroupId' => 'required|integer',
            'Bid' => 'required|integer',
            'ContextBid' => 'required|integer'
        ]);
    }

    /**
     * @test
     * @return void
     */
    public static function applyBids():void
    {
        // [ Pre processing ]

        $firstAdGroupId = static::$adGroups->first()->id;
        $secondAdGroupId = static::$adGroups->last()->id;

        // [ Example ]

        $bids = Bids::make(
            Bid::make()
                ->setAdGroupId($firstAdGroupId)
                ->setBid(30000000)
                ->setContextBid(10000000),
            Bid::make()
                ->setAdGroupId($secondAdGroupId)
                ->setBid(25000000)
                ->setContextBid(15000000)
        );

        $result = $bids->apply();

        // [ Post processing ]

        Checklists::checkResource($result, Bids::class, [
            'AdGroupId' => 'required|integer',
            'Bid' => 'required|integer',
            'ContextBid' => 'required|integer'
        ]);
    }

    /**
     * @test
     * @return void
     */
    public static function applyBidAuto()
    {
        // [ Pre processing ]

        $campaignId = static::$campaigns->first()->id;

        // [ Example ]

        $result = BidAuto::make()
            ->setCampaignId($campaignId)
            ->setMaxBid(45000000)
            ->setPosition('PREMIUMBLOCK')
            ->setScope(['SEARCH','NETWORK'])
            ->setContextCoverage(50)
            ->apply();

        // [ Post processing ]

        Checklists::checkResource($result, BidsAuto::class, [
            'CampaignId' => 'required|integer',
            'MaxBid' => 'required|integer',
            'Position' => 'required|string',
            'ContextCoverage' => 'required|integer',
            'Scope' => 'required|array_of:string'
        ]);
    }

    /**
     * @test
     * @return void
     */
    public static function applyBidsAuto()
    {
        // [ Pre processing ]

        $firstCampaignId = static::$campaigns->first()->id;
        $secondCampaignId = static::$campaigns->last()->id;

        // [ Example ]

        $auto = BidsAuto::make(
            BidAuto::make()
                ->setCampaignId($firstCampaignId)
                ->setMaxBid(45000000)
                ->setPosition('PREMIUMBLOCK')
                ->setScope(['SEARCH']),
            BidAuto::make()
                ->setCampaignId($secondCampaignId)
                ->setScope(['NETWORK'])
                ->setContextCoverage(50)
        );

        $result = $auto->apply();

        // [ Post processing ]

        Checklists::checkResource($result, BidsAuto::class, [
            'CampaignId' => 'required|integer',
            'MaxBid' => 'required_without:ContextCoverage|integer',
            'Position' => 'required_without:ContextCoverage|string',
            'ContextCoverage' => 'integer',
            'Scope' => 'required|array_of:string'
        ]);
    }

    /*
     | Selection
     | -------------------------------------------------------------------------------
     */

    /**
     * @test
     * @return void
     */
    public static function query()
    {
        // [ Pre processing ]

        $keywordIds = static::$keywords->extract('id');

        // [ Example ]

        $bids =Bid::query()
            ->select('AdGroupId','Bid', 'ContextBid')
            ->whereIn('KeywordIds', $keywordIds)
            ->get();

        // [ Post processing ]

        Checklists::checkModelCollection($bids, Bids::class, [
            'AdGroupId' => 'required|integer',
            'Bid' => 'required|integer',
            'ContextBid' => 'required|integer'
        ]);
    }

    /**
     * @test
     * @return void
     */
    public static function first()
    {
        // [ Pre processing ]

        $keywordIds = static::$keywords->extract('id');

        // [ Example ]

        $bid = Bid::query()
            ->select('AdGroupId','Bid', 'ContextBid')
            ->whereIn('KeywordIds', $keywordIds)
            ->first();

        // [ Post processing ]

        Checklists::checkModel($bid, Bid::class, [
            'AdGroupId' => 'required|integer',
            'Bid' => 'required|integer',
            'ContextBid' => 'required|integer'
        ]);
    }


}