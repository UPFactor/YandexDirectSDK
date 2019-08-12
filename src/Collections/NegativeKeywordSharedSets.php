<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder; 
use YandexDirectSDK\Components\ModelCollection;
use YandexDirectSDK\Interfaces\ModelCommon;
use YandexDirectSDK\Models\NegativeKeywordSharedSet;
use YandexDirectSDK\Services\NegativeKeywordSharedSetsServiceService;

/** 
 * Class NegativeKeywordSharedSets 
 * 
 * @method static     NegativeKeywordSharedSet|NegativeKeywordSharedSets|null     find(integer|integer[]|NegativeKeywordSharedSet|NegativeKeywordSharedSets|ModelCommon $ids, string[] $fields)
 * @method            Result                                                      add()
 * @method            QueryBuilder                                                query()
 * @method            Result                                                      update()
 * @method            Result                                                      delete()
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class NegativeKeywordSharedSets extends ModelCollection 
{ 
    /** 
     * @var NegativeKeywordSharedSet[] 
     */ 
    protected $items = []; 

    /** 
     * @var NegativeKeywordSharedSet 
     */ 
    protected static $compatibleModel = NegativeKeywordSharedSet::class;

    protected static $methods = [
        'add' => NegativeKeywordSharedSetsServiceService::class,
        'query' => NegativeKeywordSharedSetsServiceService::class,
        'update' => NegativeKeywordSharedSetsServiceService::class,
        'delete' => NegativeKeywordSharedSetsServiceService::class
    ];

    protected static $staticMethods = [
        'find' => NegativeKeywordSharedSetsServiceService::class
    ];
}