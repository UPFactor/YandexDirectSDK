<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder; 
use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\VCard;
use YandexDirectSDK\Services\VCardsService;

/** 
 * Class VCards 
 * 
 * @method   QueryBuilder   query() 
 * @method   Result         add() 
 * @method   Result         delete() 
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class VCards extends ModelCollection 
{ 
    /** 
     * @var VCard[] 
     */ 
    protected $items = []; 

    /** 
     * @var VCard 
     */ 
    protected $compatibleModel = VCard::class;

    protected $serviceProvidersMethods = [
        'query' => VCardsService::class,
        'add' => VCardsService::class,
        'delete' => VCardsService::class
    ];
}