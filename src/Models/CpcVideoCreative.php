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
    protected $compatibleCollection; 

    protected $properties = [
        'duration' => 'integer'
    ];

    protected $nonWritableProperties = [
        'duration'
    ];
}