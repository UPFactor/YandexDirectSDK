<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Collections\Foundation\On;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder; 
use YandexDirectSDK\Components\ModelCollection;
use YandexDirectSDK\Models\AudienceTarget;
use YandexDirectSDK\Services\AudienceTargetsService;

/** 
 * Class AudienceTargets 
 * 
 * @method static     QueryBuilder                            query()
 * @method static     AudienceTarget|AudienceTargets|null     find(integer|integer[]|string|string[] $ids, string[] $fields=null)
 * @method            Result                                  create()
 * @method            Result                                  delete()
 * @method            Result                                  resume()
 * @method            Result                                  suspend()
 * @method            Result                                  setRelatedContextBids($contextBid)
 * @method            Result                                  setRelatedStrategyPriority($strategyPriority)
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class AudienceTargets extends ModelCollection 
{
    use On;

    /** 
     * @var AudienceTarget[] 
     */ 
    protected $items = []; 

    /** 
     * @var AudienceTarget 
     */ 
    protected static $compatibleModel = AudienceTarget::class;

    protected static $staticMethods = [
        'query' => AudienceTargetsService::class,
        'find' => AudienceTargetsService::class
    ];

    protected static $methods = [
        'create' => AudienceTargetsService::class,
        'delete' => AudienceTargetsService::class,
        'resume' => AudienceTargetsService::class,
        'suspend' => AudienceTargetsService::class,
        'setRelatedContextBids' => AudienceTargetsService::class,
        'setRelatedStrategyPriority' => AudienceTargetsService::class
    ];
}