<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder; 
use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\Bid;
use YandexDirectSDK\Services\BidsService;

/** 
 * Class Bids 
 * 
 * @method static     QueryBuilder     query()
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class Bids extends ModelCollection 
{ 
    /** 
     * @var Bid[] 
     */ 
    protected $items = []; 

    /** 
     * @var Bid[] 
     */ 
    protected static $compatibleModel = Bid::class;

    protected static $staticMethods = [
        'query' => BidsService::class
    ];

    public function apply():Result
    {
        return BidsService::set($this);
    }
}