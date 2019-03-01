<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class MobileAppAdBuilderAd 
 * 
 * @property   AdBuilderAd   $creative 
 * @property   string        $trackingUrl 
 * 
 * @method     $this         setCreative(AdBuilderAd $creative) 
 * @method     $this         setTrackingUrl(string $trackingUrl) 
 * 
 * @method     AdBuilderAd   getCreative() 
 * @method     string        getTrackingUrl() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class MobileAppAdBuilderAd extends Model 
{ 
    protected $serviceProvidersMethods = []; 

    protected $properties = [
        'creative' => 'object:' . AdBuilderAd::class,
        'trackingUrl' => 'string'
    ];

    protected $nonWritableProperties = []; 

    protected $nonReadableProperties = []; 

    protected $requiredProperties = [
        'creative'
    ];

    /**
     * @param $creativeId
     * @return $this
     */
    public function setCreativeId($creativeId){
        $this->setCreative(
            AdBuilderAd::make()->setCreativeId($creativeId)
        );
        return $this;
    }
}