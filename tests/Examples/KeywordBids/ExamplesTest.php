<?php

namespace YandexDirectSDKTest\Examples\KeywordBids;

use PHPUnit\Framework\TestCase;
use YandexDirectSDK\Collections\AdGroups;
use YandexDirectSDK\Collections\Campaigns;
use YandexDirectSDK\Collections\KeywordBids;
use YandexDirectSDK\Collections\KeywordBidsAuto;
use YandexDirectSDK\Collections\Keywords;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\BiddingRule;
use YandexDirectSDK\Models\Campaign;
use YandexDirectSDK\Models\KeywordBid;
use YandexDirectSDK\Models\KeywordBidAuto;
use YandexDirectSDK\Models\NetworkByCoverage;
use YandexDirectSDK\Models\SearchByTrafficVolume;
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

        $result = KeywordBid::make()
            ->setAdGroupId($adGroupId)
            ->setSearchBid(30000000)
            ->setNetworkBid(10000000)
            ->apply();

        // [ Post processing ]

        Checklists::checkResource($result, KeywordBids::class, [
            'AdGroupId' => 'required|integer',
            'SearchBid' => 'required|integer',
            'NetworkBid' => 'required|integer'
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

        $bids = KeywordBids::make(
            KeywordBid::make()
                ->setAdGroupId($firstAdGroupId)
                ->setSearchBid(30000000)
                ->setNetworkBid(10000000),
            KeywordBid::make()
                ->setAdGroupId($secondAdGroupId)
                ->setSearchBid(25000000)
                ->setNetworkBid(15000000)
        );

        $result = $bids->apply();

        // [ Post processing ]

        Checklists::checkResource($result, KeywordBids::class, [
            'AdGroupId' => 'required|integer',
            'SearchBid' => 'required|integer',
            'NetworkBid' => 'required|integer'
        ]);
    }

    /**
     * @test
     * @return void
     */
    public static function applyBidAuto_SearchByTrafficVolume()
    {
        // [ Pre processing ]

        $campaignId = static::$campaigns->first()->id;

        // [ Example ]

        $result = KeywordBidAuto::make()
            ->setCampaignId($campaignId)
            ->setBiddingRule(
                BiddingRule::make()
                    ->setSearchByTrafficVolume(
                        SearchByTrafficVolume::make()
                            ->setTargetTrafficVolume(60)
                            ->setIncreasePercent(10)
                            ->setBidCeiling(165000000)
                    )
            )
            ->apply();

        // [ Post processing ]

        Checklists::checkResource($result, KeywordBidsAuto::class, [
            'CampaignId' => 'required|integer',
            'BiddingRule' => 'required|array',
            'BiddingRule.SearchByTrafficVolume' => 'required|array',
            'BiddingRule.SearchByTrafficVolume.TargetTrafficVolume' => 'required|integer',
            'BiddingRule.SearchByTrafficVolume.IncreasePercent' => 'required|integer',
            'BiddingRule.SearchByTrafficVolume.BidCeiling' => 'required|integer'
        ]);
    }

    /**
     * @test
     * @return void
     */
    public static function applyBidAuto_NetworkByCoverage()
    {
        // [ Pre processing ]

        $campaignId = static::$campaigns->first()->id;

        // [ Example ]

        $result = KeywordBidAuto::make()
            ->setCampaignId($campaignId)
            ->setBiddingRule(
                BiddingRule::make()
                    ->setNetworkByCoverage(
                        NetworkByCoverage::make()
                            ->setTargetCoverage(90)
                            ->setIncreasePercent(5)
                            ->setBidCeiling(5000000)
                    )
            )
            ->apply();

        // [ Post processing ]

        Checklists::checkResource($result, KeywordBidsAuto::class, [
            'CampaignId' => 'required|integer',
            'BiddingRule' => 'required|array',
            'BiddingRule.NetworkByCoverage' => 'required|array',
            'BiddingRule.NetworkByCoverage.TargetCoverage' => 'required|integer',
            'BiddingRule.NetworkByCoverage.IncreasePercent' => 'required|integer',
            'BiddingRule.NetworkByCoverage.BidCeiling' => 'required|integer'
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

        $bids = KeywordBid::query()
            ->select([
                'AdGroupId',
                'Search.Bid',
                'Search.AuctionBids',
                'Network.Bid',
                'Network.Coverage'
            ])
            ->whereIn('KeywordIds', $keywordIds)
            ->get();

        // [ Post processing ]

        Checklists::checkModelCollection($bids, KeywordBids::class, [
            'AdGroupId' => 'required|integer',
            'Search' => 'required|array',
            'Search.Bid' => 'required|integer',
            'Search.AuctionBids' => 'filled|array',
            'Network' => 'required|array',
            'Network.Bid' => 'required|integer',
            'Network.Coverage' => 'filled|array'
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

        $bid = KeywordBid::query()
            ->select([
                'AdGroupId',
                'Search.Bid',
                'Search.AuctionBids',
                'Network.Bid',
                'Network.Coverage'
            ])
            ->whereIn('KeywordIds', $keywordIds)
            ->first();

        // [ Post processing ]

        Checklists::checkModel($bid, KeywordBid::class, [
            'AdGroupId' => 'required|integer',
            'Search' => 'required|array',
            'Search.Bid' => 'required|integer',
            'Search.AuctionBids' => 'filled|array',
            'Network' => 'required|array',
            'Network.Bid' => 'required|integer',
            'Network.Coverage' => 'filled|array'
        ]);
    }
}