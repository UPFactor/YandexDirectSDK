<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\WebpageConditions;
use YandexDirectSDK\Collections\Webpages;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Services\DynamicTextAdTargetsService;


/** 
 * Class Webpage 
 * 
 * @property            integer             $id
 * @property            string              $name
 * @property            integer             $adGroupId
 * @property            WebpageConditions   $conditions
 * @property            integer             $bid
 * @property            integer             $contextBid
 * @property            string              $strategyPriority
 * 
 * @property-readable   integer             $campaignId
 * @property-readable   string              $conditionType
 * @property-readable   string              $state
 * @property-readable   string              $statusClarification
 * 
 * @method              Result              add()
 * @method              Result              delete()
 * @method              QueryBuilder        query()
 * @method              Result              resume()
 * @method              Result              suspend()
 * @method              Result              setRelatedBids($bid, $contextBid = null)
 * @method              Result              setRelatedContextBids($contextBid)
 * @method              Result              setRelatedStrategyPriority(string $strategyPriority)
 * 
 * @method              $this               setId(integer $id)
 * @method              $this               setName(string $name)
 * @method              $this               setAdGroupId(integer $adGroupId)
 * @method              $this               setConditions(WebpageConditions $conditions)
 * @method              $this               setBid(integer $bid)
 * @method              $this               setContextBid(integer $contextBid)
 * @method              $this               setStrategyPriority(string $strategyPriority)
 * 
 * @method              integer             getId()
 * @method              string              getName()
 * @method              integer             getAdGroupId()
 * @method              integer             getCampaignId()
 * @method              WebpageConditions   getConditions()
 * @method              string              getConditionType()
 * @method              integer             getBid()
 * @method              integer             getContextBid()
 * @method              string              getStrategyPriority()
 * @method              string              getState()
 * @method              string              getStatusClarification()
 * 
 * @package YandexDirectSDK\Models 
 */
class Webpage extends Model 
{
    const LOW = 'LOW';
    const NORMAL = 'NORMAL';
    const HIGH = 'HIGH';

    protected $compatibleCollection = Webpages::class;

    protected $serviceProvidersMethods = [
        'add' => DynamicTextAdTargetsService::class,
        'delete' => DynamicTextAdTargetsService::class,
        'query' => DynamicTextAdTargetsService::class,
        'resume' => DynamicTextAdTargetsService::class,
        'suspend' => DynamicTextAdTargetsService::class,
        'setRelatedBids' => DynamicTextAdTargetsService::class,
        'setRelatedContextBids' => DynamicTextAdTargetsService::class,
        'setRelatedStrategyPriority' => DynamicTextAdTargetsService::class
    ];

    protected $properties = [
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

    protected $nonWritableProperties = [
        'campaignId',
        'conditionType',
        'state',
        'statusClarification'
    ];

    protected $nonAddableProperties = [
        'id'
    ];
}