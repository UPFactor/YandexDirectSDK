<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\ModelCollection;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Models\BidAuto;
use YandexDirectSDK\Services\BidsService;

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

    public function apply():Result
    {
        return BidsService::setAuto($this);
    }
}