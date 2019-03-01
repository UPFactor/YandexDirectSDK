<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class CpcVideoAdBuilderAd 
 * 
 * @property   AdBuilderAd   $creative 
 * @property   string        $href 
 * 
 * @method     $this         setCreative(AdBuilderAd $creative) 
 * @method     $this         setHref(string $href) 
 * 
 * @method     AdBuilderAd   getCreative() 
 * @method     string        getHref() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class CpcVideoAdBuilderAd extends Model 
{ 
    protected $serviceProvidersMethods = [];

    protected $properties = [
        'creative' => 'object:' . AdBuilderAd::class,
        'href' => 'string'
    ];

    protected $nonWritableProperties = [];

    protected $nonReadableProperties = [];

    protected $requiredProperties = [
        'creative',
        'href'
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