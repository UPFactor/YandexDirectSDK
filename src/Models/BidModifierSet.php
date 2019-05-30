<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\BidModifierSets;
use YandexDirectSDK\Components\Model;

/** 
 * Class BidModifierSet 
 * 
 * @property   integer   $id 
 * @property   integer   $bidModifier 
 * 
 * @method     $this     setId(integer $id) 
 * @method     $this     setBidModifier(integer $bidModifier) 
 * 
 * @method     integer   getId() 
 * @method     integer   getBidModifier() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class BidModifierSet extends Model 
{ 
    protected $compatibleCollection = BidModifierSets::class;

    protected $properties = [
        'id' => 'integer',
        'bidModifier' => 'integer'
    ];

    protected $nonAddableProperties = [
        'id'
    ];
}