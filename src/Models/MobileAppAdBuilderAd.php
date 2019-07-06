<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class MobileAppAdBuilderAd 
 * 
 * @property          AdBuilderAd   $creative
 * @property          string        $trackingUrl
 * 
 * @method            $this         setCreative(AdBuilderAd $creative)
 * @method            $this         setTrackingUrl(string $trackingUrl)
 * 
 * @method            AdBuilderAd   getCreative()
 * @method            string        getTrackingUrl()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class MobileAppAdBuilderAd extends Model 
{ 
    protected static $properties = [
        'creative' => 'object:' . AdBuilderAd::class,
        'trackingUrl' => 'string'
    ];
}