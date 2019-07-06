<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model;

/** 
 * Class DesktopAdjustment 
 * 
 * @property       integer   $bidModifier
 * 
 * @method         $this     setBidModifier(integer $bidModifier)
 * 
 * @method         integer   getBidModifier()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class DesktopAdjustment extends Model 
{ 
    protected static $properties = [
        'bidModifier' => 'integer'
    ];
}