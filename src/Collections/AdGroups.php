<?php 
namespace YandexDirectSDK\Collections;

use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Components\ModelCollection as ModelCollection; 
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Services\AdGroupsService;

/** 
 * Class AdGroups 
 * 
 * @method   QueryBuilder   query() 
 * @method   Result         add() 
 * @method   Result         update() 
 * @method   Result         delete() 
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class AdGroups extends ModelCollection 
{ 
    /** 
     * @var AdGroup[] 
     */ 
    protected $items = []; 

    protected $compatibleModel = AdGroup::class;

    protected $serviceProvidersMethods = [
        'query' => AdGroupsService::class,
        'add' => AdGroupsService::class,
        'update' => AdGroupsService::class,
        'delete' => AdGroupsService::class
    ];
}