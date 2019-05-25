<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\BidModifierSets;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Services\BidModifiersService;

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
 * @method     Result    set() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class BidModifierSet extends Model 
{ 
    protected $compatibleCollection = BidModifierSets::class;

    protected $serviceProvidersMethods = [
        'set' => BidModifiersService::class
    ];

    protected $properties = [
        'id' => 'integer',
        'bidModifier' => 'integer'
    ];

    protected $nonAddableProperties = [
        'id'
    ];
}