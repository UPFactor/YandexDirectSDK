<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Interfaces\ModelCommon;
use YandexDirectSDK\Collections\AdGroups;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Models\AdGroup;

/** 
 * Class AdGroupsService 
 * 
 * @method   Result         add(ModelCommon $adGroups) 
 * @method   Result         update(ModelCommon $adGroups) 
 * @method   QueryBuilder   query() 
 * @method   Result         delete(ModelCommon|integer[]|integer $adGroups) 
 * 
 * @package YandexDirectSDK\Services 
 */
class AdGroupsService extends Service
{
    protected $serviceName = 'adgroups';

    protected $serviceModelClass = AdGroup::class;

    protected $serviceModelCollectionClass = AdGroups::class;

    protected $serviceMethods = [
        'add' => 'add:addCollection',
        'update' => 'update:updateCollection',
        'query' => 'get:selectionElements',
        'delete' => 'delete:actionByIds'
    ];
}