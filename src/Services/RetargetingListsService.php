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
 * @method   Result                                  add(RetargetingList|RetargetingLists|ModelCommonInterface $retargetingLists)
 * @method   Result                                  delete(integer|integer[]|RetargetingList|RetargetingLists|ModelCommonInterface $retargetingLists)
 * @method   QueryBuilder                            query()
 * @method   RetargetingList|RetargetingLists|null   find(integer|integer[]|RetargetingList|RetargetingLists|ModelCommonInterface $ids, string[] $fields)
 * @method   Result                                  update(RetargetingList|RetargetingLists|ModelCommonInterface $retargetingLists)
 * 
 * @package YandexDirectSDK\Services 
 */
class RetargetingListsService extends Service
{
    protected $serviceName = 'retargetinglists';

    protected $serviceModelClass = RetargetingList::class;

    protected $serviceModelCollectionClass = RetargetingLists::class;

    protected $serviceMethods = [
        'add' => 'add:addCollection',
        'delete' => 'delete:actionByIds',
        'query' => 'get:selectionElements',
        'find' => 'get:selectionByIds',
        'update' => 'update:updateCollection'
    ];
}