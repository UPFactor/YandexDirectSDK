<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder; 
use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\BidModifier;
use YandexDirectSDK\Services\BidModifiersService;

/** 
 * Class BidModifiers 
 * 
 * @method   Result         add()
 * @method   Result         set(int $value = null)
 * @method   Result         delete()
 * @method   QueryBuilder   query()
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

    protected static $serviceMethods = [
        'add' => BidModifiersService::class,
        'set' => BidModifiersService::class,
        'delete' => BidModifiersService::class,
        'query' => BidModifiersService::class
    ];
}