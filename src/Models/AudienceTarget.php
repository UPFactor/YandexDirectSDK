<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\AudienceTargets;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Services\AudienceTargetsService;

/** 
 * Class AudienceTarget 
 * 
 * @property        integer        $id
 * @property        integer        $adGroupId
 * @property        integer        $retargetingListId
 * @property        integer        $interestId
 * @property        integer        $contextBid
 * @property        string         $strategyPriority
 * 
 * @property-read   integer        $campaignId
 * @property-read   string         $state
 * 
 * @method          Result         add()
 * @method          Result         delete()
 * @method          QueryBuilder   query()
 * @method          Result         resume()
 * @method          Result         suspend()
 * @method          Result         setRelatedContextBids($contextBid)
 * @method          Result         setRelatedStrategyPriority($strategyPriority)
 * 
 * @method          $this          setId(integer $id)
 * @method          $this          setAdGroupId(integer $adGroupId)
 * @method          $this          setRetargetingListId(integer $retargetingListId)
 * @method          $this          setInterestId(integer $interestId)
 * @method          $this          setContextBid(integer $contextBid)
 * @method          $this          setStrategyPriority(string $strategyPriority)
 * 
 * @method          integer        getId()
 * @method          integer        getAdGroupId()
 * @method          integer        getCampaignId()
 * @method          integer        getRetargetingListId()
 * @method          integer        getInterestId()
 * @method          integer        getContextBid()
 * @method          string         getStrategyPriority()
 * @method          string         getState()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class AudienceTarget extends Model 
{
    const LOW = 'LOW';
    const NORMAL = 'NORMAL';
    const HIGH = 'HIGH';

    protected static $compatibleCollection = AudienceTargets::class;

    protected static $staticMethods = [
        'query' => AudienceTargetsService::class,
        'find' => AudienceTargetsService::class
    ];

    protected static $methods = [
        'add' => AudienceTargetsService::class,
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