<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model;

/** 
 * Class CpmVideoCreative 
 * 
 * @property-readable   integer   $duration
 * 
 * @method              integer   getDuration()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class CpmVideoCreative extends Model 
{
    protected $properties = [
        'duration' => 'integer'
    ];

    protected $nonWritableProperties = [
        'duration'
    ];
}