<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder; 
use YandexDirectSDK\Components\ModelCollection;
use YandexDirectSDK\Interfaces\ModelCommon;
use YandexDirectSDK\Models\NegativeKeywordSharedSet;
use YandexDirectSDK\Services\NegativeKeywordSharedSetsService;

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
        'add' => NegativeKeywordSharedSetsService::class,
        'query' => NegativeKeywordSharedSetsService::class,
        'update' => NegativeKeywordSharedSetsService::class,
        'delete' => NegativeKeywordSharedSetsService::class
    ];

    protected static $staticMethods = [
        'find' => NegativeKeywordSharedSetsService::class
    ];
}