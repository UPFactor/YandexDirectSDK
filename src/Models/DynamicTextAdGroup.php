<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class DynamicTextAdGroup 
 * 
 * @property          string     $domainUrl
 * @property-read     string     $domainUrlProcessingStatus
 *                               
 * @method            $this      setDomainUrl(string $domainUrl)
 * @method            string     getDomainUrl()
 * @method            string     getDomainUrlProcessingStatus()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class DynamicTextAdGroup extends Model 
{ 
    protected static $properties = [
        'domainUrl' => 'string',
        'domainUrlProcessingStatus' => 'string'
    ];

    protected static $nonWritableProperties = [
        'domainUrlProcessingStatus'
    ];
}