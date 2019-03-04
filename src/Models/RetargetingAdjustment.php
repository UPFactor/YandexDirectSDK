<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\RetargetingAdjustments;
use YandexDirectSDK\Components\Model;

/** 
 * Class RetargetingAdjustment 
 * 
 * @property        integer   $retargetingConditionId 
 * @property        integer   $bidModifier 
 * @property-read   string    $accessible 
 * @property-read   string    $enabled 
 * 
 * @method          $this     setRetargetingConditionId(integer $retargetingConditionId) 
 * @method          $this     setBidModifier(integer $bidModifier) 
 * 
 * @method          integer   getRetargetingConditionId() 
 * @method          integer   getBidModifier() 
 * @method          string    getAccessible() 
 * @method          string    getEnabled() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class RetargetingAdjustment extends Model 
{ 
    protected $compatibleCollection = RetargetingAdjustments::class;

    protected $serviceProvidersMethods = []; 

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

    protected $nonReadableProperties = []; 

    protected $requiredProperties = [
        'retargetingConditionId',
        'bidModifier'
    ];
}