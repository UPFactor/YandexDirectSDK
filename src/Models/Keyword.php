<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\Keywords;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Services\KeywordsService;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;

/** 
 * Class Keyword 
 * 
 * @property        integer        $id
 * @property        integer        $adGroupId
 * @property        string         $keyword
 * @property        integer        $bid
 * @property        integer        $contextBid
 * @property        string         $strategyPriority
 * @property        string         $userParam1
 * @property        string         $userParam2
 * 
 * @property-read   integer        $campaignId
 * @property-read   string         $status
 * @property-read   string         $servingStatus
 * @property-read   string         $state
 * @property-read   Statistics     $statisticsSearch
 * @property-read   Statistics     $statisticsNetwork
 * 
 * @method          Result         add()
 * @method          Result         delete()
 * @method          QueryBuilder   query()
 * @method          Result         resume()
 * @method          Result         suspend()
 * @method          Result         update()
 * @method          Result         setRelatedBids($bid, $contextBid = null)
 * @method          Result         setRelatedContextBids($contextBid)
 * @method          Result         setRelatedStrategyPriority(string $strategyPriority)
 * @method          Result         setRelatedBidsAuto(ModelCommonInterface $bidsAuto)
 * @method          Result         getRelatedBids(array $fields)
 * 
 * @method          $this          setId(integer $id)
 * @method          $this          setAdGroupId(integer $adGroupId)
 * @method          $this          setKeyword(string $keyword)
 * @method          $this          setBid(integer $bid)
 * @method          $this          setContextBid(integer $contextBid)
 * @method          $this          setStrategyPriority(string $strategyPriority)
 * @method          $this          setUserParam1(string $userParam1)
 * @method          $this          setUserParam2(string $userParam2)
 * 
 * @method          integer        getId()
 * @method          integer        getAdGroupId()
 * @method          integer        getCampaignId()
 * @method          string         getKeyword()
 * @method          integer        getBid()
 * @method          integer        getContextBid()
 * @method          string         getStrategyPriority()
 * @method          string         getUserParam1()
 * @method          string         getUserParam2()
 * @method          string         getStatus()
 * @method          string         getServingStatus()
 * @method          string         getState()
 * @method          Statistics     getStatisticsSearch()
 * @method          Statistics     getStatisticsNetwork()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class Keyword extends Model 
{
    const LOW = 'LOW';
    const NORMAL = 'NORMAL';
    const HIGH = 'HIGH';

    protected static $compatibleCollection = Keywords::class;

    protected static $serviceMethods = [
        'add' => KeywordsService::class,
        'delete' => KeywordsService::class,
        'query' => KeywordsService::class,
        'resume' => KeywordsService::class,
        'suspend' => KeywordsService::class,
        'update' => KeywordsService::class,
        'setRelatedBids' => KeywordsService::class,
        'setRelatedContextBids' => KeywordsService::class,
        'setRelatedStrategyPriority' => KeywordsService::class,
        'setRelatedBidsAuto' => KeywordsService::class,
        'getRelatedBids' => KeywordsService::class
    ];

    protected static $properties = [
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

    protected static $nonUpdatableProperties = [
        'adGroupId',
        'bid',
        'contextBid',
        'strategyPriority'
    ];

    protected static $nonWritableProperties = [
        'campaignId',
        'status',
        'servingStatus',
        'state',
        'statisticsSearch',
        'statisticsNetwork'
    ];

    protected static $nonAddableProperties = [
        'id'
    ];
}