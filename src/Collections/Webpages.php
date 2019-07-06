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
 * @method   Result         add()
 * @method   Result         delete()
 * @method   QueryBuilder   query()
 * @method   Result         resume()
 * @method   Result         suspend()
 * @method   Result         setRelatedBids($bid, $contextBid = null)
 * @method   Result         setRelatedContextBids($contextBid)
 * @method   Result         setRelatedStrategyPriority(string $strategyPriority)
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

    protected static $serviceMethods = [
        'add' => DynamicTextAdTargetsService::class,
        'delete' => DynamicTextAdTargetsService::class,
        'query' => DynamicTextAdTargetsService::class,
        'resume' => DynamicTextAdTargetsService::class,
        'suspend' => DynamicTextAdTargetsService::class,
        'setRelatedBids' => DynamicTextAdTargetsService::class,
        'setRelatedContextBids' => DynamicTextAdTargetsService::class,
        'setRelatedStrategyPriority' => DynamicTextAdTargetsService::class
    ];
}