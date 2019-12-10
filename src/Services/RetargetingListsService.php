<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Collections\RetargetingLists;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Models\RetargetingList;

/** 
 * Class RetargetingListsService 
 * 
 * @method static     Result                                    create(RetargetingList|RetargetingLists|ModelCommonInterface $retargetingLists)
 * @method static     Result                                    delete(integer|integer[]|RetargetingList|RetargetingLists|ModelCommonInterface $retargetingLists)
 * @method static     QueryBuilder                              query()
 * @method static     RetargetingList|RetargetingLists|null     find(integer|integer[]|string|string[] $ids, string[] $fields=null)
 * @method static     Result                                    update(RetargetingList|RetargetingLists|ModelCommonInterface $retargetingLists)
 * 
 * @package YandexDirectSDK\Services 
 */
class RetargetingListsService extends Service
{
    protected static $name = 'retargetinglists';

    protected static $modelClass = RetargetingList::class;

    protected static $modelCollectionClass = RetargetingLists::class;

    protected static $methods = [
        'create' => 'add:addCollection',
        'delete' => 'delete:actionById',
        'query' => 'get:createQueryBuilder',
        'find' => 'get:selectById',
        'update' => 'update:updateCollection'
    ];
}