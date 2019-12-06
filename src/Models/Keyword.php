<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\Bids;
use YandexDirectSDK\Collections\Keywords;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Models\Foundation\To;
use YandexDirectSDK\Services\KeywordsService;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;

/** 
 * Class Keyword 
 * 
 * @property          integer                   $id
 * @property          integer                   $adGroupId
 * @property-read     integer                   $campaignId
 * @property          string                    $keyword
 * @property          integer                   $bid
 * @property          integer                   $contextBid
 * @property          string                    $strategyPriority
 * @property          string                    $userParam1
 * @property          string                    $userParam2
 * @property-read     string                    $status
 * @property-read     string                    $servingStatus
 * @property-read     string                    $state
 * @property-read     Statistics                $statisticsSearch
 * @property-read     Statistics                $statisticsNetwork
 *                                              
 * @method static     QueryBuilder              query()
 * @method static     Keyword|Keywords|null     find(integer|integer[]|string|string[] $ids, string[] $fields=null)
 * @method            Result                    create()
 * @method            Result                    delete()
 * @method            Result                    resume()
 * @method            Result                    suspend()
 * @method            Result                    update()
 * @method            Result                    setRelatedBids($bid, $contextBid=null)
 * @method            Result                    setRelatedContextBids($contextBid)
 * @method            Result                    setRelatedStrategyPriority(string $strategyPriority)
 * @method            Result                    setRelatedBidsAuto(ModelCommonInterface $bidsAuto)
 * @method            Bids                      getRelatedBids(array $fields=[])
 * @method            $this                     setId(integer $id)
 * @method            integer                   getId()
 * @method            $this                     setAdGroupId(integer $adGroupId)
 * @method            integer                   getAdGroupId()
 * @method            integer                   getCampaignId()
 * @method            $this                     setKeyword(string $keyword)
 * @method            string                    getKeyword()
 * @method            $this                     setBid(integer $bid)
 * @method            integer                   getBid()
 * @method            $this                     setContextBid(integer $contextBid)
 * @method            integer                   getContextBid()
 * @method            $this                     setStrategyPriority(string $strategyPriority)
 * @method            string                    getStrategyPriority()
 * @method            $this                     setUserParam1(string $userParam1)
 * @method            string                    getUserParam1()
 * @method            $this                     setUserParam2(string $userParam2)
 * @method            string                    getUserParam2()
 * @method            string                    getStatus()
 * @method            string                    getServingStatus()
 * @method            string                    getState()
 * @method            Statistics                getStatisticsSearch()
 * @method            Statistics                getStatisticsNetwork()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class Keyword extends Model 
{
    use To;

    const LOW = 'LOW';
    const NORMAL = 'NORMAL';
    const HIGH = 'HIGH';

    protected static $compatibleCollection = Keywords::class;

    protected static $staticMethods = [
        'query' => KeywordsService::class,
        'find' => KeywordsService::class
    ];

    protected static $methods = [
        'create' => KeywordsService::class,
        'delete' => KeywordsService::class,
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