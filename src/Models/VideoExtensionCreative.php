<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model;

/** 
 * Class VideoExtensionCreative 
 * 
 * @property-read   integer   $duration
 * 
 * @method          integer   getDuration()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class VideoExtensionCreative extends Model 
{ 
    protected static $compatibleCollection;

    protected static $properties = [
        'duration' => 'integer'
    ];

    protected static $nonWritableProperties = [
        'duration'
    ];
}