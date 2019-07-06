<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model;

/** 
 * Class CpcVideoCreative 
 * 
 * @property-readable   integer   $duration
 * 
 * @method              integer   getDuration()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class CpcVideoCreative extends Model 
{ 
    protected static $compatibleCollection;

    protected static $properties = [
        'duration' => 'integer'
    ];

    protected static $nonWritableProperties = [
        'duration'
    ];
}