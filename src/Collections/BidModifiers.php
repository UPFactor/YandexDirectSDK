<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Collections\Foundation\On;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder; 
use YandexDirectSDK\Components\ModelCollection;
use YandexDirectSDK\Models\BidModifier;
use YandexDirectSDK\Services\BidModifiersService;

/** 
 * Class BidModifiers 
 * 
 * @method static     QueryBuilder                      query()
 * @method static     BidModifier|BidModifiers|null     find(integer|integer[]|string|string[] $ids, string[] $fields=null)
 * @method            Result                            create()
 * @method            Result                            update(int $value=null)
 * @method            Result                            delete()
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class BidModifiers extends ModelCollection 
{ 
    use On;

    /**
     * @var BidModifier[] 
     */ 
    protected $items = []; 

    /** 
     * @var BidModifier 
     */ 
    protected static $compatibleModel = BidModifier::class;

    protected static $staticMethods = [
        'query' => BidModifiersService::class,
        'find' => BidModifiersService::class
    ];

    protected static $methods = [
        'create' => BidModifiersService::class,
        'update' => BidModifiersService::class,
        'delete' => BidModifiersService::class
    ];
}