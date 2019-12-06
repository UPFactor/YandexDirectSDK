<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Collections\Foundation\To;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder; 
use YandexDirectSDK\Components\ModelCollection;
use YandexDirectSDK\Models\RetargetingList;
use YandexDirectSDK\Services\RetargetingListsService;

/** 
 * Class RetargetingLists 
 * 
 * @method static     QueryBuilder                              query()
 * @method static     RetargetingList|RetargetingLists|null     find(integer|integer[]|string|string[] $ids, string[] $fields=null)
 * @method            Result                                    create()
 * @method            Result                                    delete()
 * @method            Result                                    update()
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class RetargetingLists extends ModelCollection 
{
    use To;

    /** 
     * @var RetargetingList[] 
     */ 
    protected $items = []; 

    /** 
     * @var RetargetingList 
     */ 
    protected static $compatibleModel = RetargetingList::class;

    protected static $staticMethods = [
        'query' => RetargetingListsService::class,
        'find' => RetargetingListsService::class
    ];

    protected static $methods = [
        'create' => RetargetingListsService::class,
        'delete' => RetargetingListsService::class,
        'update' => RetargetingListsService::class
    ];
}