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
 * @property        integer        $campaignId 
 * @property        integer        $adGroupId 
 * @property        integer        $keywordId 
 * @property        integer        $searchBid 
 * @property        integer        $networkBid 
 * @property        string         $strategyPriority 
 * @property-read   string         $servingStatus 
 * @property-read   Search         $search 
 * @property-read   Network        $network 
 * 
 * @method          $this          setCampaignId(integer $campaignId) 
 * @method          $this          setAdGroupId(integer $adGroupId) 
 * @method          $this          setKeywordId(integer $keywordId) 
 * @method          $this          setSearchBid(integer $searchBid) 
 * @method          $this          setNetworkBid(integer $networkBid) 
 * @method          $this          setStrategyPriority(string $strategyPriority) 
 * 
 * @method          integer        getCampaignId() 
 * @method          integer        getAdGroupId() 
 * @method          integer        getKeywordId() 
 * @method          integer        getSearchBid() 
 * @method          integer        getNetworkBid() 
 * @method          string         getStrategyPriority() 
 * @method          string         getServingStatus() 
 * @method          Search         getSearch() 
 * @method          Network        getNetwork() 
 * 
 * @method          QueryBuilder   query() 
 * @method          Result         set() 
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
        'networkBid' => 'integer',
        'strategyPriority' => 'enum:' . self::LOW . ',' . self::NORMAL . ',' . self::HIGH,
        'servingStatus' => 'string',
        'search' => 'object:' . Search::class,
        'network' => 'object:' . Network::class

    ];

    protected $nonWritableProperties = [
        'servingStatus',
        'search',
        'network'
    ];

    protected $nonReadableProperties = []; 

    protected $requiredProperties = [
        'campaignId|adGroupId|keywordId',
        'searchBid|networkBid|strategyPriority'
    ];
}