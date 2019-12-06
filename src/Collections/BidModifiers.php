<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Collections\Foundation\To;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder; 
use YandexDirectSDK\Components\ModelCollection;
use YandexDirectSDK\Models\BidModifier;
use YandexDirectSDK\Services\BidModifiersService;

/** 
 * Class BidModifiers 
 * 
 * @method static     QueryBuilder     query()
 * @method            Result           create()
 * @method            Result           delete()
 * @method            Result           applyCoefficient(int $coefficient=null)
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class BidModifiers extends ModelCollection 
{ 
    use To;

    /**
     * @var BidModifier[] 
     */ 
    protected $items = []; 

    /** 
     * @var BidModifier 
     */ 
    protected static $compatibleModel = BidModifier::class;

    protected static $staticMethods = [
        'query' => BidModifiersService::class
    ];

    protected static $methods = [
        'create' => BidModifiersService::class,
        'delete' => BidModifiersService::class,
        'applyCoefficient' => BidModifiersService::class
    ];
}