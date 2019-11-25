<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Collections\Foundation\On;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder; 
use YandexDirectSDK\Components\ModelCollection;
use YandexDirectSDK\Models\VCard;
use YandexDirectSDK\Services\VCardsService;

/** 
 * Class VCards 
 * 
 * @method static     QueryBuilder          query()
 * @method static     VCard|VCards|null     find(integer|integer[]|string|string[] $ids, string[] $fields=null)
 * @method            Result                add()
 * @method            Result                delete()
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class VCards extends ModelCollection 
{ 
    use On;

    /**
     * @var VCard[] 
     */ 
    protected $items = []; 

    /** 
     * @var VCard 
     */ 
    protected static $compatibleModel = VCard::class;

    protected static $staticMethods = [
        'query' => VCardsService::class,
        'find' => VCardsService::class
    ];

    protected static $methods = [
        'add' => VCardsService::class,
        'delete' => VCardsService::class
    ];
}