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
 * @method   Result         set(int $value) 
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
    protected $compatibleModel = BidModifier::class; 

    protected $serviceProvidersMethods = [
        'add' => BidModifiersService::class,
        'set' => BidModifiersService::class,
        'delete' => BidModifiersService::class,
        'query' => BidModifiersService::class
    ];
}