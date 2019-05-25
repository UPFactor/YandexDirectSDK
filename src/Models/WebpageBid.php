<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\WebpageBids;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Services\DynamicTextAdTargetsService;

/** 
 * Class WebpageBid 
 * 
 * @property   integer   $id 
 * @property   integer   $campaignId 
 * @property   integer   $adGroupId 
 * @property   integer   $bid 
 * @property   integer   $contextBid 
 * @property   string    $strategyPriority 
 * 
 * @method     $this     setId(integer $id) 
 * @method     $this     setCampaignId(integer $campaignId) 
 * @method     $this     setAdGroupId(integer $adGroupId) 
 * @method     $this     setBid(integer $bid) 
 * @method     $this     setContextBid(integer $contextBid) 
 * @method     $this     setStrategyPriority(string $strategyPriority) 
 * 
 * @method     integer   getId() 
 * @method     integer   getCampaignId() 
 * @method     integer   getAdGroupId() 
 * @method     integer   getBid() 
 * @method     integer   getContextBid() 
 * @method     string    getStrategyPriority() 
 * 
 * @method     Result    setBids() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class WebpageBid extends Model 
{
    const LOW = 'LOW';
    const NORMAL = 'NORMAL';
    const HIGH = 'HIGH';

    protected $compatibleCollection = WebpageBids::class;

    protected $serviceProvidersMethods = [
        'setBids' => DynamicTextAdTargetsService::class
    ];

    protected $properties = [
        'id' => 'integer',
        'campaignId' => 'integer',
        'adGroupId' => 'integer',
        'bid' => 'integer',
        'contextBid' => 'integer',
        'strategyPriority' => 'enum:' . self::LOW . ',' . self::NORMAL . ',' . self::HIGH,
    ];

    protected $nonAddableProperties = [
        'id'
    ];
}