<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\BidModifierSets;
use YandexDirectSDK\Components\Model;

/** 
 * Class BidModifierSet 
 * 
 * @property       integer   $id
 * @property       integer   $bidModifier
 * 
 * @method         $this     setId(integer $id)
 * @method         $this     setBidModifier(integer $bidModifier)
 * 
 * @method         integer   getId()
 * @method         integer   getBidModifier()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class BidModifierSet extends Model 
{ 
    protected static $compatibleCollection = BidModifierSets::class;

    protected static $properties = [
        'id' => 'integer',
        'bidModifier' => 'integer'
    ];

    protected static $nonAddableProperties = [
        'id'
    ];
}