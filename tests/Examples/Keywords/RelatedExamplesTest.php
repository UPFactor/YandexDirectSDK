<?php

namespace YandexDirectSDKTest\Examples\Keywords;

use PHPUnit\Framework\TestCase;
use UPTools\Arr;
use YandexDirectSDK\Collections\Bids;
use YandexDirectSDK\Collections\BidsAuto;
use YandexDirectSDK\Collections\Keywords;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\BidAuto;
use YandexDirectSDK\Models\Campaign;
use YandexDirectSDK\Models\Keyword;
use YandexDirectSDKTest\Helpers\Checklists;
use YandexDirectSDKTest\Helpers\Env;

class RelatedExamplesTest extends TestCase
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
    public static function keywordHPMCProvider()
    {
        Env::setUpSession();

        return [
            'KeywordHPMC' => [static::$keywords['KeywordHPMC'] ?? static::$keywords['KeywordHPMC'] = CreateExamplesTest::createKeyword_TextGroup_HighestPosition_MaximumCoverage()],
            'KeywordsHPMC' => [
                Keywords::make(
                    static::$keywords['KeywordHPMC'] ?? static::$keywords['KeywordHPMC'] = CreateExamplesTest::createKeyword_TextGroup_HighestPosition_MaximumCoverage()
                )
            ],
        ];
    }

    /**
     * DataProvider
     * @return array
     */
    public static function keywordMCNDProvider()
    {
        Env::setUpSession();

        return [
            'KeywordMCND' => [static::$keywords['KeywordMCND'] ?? static::$keywords['KeywordMCND'] = CreateExamplesTest::createKeyword_TextGroup_WbMaximumClicks_NetworkDefault()],
            'KeywordsMCND' => [
                Keywords::make(
                    static::$keywords['KeywordMCND'] ?? static::$keywords['KeywordMCND'] = CreateExamplesTest::createKeyword_TextGroup_WbMaximumClicks_NetworkDefault()
                )
            ],
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
     * @dataProvider keywordHPMCProvider
     * @param Keyword|Keywords|ModelCommonInterface $keywords
     */
    public static function setRelatedBids(ModelCommonInterface $keywords):void
    {
        $result = $keywords->setRelatedBids(30000000, 10000000);

        // [ Post processing ]

        Checklists::checkResource($result, Bids::class, [
            'KeywordId' => 'required|integer',
            'Bid' => 'required|integer',
            'ContextBid' => 'required|integer'
        ]);
    }

    /**
     * @test
     * @dataProvider keywordHPMCProvider
     * @param Keyword|Keywords|ModelCommonInterface $keywords
     */
    public static function setRelatedContextBids(ModelCommonInterface $keywords):void
    {
        $result = $keywords->setRelatedContextBids(10000000);

        // [ Post processing ]

        Checklists::checkResource($result, Bids::class, [
            'KeywordId' => 'required|integer',
            'ContextBid' => 'required|integer'
        ]);
    }

    /**
     * @test
     * @dataProvider keywordMCNDProvider
     * @param Keyword|Keywords|ModelCommonInterface $keywords
     */
    public static function setRelatedStrategyPriority(ModelCommonInterface $keywords):void
    {
        $result = $keywords->setRelatedStrategyPriority('NORMAL');

        // [ Post processing ]

        Checklists::checkResource($result, Bids::class, [
            'KeywordId' => 'required|integer',
            'StrategyPriority' => 'required|string'
        ]);
    }

    /**
     * @test
     * @dataProvider keywordHPMCProvider
     * @param Keyword|Keywords|ModelCommonInterface $keywords
     */
    public static function getRelatedBids(ModelCommonInterface $keywords):void
    {
        $bids = $keywords->getRelatedBids(['CampaignId','AdGroupId','KeywordId','Bid']);

        // [ Post processing ]

        Checklists::checkModelCollection($bids, Bids::class, [
            'CampaignId' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'KeywordId' => 'required|integer',
            'Bid' => 'required|integer',
        ]);
    }

    /**
     * @test
     * @dataProvider keywordHPMCProvider
     * @param Keyword|Keywords|ModelCommonInterface $keywords
     */
    public static function setRelatedBidsAuto(ModelCommonInterface $keywords):void
    {
        $result = $keywords->setRelatedBidsAuto(
            BidAuto::make()
                ->setScope(['SEARCH'])
                ->setPosition('PREMIUMBLOCK')
        );

        // [ Post processing ]

        Checklists::checkResource($result, BidsAuto::class, [
            'KeywordId' => 'required|integer',
            'Scope' => 'required|array',
            'Position' => 'string'
        ]);
    }
}