<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\WebpageBids;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Services\DynamicTextAdTargetsService;

/**  
 * Class WebpageBid 
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
}