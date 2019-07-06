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
 * @method   QueryBuilder   query()
 * @method   Result         set()
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

    protected static $serviceMethods = [
        'query' => BidsService::class,
        'set' => BidsService::class
    ];
}