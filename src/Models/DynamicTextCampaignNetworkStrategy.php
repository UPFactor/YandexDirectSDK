<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class DynamicTextCampaignNetworkStrategy 
 * 
 * @property   string   $biddingStrategyType 
 * 
 * @method     $this    setBiddingStrategyType(string $biddingStrategyType) 
 * 
 * @method     string   getBiddingStrategyType() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class DynamicTextCampaignNetworkStrategy extends Model 
{
    const SERVING_OFF = 'SERVING_OFF';

    protected $properties = [
        'biddingStrategyType' => 'enum:'.self::SERVING_OFF
    ];

    protected $nonWritableProperties = [];

    protected $nonReadableProperties = [];

    protected $requiredProperties = [
        'biddingStrategyType'
    ];
}