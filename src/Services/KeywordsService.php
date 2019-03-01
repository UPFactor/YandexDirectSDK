<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Collections\Keywords;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Interfaces\ModelCommon;
use YandexDirectSDK\Models\Keyword;

/** 
 * Class KeywordsService 
 * 
 * @method   Result         add(ModelCommon $keywords) 
 * @method   Result         delete(ModelCommon|integer[]|integer $keywords) 
 * @method   QueryBuilder   query() 
 * @method   Result         resume(ModelCommon|integer[]|integer $keywords) 
 * @method   Result         suspend(ModelCommon|integer[]|integer $keywords) 
 * @method   Result         update(ModelCommon $keywords) 
 * 
 * @package YandexDirectSDK\Services 
 */
class KeywordsService extends Service
{
    protected $serviceName = 'keywords';

    protected $serviceModelClass = Keyword::class;

    protected $serviceModelCollectionClass = Keywords::class;

    protected $serviceMethods = [
        'add' => 'add:addCollection',
        'delete' => 'delete:actionByIds',
        'query' => 'get:selectionElements',
        'resume' => 'resume:actionByIds',
        'suspend' => 'suspend:actionByIds',
        'update' => 'update:updateCollection',
    ];
}