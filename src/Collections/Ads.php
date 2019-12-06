<?php 
namespace YandexDirectSDK\Collections;

use YandexDirectSDK\Collections\Foundation\To;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Components\ModelCollection as ModelCollection;
use YandexDirectSDK\Models\Ad;
use YandexDirectSDK\Services\AdsService;

/** 
 * Class Ads 
 * 
 * @method static     QueryBuilder     query()
 * @method static     Ad|Ads|null      find(integer|integer[]|string|string[] $ids, string[] $fields=null)
 * @method            Result           create()
 * @method            Result           update()
 * @method            Result           delete()
 * @method            Result           suspend()
 * @method            Result           resume()
 * @method            Result           archive()
 * @method            Result           unarchive()
 * @method            Result           moderate()
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class Ads extends ModelCollection 
{ 
    use To;

    /**
     * @var Ad[] 
     */ 
    protected $items = []; 

    protected static $compatibleModel = Ad::class;

    protected static $staticMethods = [
        'query' => AdsService::class,
        'find' => AdsService::class
    ];

    protected static $methods = [
        'create' => AdsService::class,
        'update' => AdsService::class,
        'delete' => AdsService::class,
        'suspend' => AdsService::class,
        'resume' => AdsService::class,
        'archive' => AdsService::class,
        'unarchive' => AdsService::class,
        'moderate' => AdsService::class
    ];
}