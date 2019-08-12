<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder; 
use YandexDirectSDK\Components\ModelCollection;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Models\BidModifier;
use YandexDirectSDK\Services\BidModifiersService;

/** 
 * Class BidModifiers 
 * 
 * @method static     QueryBuilder                      query()
 * @method static     BidModifier|BidModifiers|null     find(integer|integer[]|BidModifier|BidModifiers|ModelCommonInterface $ids, string[] $fields)
 * @method            Result                            add()
 * @method            Result                            set(int $value=null)
 * @method            Result                            delete()
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class BidModifiers extends ModelCollection 
{ 
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
        'add' => BidModifiersService::class,
        'set' => BidModifiersService::class,
        'delete' => BidModifiersService::class
    ];
}