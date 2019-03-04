<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model;

/** 
 * Class VideoAdjustment 
 * 
 * @property   integer   $bidModifier 
 * 
 * @method     $this     setBidModifier(integer $bidModifier) 
 * 
 * @method     integer   getBidModifier() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class VideoAdjustment extends Model 
{ 
    protected $compatibleCollection; 

    protected $serviceProvidersMethods = [];

    protected $properties = [
        'bidModifier' => 'integer'
    ];

    protected $nonWritableProperties = []; 

    protected $nonReadableProperties = []; 

    protected $requiredProperties = [
        'bidModifier'
    ];
}