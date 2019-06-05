<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model;

/** 
 * Class VideoExtensionCreative 
 * 
 * @property-readable   integer   $duration
 * 
 * @method              integer   getDuration()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class VideoExtensionCreative extends Model 
{ 
    protected $compatibleCollection; 

    protected $properties = [
        'duration' => 'integer'
    ];

    protected $nonWritableProperties = [
        'duration'
    ];
}