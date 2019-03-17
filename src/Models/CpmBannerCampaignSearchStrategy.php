<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class CpmBannerCampaignSearchStrategy 
 * 
 * @property   string   $biddingStrategyType 
 * 
 * @method     $this    setBiddingStrategyType(string $biddingStrategyType) 
 * 
 * @method     string   getBiddingStrategyType() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class CpmBannerCampaignSearchStrategy extends Model 
{
    const SERVING_OFF = 'SERVING_OFF';

    protected $properties = [
        'biddingStrategyType' => 'enum:' . self::SERVING_OFF
    ];
}