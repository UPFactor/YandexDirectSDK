<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\BidModifierToggle;
use YandexDirectSDK\Services\BidModifiersService;

/** 
 * Class BidModifierToggles 
 * 
 * @method   Result   toggle() 
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class BidModifierToggles extends ModelCollection 
{ 
    /** 
     * @var BidModifierToggle[] 
     */ 
    protected $items = []; 

    /** 
     * @var BidModifierToggle 
     */ 
    protected $compatibleModel = BidModifierToggle::class;

    protected $serviceProvidersMethods = [
        'toggle' => BidModifiersService::class
    ];
}