<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\BidAuto;

/** 
 * Class BidsAuto 
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class BidsAuto extends ModelCollection 
{ 
    /**
     * @var BidAuto[] 
     */ 
    protected $items = []; 

    /** 
     * @var BidAuto[] 
     */ 
    protected static $compatibleModel = BidAuto::class;
}