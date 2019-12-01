<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\AudienceTargets;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Models\Foundation\On;
use YandexDirectSDK\Services\AudienceTargetsService;

/** 
 * Class AudienceTarget 
 * 
 * @property          integer                                 $id
 * @property          integer                                 $adGroupId
 * @property-read     integer                                 $campaignId
 * @property          integer                                 $retargetingListId
 * @property          integer                                 $interestId
 * @property          integer                                 $contextBid
 * @property          string                                  $strategyPriority
 * @property-read     string                                  $state
 *                                                            
 * @method static     QueryBuilder                            query()
 * @method static     AudienceTarget|AudienceTargets|null     find(integer|integer[]|string|string[] $ids, string[] $fields=null)
 * @method            Result                                  create()
 * @method            Result                                  delete()
 * @method            Result                                  resume()
 * @method            Result                                  suspend()
 * @method            Result                                  setRelatedContextBids($contextBid)
 * @method            Result                                  setRelatedStrategyPriority($strategyPriority)
 * @method            $this                                   setId(integer $id)
 * @method            integer                                 getId()
 * @method            $this                                   setAdGroupId(integer $adGroupId)
 * @method            integer                                 getAdGroupId()
 * @method            integer                                 getCampaignId()
 * @method            $this                                   setRetargetingListId(integer $retargetingListId)
 * @method            integer                                 getRetargetingListId()
 * @method            $this                                   setInterestId(integer $interestId)
 * @method            integer                                 getInterestId()
 * @method            $this                                   setContextBid(integer $contextBid)
 * @method            integer                                 getContextBid()
 * @method            $this                                   setStrategyPriority(string $strategyPriority)
 * @method            string                                  getStrategyPriority()
 * @method            string                                  getState()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class AudienceTarget extends Model 
{
    use On;

    const LOW = 'LOW';
    const NORMAL = 'NORMAL';
    const HIGH = 'HIGH';

    protected static $compatibleCollection = AudienceTargets::class;

    protected static $staticMethods = [
        'query' => AudienceTargetsService::class,
        'find' => AudienceTargetsService::class
    ];

    protected static $methods = [
        'create' => AudienceTargetsService::class,
        'delete' => AudienceTargetsService::class,
        'resume' => AudienceTargetsService::class,
        'suspend' => AudienceTargetsService::class,
        'setRelatedContextBids' => AudienceTargetsService::class,
        'setRelatedStrategyPriority' => AudienceTargetsService::class
    ];

    protected static $properties = [
        'id' => 'integer',
        'adGroupId' => 'integer',
        'campaignId' => 'integer',
        'retargetingListId' => 'integer',
        'interestId' => 'integer',
        'contextBid' => 'integer',
        'strategyPriority' => 'enum:' . self::LOW . ',' . self::NORMAL . ',' . self::HIGH,
        'state' => 'string'
    ];

    protected static $nonWritableProperties = [
        'campaignId',
        'state'
    ];

    protected static $nonAddableProperties = [
        'id'
    ];
}