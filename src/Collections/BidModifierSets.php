<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\BidModifierSet;

/** 
 * Class BidModifierSets 
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
    protected static $compatibleModel = BidModifierSet::class;
}