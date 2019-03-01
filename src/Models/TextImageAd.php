<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class TextImageAd 
 * 
 * @property   string   $href 
 * @property   string   $adImageHash 
 * 
 * @method     $this    setHref(string $href) 
 * @method     $this    setAdImageHash(string $adImageHash) 
 * 
 * @method     string   getHref() 
 * @method     string   getAdImageHash() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class TextImageAd extends Model 
{ 
    protected $serviceProvidersMethods = []; 

    protected $properties = [
        'href' => 'string',
        'adImageHash' => 'string'
    ];

    protected $nonWritableProperties = []; 

    protected $nonReadableProperties = []; 

    protected $requiredProperties = [
        'href',
        'adImageHash'
    ];
}