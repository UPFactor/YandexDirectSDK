<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Interfaces\ModelCommon;
use YandexDirectSDK\Collections\RetargetingLists;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Models\RetargetingList;

/** 
 * Class RetargetingListsService 
 * 
 * @method   Result         add(ModelCommon $retargetingLists) 
 * @method   Result         delete(ModelCommon|integer[]|integer $retargetingLists) 
 * @method   QueryBuilder   query() 
 * @method   Result         update(ModelCommon $retargetingLists) 
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
        'update' => 'update:updateCollection'
    ];
}