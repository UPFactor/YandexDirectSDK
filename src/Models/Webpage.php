<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\WebpageConditions;
use YandexDirectSDK\Collections\Webpages;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Models\Foundation\On;
use YandexDirectSDK\Services\DynamicTextAdTargetsService;


/** 
 * Class Webpage 
 * 
 * @property          integer                   $id
 * @property          string                    $name
 * @property          integer                   $adGroupId
 * @property-read     integer                   $campaignId
 * @property          WebpageConditions         $conditions
 * @property-read     string                    $conditionType
 * @property          integer                   $bid
 * @property          integer                   $contextBid
 * @property          string                    $strategyPriority
 * @property-read     string                    $state
 * @property-read     string                    $statusClarification
 *                                              
 * @method static     QueryBuilder              query()
 * @method static     Webpage|Webpages|null     find(integer|integer[]|string|string[] $ids, string[] $fields=null)
 * @method            Result                    create()
 * @method            Result                    delete()
 * @method            Result                    resume()
 * @method            Result                    suspend()
 * @method            Result                    setRelatedBids($bid, $contextBid=null)
 * @method            Result                    setRelatedContextBids($contextBid)
 * @method            Result                    setRelatedStrategyPriority(string $strategyPriority)
 * @method            $this                     setId(integer $id)
 * @method            integer                   getId()
 * @method            $this                     setName(string $name)
 * @method            string                    getName()
 * @method            $this                     setAdGroupId(integer $adGroupId)
 * @method            integer                   getAdGroupId()
 * @method            integer                   getCampaignId()
 * @method            $this                     setConditions(WebpageConditions $conditions)
 * @method            WebpageConditions         getConditions()
 * @method            string                    getConditionType()
 * @method            $this                     setBid(integer $bid)
 * @method            integer                   getBid()
 * @method            $this                     setContextBid(integer $contextBid)
 * @method            integer                   getContextBid()
 * @method            $this                     setStrategyPriority(string $strategyPriority)
 * @method            string                    getStrategyPriority()
 * @method            string                    getState()
 * @method            string                    getStatusClarification()
 * 
 * @package YandexDirectSDK\Models 
 */
class Webpage extends Model 
{
    use On;

    const LOW = 'LOW';
    const NORMAL = 'NORMAL';
    const HIGH = 'HIGH';

    protected static $compatibleCollection = Webpages::class;

    protected static $staticMethods = [
        'query' => DynamicTextAdTargetsService::class,
        'find' => DynamicTextAdTargetsService::class
    ];

    protected static $methods = [
        'create' => DynamicTextAdTargetsService::class,
        'delete' => DynamicTextAdTargetsService::class,
        'resume' => DynamicTextAdTargetsService::class,
        'suspend' => DynamicTextAdTargetsService::class,
        'setRelatedBids' => DynamicTextAdTargetsService::class,
        'setRelatedContextBids' => DynamicTextAdTargetsService::class,
        'setRelatedStrategyPriority' => DynamicTextAdTargetsService::class
    ];

    protected static $properties = [
        'id' => 'integer',
        'name' => 'string',
        'adGroupId' => 'integer',
        'campaignId' => 'integer',
        'conditions' => 'object:' . WebpageConditions::class,
        'conditionType' => 'string',
        'bid' => 'integer',
        'contextBid' => 'integer',
        'strategyPriority' => 'enum:' . self::LOW . ',' . self::NORMAL . ',' . self::HIGH,
        'state' => 'string',
        'statusClarification' => 'string'
    ];

    protected static $nonWritableProperties = [
        'campaignId',
        'conditionType',
        'state',
        'statusClarification'
    ];

    protected static $nonAddableProperties = [
        'id'
    ];
}