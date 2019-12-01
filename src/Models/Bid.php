<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\AuctionBids;
use YandexDirectSDK\Collections\Bids;
use YandexDirectSDK\Collections\ContextCoverages;
use YandexDirectSDK\Collections\SearchPrices;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Services\BidsService;

/** 
 * Class Bid 
 * 
 * @property          integer              $campaignId
 * @property          integer              $adGroupId
 * @property          integer              $keywordId
 * @property-read     string               $servingStatus
 * @property          integer              $bid
 * @property          integer              $contextBid
 * @property          string               $strategyPriority
 * @property-read     integer[]            $competitorsBids
 * @property-read     SearchPrices         $searchPrices
 * @property-read     ContextCoverages     $contextCoverage
 * @property-read     integer              $minSearchPrice
 * @property-read     integer              $currentSearchPrice
 * @property-read     AuctionBids          $auctionBids
 *                                         
 * @method static     QueryBuilder         query()
 * @method            $this                setCampaignId(integer $campaignId)
 * @method            integer              getCampaignId()
 * @method            $this                setAdGroupId(integer $adGroupId)
 * @method            integer              getAdGroupId()
 * @method            $this                setKeywordId(integer $keywordId)
 * @method            integer              getKeywordId()
 * @method            string               getServingStatus()
 * @method            $this                setBid(integer $bid)
 * @method            integer              getBid()
 * @method            $this                setContextBid(integer $contextBid)
 * @method            integer              getContextBid()
 * @method            $this                setStrategyPriority(string $strategyPriority)
 * @method            string               getStrategyPriority()
 * @method            integer[]            getCompetitorsBids()
 * @method            SearchPrices         getSearchPrices()
 * @method            ContextCoverages     getContextCoverage()
 * @method            integer              getMinSearchPrice()
 * @method            integer              getCurrentSearchPrice()
 * @method            AuctionBids          getAuctionBids()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class Bid extends Model 
{
    const LOW = 'LOW';
    const NORMAL = 'NORMAL';
    const HIGH = 'HIGH';

    protected static $compatibleCollection = Bids::class;

    protected static $staticMethods = [
        'query' => BidsService::class
    ];

    protected static $properties = [
        'campaignId' => 'integer',
        'adGroupId' => 'integer',
        'keywordId' => 'integer',
        'servingStatus' => 'string',
        'bid' => 'integer',
        'contextBid' => 'integer',
        'strategyPriority' => 'enum:' . self::LOW . ',' . self::NORMAL . ',' . self::HIGH,
        'competitorsBids' => 'stack:integer',
        'searchPrices' => 'object:' . SearchPrices::class,
        'contextCoverage' => 'arrayOfObject:' . ContextCoverages::class,
        'minSearchPrice' => 'integer',
        'currentSearchPrice' => 'integer',
        'auctionBids' => 'object:' . AuctionBids::class
    ];

    protected static $nonWritableProperties = [
        'servingStatus',
        'competitorsBids',
        'searchPrices',
        'contextCoverage',
        'minSearchPrice',
        'currentSearchPrice',
        'auctionBids'
    ];

    public function apply():Result
    {
        return BidsService::set($this);
    }
}