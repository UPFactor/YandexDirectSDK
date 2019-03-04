<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\BidModifierSet;
use YandexDirectSDK\Services\BidModifiersService;

/** 
 * Class BidModifierSets 
 * 
 * @method   Result   set() 
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class BidModifierSets extends ModelCollection 
{ 
    /** 
     * @var BidModifierSet[] 
     */ 
    protected $items = []; 

    /** 
     * @var BidModifierSet 
     */ 
    protected $compatibleModel = BidModifierSet::class;

    protected $serviceProvidersMethods = [
        'set' => BidModifiersService::class
    ];

    public static function getClassName()
    {
        return 'BidModifiers';
    }
}