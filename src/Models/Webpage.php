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
 * @property        string              $name 
 * @property        integer             $adGroupId 
 * @property-read   integer             $campaignId 
 * @property        WebpageConditions   $conditions 
 * @property-read   string              $conditionType 
 * @property        integer             $bid 
 * @property        integer             $contextBid 
 * @property        string              $strategyPriority 
 * @property-read   string              $state 
 * @property-read   string              $statusClarification 
 * 
 * @method          $this               setName(string $name) 
 * @method          $this               setAdGroupId(integer $adGroupId) 
 * @method          $this               setConditions(WebpageConditions $conditions) 
 * @method          $this               setBid(integer $bid) 
 * @method          $this               setContextBid(integer $contextBid) 
 * @method          $this               setStrategyPriority(string $strategyPriority) 
 * 
 * @method          string              getName() 
 * @method          integer             getAdGroupId() 
 * @method          integer             getCampaignId() 
 * @method          WebpageConditions   getConditions() 
 * @method          string              getConditionType() 
 * @method          integer             getBid() 
 * @method          integer             getContextBid() 
 * @method          string              getStrategyPriority() 
 * @method          string              getState() 
 * @method          string              getStatusClarification() 
 * 
 * @method          Result              add() 
 * @method          Result              delete() 
 * @method          QueryBuilder        query() 
 * @method          Result              resume() 
 * @method          Result              suspend() 
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
        'suspend' => DynamicTextAdTargetsService::class
    ];

    protected $properties = [
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
        'state',
        'statusClarification',
        'conditionType'
    ];

    protected $nonReadableProperties = []; 

    protected $requiredProperties = [
        'name',
        'adGroupId'
    ];
}