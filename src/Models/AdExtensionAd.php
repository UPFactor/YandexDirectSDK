<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class AdExtensionAd 
 * 
 * @property-read   integer   $adExtensionId 
 * @property-read   string    $type 
 * 
 * @method          integer   getAdExtensionId() 
 * @method          string    getType() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class AdExtensionAd extends Model 
{ 
    protected $serviceProvidersMethods = []; 

    protected $properties = [
        'adExtensionId' => 'integer',
        'type' => 'string'
    ];

    protected $nonWritableProperties = [
        'adExtensionId',
        'type'
    ];

    protected $nonReadableProperties = []; 

    protected $requiredProperties = []; 
}