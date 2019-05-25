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
 * @property            integer        $id 
 * @property            integer        $adGroupId 
 * @property-readable   integer        $campaignId 
 * @property            integer        $retargetingListId 
 * @property            integer        $interestId 
 * @property            integer        $contextBid 
 * @property            string         $strategyPriority 
 * @property-readable   string         $state 
 * 
 * @method              $this          setId(integer $id) 
 * @method              $this          setAdGroupId(integer $adGroupId) 
 * @method              $this          setRetargetingListId(integer $retargetingListId) 
 * @method              $this          setInterestId(integer $interestId) 
 * @method              $this          setContextBid(integer $contextBid) 
 * @method              $this          setStrategyPriority(string $strategyPriority) 
 * 
 * @method              integer        getId() 
 * @method              integer        getAdGroupId() 
 * @method              integer        getCampaignId() 
 * @method              integer        getRetargetingListId() 
 * @method              integer        getInterestId() 
 * @method              integer        getContextBid() 
 * @method              string         getStrategyPriority() 
 * @method              string         getState() 
 * 
 * @method              Result         add() 
 * @method              Result         delete() 
 * @method              QueryBuilder   query() 
 * @method              Result         resume() 
 * @method              Result         suspend() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class AudienceTarget extends Model 
{
    const LOW = 'LOW';
    const NORMAL = 'NORMAL';
    const HIGH = 'HIGH';

    protected $compatibleCollection = AudienceTargets::class;

    protected $serviceProvidersMethods = [
        'add' => AudienceTargetsService::class,
        'delete' => AudienceTargetsService::class,
        'query' => AudienceTargetsService::class,
        'resume' => AudienceTargetsService::class,
        'suspend' => AudienceTargetsService::class
    ];

    protected $properties = [
        'id' => 'integer',
        'adGroupId' => 'integer',
        'campaignId' => 'integer',
        'retargetingListId' => 'integer',
        'interestId' => 'integer',
        'contextBid' => 'integer',
        'strategyPriority' => 'enum:' . self::LOW . ',' . self::NORMAL . ',' . self::HIGH,
        'state' => 'string'
    ];

    protected $nonWritableProperties = [
        'campaignId',
        'state'
    ];

    protected $nonAddableProperties = [
        'id'
    ];
}