<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\AudienceTargetBids;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Models\Foundation\On;

/** 
 * Class AudienceTargetBid 
 * 
 * @property     integer     $id
 * @property     integer     $adGroupId
 * @property     integer     $campaignId
 * @property     integer     $contextBid
 * @property     string      $strategyPriority
 *                           
 * @method       $this       setId(integer $id)
 * @method       integer     getId()
 * @method       $this       setAdGroupId(integer $adGroupId)
 * @method       integer     getAdGroupId()
 * @method       $this       setCampaignId(integer $campaignId)
 * @method       integer     getCampaignId()
 * @method       $this       setContextBid(integer $contextBid)
 * @method       integer     getContextBid()
 * @method       $this       setStrategyPriority(string $strategyPriority)
 * @method       string      getStrategyPriority()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class AudienceTargetBid extends Model 
{
    use On;

    const LOW = 'LOW';
    const NORMAL = 'NORMAL';
    const HIGH = 'HIGH';

    protected static $compatibleCollection = AudienceTargetBids::class;

    protected static $properties = [
        'id' => 'integer',
        'adGroupId' => 'integer',
        'campaignId' => 'integer',
        'contextBid' => 'integer',
        'strategyPriority' => 'enum:' . self::LOW . ',' . self::NORMAL . ',' . self::HIGH,
    ];
}