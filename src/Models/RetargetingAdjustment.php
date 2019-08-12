<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model;

/** 
 * Class RetargetingAdjustment 
 * 
 * @property          integer     $retargetingConditionId
 * @property          integer     $bidModifier
 * @property-read     string      $accessible
 * @property-read     string      $enabled
 *                                
 * @method            $this       setRetargetingConditionId(integer $retargetingConditionId)
 * @method            integer     getRetargetingConditionId()
 * @method            $this       setBidModifier(integer $bidModifier)
 * @method            integer     getBidModifier()
 * @method            string      getAccessible()
 * @method            string      getEnabled()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class RetargetingAdjustment extends Model 
{ 
    protected static $properties = [
        'retargetingConditionId' => 'integer',
        'bidModifier' => 'integer',
        'accessible' => 'string',
        'enabled' => 'string'
    ];

    protected static $nonWritableProperties = [
        'accessible',
        'enabled'
    ];
}