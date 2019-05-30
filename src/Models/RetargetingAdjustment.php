<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model;

/** 
 * Class RetargetingAdjustment 
 * 
 * @property            integer   $retargetingConditionId 
 * @property            integer   $bidModifier 
 * @property-readable   string    $accessible 
 * @property-readable   string    $enabled 
 * 
 * @method              $this     setRetargetingConditionId(integer $retargetingConditionId) 
 * @method              $this     setBidModifier(integer $bidModifier) 
 * 
 * @method              integer   getRetargetingConditionId() 
 * @method              integer   getBidModifier() 
 * @method              string    getAccessible() 
 * @method              string    getEnabled() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class RetargetingAdjustment extends Model 
{ 
    protected $properties = [
        'retargetingConditionId' => 'integer',
        'bidModifier' => 'integer',
        'accessible' => 'string',
        'enabled' => 'string'
    ];

    protected $nonWritableProperties = [
        'accessible',
        'enabled'
    ];
}