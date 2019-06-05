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
 * @property            integer            $campaignId
 * @property            integer            $adGroupId
 * @property            integer            $keywordId
 * @property            integer            $bid
 * @property            integer            $contextBid
 * @property            string             $strategyPriority
 * 
 * @property-readable   string             $servingStatus
 * @property-readable   integer[]          $competitorsBids
 * @property-readable   SearchPrices       $searchPrices
 * @property-readable   ContextCoverages   $contextCoverage
 * @property-readable   integer            $minSearchPrice
 * @property-readable   integer            $currentSearchPrice
 * @property-readable   AuctionBids        $auctionBids
 * 
 * @method              QueryBuilder       query()
 * @method              Result             set()
 * 
 * @method              $this              setCampaignId(integer $campaignId)
 * @method              $this              setAdGroupId(integer $adGroupId)
 * @method              $this              setKeywordId(integer $keywordId)
 * @method              $this              setBid(integer $bid)
 * @method              $this              setContextBid(integer $contextBid)
 * @method              $this              setStrategyPriority(string $strategyPriority)
 * 
 * @method              integer            getCampaignId()
 * @method              integer            getAdGroupId()
 * @method              integer            getKeywordId()
 * @method              string             getServingStatus()
 * @method              integer            getBid()
 * @method              integer            getContextBid()
 * @method              string             getStrategyPriority()
 * @method              integer[]          getCompetitorsBids()
 * @method              SearchPrices       getSearchPrices()
 * @method              ContextCoverages   getContextCoverage()
 * @method              integer            getMinSearchPrice()
 * @method              integer            getCurrentSearchPrice()
 * @method              AuctionBids        getAuctionBids()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class Bid extends Model 
{
    const LOW = 'LOW';
    const NORMAL = 'NORMAL';
    const HIGH = 'HIGH';

    protected $compatibleCollection = Bids::class;

    protected $serviceProvidersMethods = [
        'query' => BidsService::class,
        'set' => BidsService::class
    ];

    protected $properties = [
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

    protected $nonWritableProperties = [
        'servingStatus',
        'competitorsBids',
        'searchPrices',
        'contextCoverage',
        'minSearchPrice',
        'currentSearchPrice',
        'auctionBids'
    ];
}