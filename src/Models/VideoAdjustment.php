<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model;

/** 
 * Class VideoAdjustment 
 * 
 * @property          integer   $bidModifier
 * 
 * @method            $this     setBidModifier(integer $bidModifier)
 * 
 * @method            integer   getBidModifier()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class VideoAdjustment extends Model 
{ 
    protected $properties = [
        'bidModifier' => 'integer'
    ];
}