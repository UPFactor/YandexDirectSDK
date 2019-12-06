<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Collections\Foundation\To;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder; 
use YandexDirectSDK\Components\ModelCollection;
use YandexDirectSDK\Models\NegativeKeywordSharedSet;
use YandexDirectSDK\Services\NegativeKeywordSharedSetsService;

/** 
 * Class NegativeKeywordSharedSets 
 * 
 * @method static     NegativeKeywordSharedSet|NegativeKeywordSharedSets|null     find(integer|integer[]|string|string[] $ids, string[] $fields=null)
 * @method            Result                                                      create()
 * @method            QueryBuilder                                                query()
 * @method            Result                                                      update()
 * @method            Result                                                      delete()
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class NegativeKeywordSharedSets extends ModelCollection 
{
    use To;

    /** 
     * @var NegativeKeywordSharedSet[] 
     */ 
    protected $items = []; 

    /** 
     * @var NegativeKeywordSharedSet 
     */ 
    protected static $compatibleModel = NegativeKeywordSharedSet::class;

    protected static $methods = [
        'create' => NegativeKeywordSharedSetsService::class,
        'query' => NegativeKeywordSharedSetsService::class,
        'update' => NegativeKeywordSharedSetsService::class,
        'delete' => NegativeKeywordSharedSetsService::class
    ];

    protected static $staticMethods = [
        'find' => NegativeKeywordSharedSetsService::class
    ];
}