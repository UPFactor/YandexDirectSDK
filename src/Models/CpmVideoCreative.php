<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model;

/** 
 * Class CpmVideoCreative 
 * 
 * @property-read   integer   $duration
 * 
 * @method          integer   getDuration()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class CpmVideoCreative extends Model 
{
    protected static $properties = [
        'duration' => 'integer'
    ];

    protected static $nonWritableProperties = [
        'duration'
    ];
}