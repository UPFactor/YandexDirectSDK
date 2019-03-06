<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder; 
use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\RetargetingList;
use YandexDirectSDK\Services\RetargetingListsService;

/** 
 * Class RetargetingLists 
 * 
 * @method   Result         add() 
 * @method   Result         delete() 
 * @method   QueryBuilder   query() 
 * @method   Result         update() 
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class RetargetingLists extends ModelCollection 
{ 
    /** 
     * @var RetargetingList[] 
     */ 
    protected $items = []; 

    /** 
     * @var RetargetingList 
     */ 
    protected $compatibleModel = RetargetingList::class;

    protected $serviceProvidersMethods = [
        'add' => RetargetingListsService::class,
        'delete' => RetargetingListsService::class,
        'query' => RetargetingListsService::class,
        'update' => RetargetingListsService::class
    ];
}