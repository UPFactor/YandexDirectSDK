<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class MobileAppImageAd 
 * 
 * @property          string   $trackingUrl
 * @property          string   $adImageHash
 * 
 * @method            $this    setTrackingUrl(string $trackingUrl)
 * @method            $this    setAdImageHash(string $adImageHash)
 * 
 * @method            string   getTrackingUrl()
 * @method            string   getAdImageHash()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class MobileAppImageAd extends Model 
{ 
    protected static $properties = [
        'trackingUrl' => 'string',
        'adImageHash' => 'string'
    ];
}