<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\BidModifierToggle;

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
    protected $compatibleModel = BidModifierToggle::class;
}