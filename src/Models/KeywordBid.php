<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\KeywordBids;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Services\KeywordBidsService;

/** 
 * Class KeywordBid 
 * 
 * @property            integer        $campaignId
 * @property            integer        $adGroupId
 * @property            integer        $keywordId
 * @property            integer        $searchBid
 * @property            integer        $networkBid
 * @property            string         $strategyPriority
 * 
 * @property-readable   Search         $search
 * @property-readable   Network        $network
 * @property-readable   string         $servingStatus
 * 
 * @method              QueryBuilder   query()
 * @method              Result         set()
 * 
 * @method              $this          setCampaignId(integer $campaignId)
 * @method              $this          setAdGroupId(integer $adGroupId)
 * @method              $this          setKeywordId(integer $keywordId)
 * @method              $this          setSearchBid(integer $searchBid)
 * @method              $this          setNetworkBid(integer $networkBid)
 * @method              $this          setStrategyPriority(string $strategyPriority)
 * 
 * @method              integer        getCampaignId()
 * @method              integer        getAdGroupId()
 * @method              integer        getKeywordId()
 * @method              integer        getSearchBid()
 * @method              Search         getSearch()
 * @method              integer        getNetworkBid()
 * @method              Network        getNetwork()
 * @method              string         getStrategyPriority()
 * @method              string         getServingStatus()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class KeywordBid extends Model 
{
    const LOW = 'LOW';
    const NORMAL = 'NORMAL';
    const HIGH = 'HIGH';

    protected $compatibleCollection = KeywordBids::class;

    protected $serviceProvidersMethods = [
        'query' => KeywordBidsService::class,
        'set' => KeywordBidsService::class
    ];

    protected $properties = [
        'campaignId' => 'integer',
        'adGroupId' => 'integer',
        'keywordId' => 'integer',
        'searchBid' => 'integer',
        'search' => 'object:' . Search::class,
        'networkBid' => 'integer',
        'network' => 'object:' . Network::class,
        'strategyPriority' => 'enum:' . self::LOW . ',' . self::NORMAL . ',' . self::HIGH,
        'servingStatus' => 'string'
    ];

    protected $nonWritableProperties = [
        'search',
        'network',
        'servingStatus'
    ];
}