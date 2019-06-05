<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class ExtensionModeration 
 * 
 * @property-readable   string   $status
 * @property-readable   string   $statusClarification
 * 
 * @method              string   getStatus()
 * @method              string   getStatusClarification()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class ExtensionModeration extends Model 
{ 
    protected $properties = [
        'status' => 'string',
        'statusClarification' => 'string'
    ];

    protected $nonWritableProperties = [
        'status',
        'statusClarification'
    ];
}