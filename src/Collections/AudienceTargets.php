<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder; 
use YandexDirectSDK\Components\ModelCollection;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Models\AudienceTarget;
use YandexDirectSDK\Services\AudienceTargetsService;

/** 
 * Class AudienceTargets 
 * 
 * @method static     QueryBuilder                            query()
 * @method static     AudienceTarget|AudienceTargets|null     find(integer|integer[]|AudienceTarget|AudienceTargets|ModelCommonInterface $ids, string[] $fields)
 * @method            Result                                  add()
 * @method            Result                                  delete()
 * @method            Result                                  resume()
 * @method            Result                                  suspend()
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class AudienceTargets extends ModelCollection 
{ 
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
        'add' => AudienceTargetsService::class,
        'delete' => AudienceTargetsService::class,
        'resume' => AudienceTargetsService::class,
        'suspend' => AudienceTargetsService::class
    ];
}