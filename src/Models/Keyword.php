<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\Keywords;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Services\KeywordsService;
use YandexDirectSDK\Interfaces\ModelCommon;

/** 
 * Class Keyword 
 * 
 * @property            integer        $id 
 * @property            integer        $adGroupId 
 * @property-readable   integer        $campaignId 
 * @property            string         $keyword 
 * @property            integer        $bid 
 * @property            integer        $contextBid 
 * @property            string         $strategyPriority 
 * @property            string         $userParam1 
 * @property            string         $userParam2 
 * @property-readable   string         $status 
 * @property-readable   string         $servingStatus 
 * @property-readable   string         $state 
 * @property-readable   Statistics     $statisticsSearch 
 * @property-readable   Statistics     $statisticsNetwork 
 * 
 * @method              $this          setId(integer $id) 
 * @method              $this          setAdGroupId(integer $adGroupId) 
 * @method              $this          setKeyword(string $keyword) 
 * @method              $this          setBid(integer $bid) 
 * @method              $this          setContextBid(integer $contextBid) 
 * @method              $this          setStrategyPriority(string $strategyPriority) 
 * @method              $this          setUserParam1(string $userParam1) 
 * @method              $this          setUserParam2(string $userParam2) 
 * 
 * @method              integer        getId() 
 * @method              integer        getAdGroupId() 
 * @method              integer        getCampaignId() 
 * @method              string         getKeyword() 
 * @method              integer        getBid() 
 * @method              integer        getContextBid() 
 * @method              string         getStrategyPriority() 
 * @method              string         getUserParam1() 
 * @method              string         getUserParam2() 
 * @method              string         getStatus() 
 * @method              string         getServingStatus() 
 * @method              string         getState() 
 * @method              Statistics     getStatisticsSearch() 
 * @method              Statistics     getStatisticsNetwork() 
 * 
 * @method              Result         add() 
 * @method              Result         delete() 
 * @method              QueryBuilder   query() 
 * @method              Result         resume() 
 * @method              Result         suspend() 
 * @method              Result         update() 
 * @method              Result         setRelatedBids(ModelCommon $bids) 
 * @method              Result         setRelatedBidsAuto(ModelCommon $bidsAuto) 
 * @method              Result         getRelatedBids(array $fields) 
 * @method              Result         setRelatedKeywordBids(ModelCommon $keywordBids) 
 * @method              Result         setRelatedKeywordBidsAuto(ModelCommon $keywordsBidsAuto) 
 * @method              Result         getRelatedKeywordBids(array $fields) 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class Keyword extends Model 
{
    const LOW = 'LOW';
    const NORMAL = 'NORMAL';
    const HIGH = 'HIGH';

    protected $compatibleCollection = Keywords::class;

    protected $serviceProvidersMethods = [
        'add' => KeywordsService::class,
        'delete' => KeywordsService::class,
        'query' => KeywordsService::class,
        'resume' => KeywordsService::class,
        'suspend' => KeywordsService::class,
        'update' => KeywordsService::class,
        'setRelatedBids' => KeywordsService::class,
        'setRelatedBidsAuto' => KeywordsService::class,
        'getRelatedBids' => KeywordsService::class,
        'setRelatedKeywordBids' => KeywordsService::class,
        'setRelatedKeywordBidsAuto' => KeywordsService::class,
        'getRelatedKeywordBids' => KeywordsService::class
    ];

    protected $properties = [
        'id' => 'integer',
        'adGroupId' => 'integer',
        'campaignId' => 'integer',
        'keyword' => 'string',
        'bid' => 'integer',
        'contextBid' => 'integer',
        'strategyPriority' => 'enum:' . self::LOW . ',' . self::NORMAL . ',' . self::HIGH,
        'userParam1' => 'string',
        'userParam2' => 'string',
        'status' => 'string',
        'servingStatus' => 'string',
        'state' => 'string',
        'statisticsSearch' => 'object:' . Statistics::class,
        'statisticsNetwork' => 'object:' . Statistics::class
    ];

    protected $nonUpdatableProperties = [
        'adGroupId',
        'bid',
        'contextBid',
        'strategyPriority'
    ];

    protected $nonWritableProperties = [
        'campaignId',
        'status',
        'servingStatus',
        'state',
        'statisticsSearch',
        'statisticsNetwork'
    ];
}