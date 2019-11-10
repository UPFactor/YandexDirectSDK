<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder; 
use YandexDirectSDK\Components\ModelCollection;
use YandexDirectSDK\Models\Webpage;
use YandexDirectSDK\Services\DynamicTextAdTargetsService;

/** 
 * Class Webpages 
 * 
 * @method static     QueryBuilder              query()
 * @method static     Webpage|Webpages|null     find(integer|integer[]|string|string[] $ids, string[] $fields=null)
 * @method            Result                    add()
 * @method            Result                    delete()
 * @method            Result                    resume()
 * @method            Result                    suspend()
 * @method            Result                    setRelatedBids($bid, $contextBid=null)
 * @method            Result                    setRelatedContextBids($contextBid)
 * @method            Result                    setRelatedStrategyPriority(string $strategyPriority)
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class Webpages extends ModelCollection 
{ 
    /** 
     * @var Webpage[] 
     */ 
    protected $items = []; 

    /** 
     * @var Webpage 
     */ 
    protected static $compatibleModel = Webpage::class;

    protected static $staticMethods = [
        'query' => DynamicTextAdTargetsService::class,
        'find' => DynamicTextAdTargetsService::class
    ];

    protected static $methods = [
        'add' => DynamicTextAdTargetsService::class,
        'delete' => DynamicTextAdTargetsService::class,
        'resume' => DynamicTextAdTargetsService::class,
        'suspend' => DynamicTextAdTargetsService::class,
        'setRelatedBids' => DynamicTextAdTargetsService::class,
        'setRelatedContextBids' => DynamicTextAdTargetsService::class,
        'setRelatedStrategyPriority' => DynamicTextAdTargetsService::class
    ];
}