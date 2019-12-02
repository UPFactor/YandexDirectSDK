<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\ModelCollection;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Models\BidModifierSet;
use YandexDirectSDK\Services\BidModifiersService;

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

    public function apply():Result
    {
        return BidModifiersService::applyCoefficient($this);
    }
}