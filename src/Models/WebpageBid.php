<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\WebpageBids;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Services\DynamicTextAdTargetsService;

/** 
 * Class WebpageBid 
 * 
 * @property     integer     $id
 * @property     integer     $campaignId
 * @property     integer     $adGroupId
 * @property     integer     $bid
 * @property     integer     $contextBid
 * @property     string      $strategyPriority
 *                           
 * @method       $this       setId(integer $id)
 * @method       integer     getId()
 * @method       $this       setCampaignId(integer $campaignId)
 * @method       integer     getCampaignId()
 * @method       $this       setAdGroupId(integer $adGroupId)
 * @method       integer     getAdGroupId()
 * @method       $this       setBid(integer $bid)
 * @method       integer     getBid()
 * @method       $this       setContextBid(integer $contextBid)
 * @method       integer     getContextBid()
 * @method       $this       setStrategyPriority(string $strategyPriority)
 * @method       string      getStrategyPriority()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class WebpageBid extends Model 
{
    const LOW = 'LOW';
    const NORMAL = 'NORMAL';
    const HIGH = 'HIGH';

    protected static $compatibleCollection = WebpageBids::class;

    protected static $properties = [
        'id' => 'integer',
        'campaignId' => 'integer',
        'adGroupId' => 'integer',
        'bid' => 'integer',
        'contextBid' => 'integer',
        'strategyPriority' => 'enum:' . self::LOW . ',' . self::NORMAL . ',' . self::HIGH,
    ];

    protected static $nonAddableProperties = [
        'id'
    ];

    public function apply():Result
    {
        return DynamicTextAdTargetsService::setBids($this);
    }
}