<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder; 
use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\KeywordBid;
use YandexDirectSDK\Services\KeywordBidsService;

/** 
 * Class KeywordBids 
 * 
 * @method   QueryBuilder   query() 
 * @method   Result         set() 
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class KeywordBids extends ModelCollection 
{ 
    /** 
     * @var KeywordBid[] 
     */ 
    protected $items = []; 

    /** 
     * @var KeywordBid[] 
     */ 
    protected $compatibleModel = KeywordBid::class;

    protected $serviceProvidersMethods = [
        'query' => KeywordBidsService::class,
        'set' => KeywordBidsService::class
    ];
}