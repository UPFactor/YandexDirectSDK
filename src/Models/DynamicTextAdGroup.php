<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class DynamicTextAdGroup 
 * 
 * @property        string   $domainUrl 
 * @property-read   string   $domainUrlProcessingStatus 
 * 
 * @method          $this    setDomainUrl(string $domainUrl) 
 * 
 * @method          string   getDomainUrl() 
 * @method          string   getDomainUrlProcessingStatus() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class DynamicTextAdGroup extends Model 
{ 
    protected $serviceProvidersMethods = []; 

    protected $properties = [
        'domainUrl' => 'string',
        'domainUrlProcessingStatus' => 'string'
    ];

    protected $nonWritableProperties = [
        'domainUrlProcessingStatus'
    ];

    protected $nonReadableProperties = []; 

    protected $requiredProperties = [
        'domainUrl'
    ];
}