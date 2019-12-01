<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\ModelCollection;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Models\BidModifierToggle;
use YandexDirectSDK\Services\BidModifiersService;

/** 
 * Class BidModifierToggles 
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
    protected static $compatibleModel = BidModifierToggle::class;

    public function apply():Result
    {
        return BidModifiersService::toggle($this);
    }
}