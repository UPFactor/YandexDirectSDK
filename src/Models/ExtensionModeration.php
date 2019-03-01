<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class ExtensionModeration 
 * 
 * @property-read   string   $status 
 * @property-read   string   $statusClarification 
 * 
 * @method          string   getStatus() 
 * @method          string   getStatusClarification() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class ExtensionModeration extends Model 
{ 
    protected $serviceProvidersMethods = []; 

    protected $properties = [
        'status' => 'string',
        'statusClarification' => 'string'
    ];

    protected $nonWritableProperties = [
        'status',
        'statusClarification'
    ];

    protected $nonReadableProperties = []; 

    protected $requiredProperties = []; 
}