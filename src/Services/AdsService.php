<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Interfaces\ModelCommon;
use YandexDirectSDK\Collections\Ads;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Models\Ad;


/** 
 * Class AdsService 
 * 
 * @method   Result         add(ModelCommon $ads) 
 * @method   QueryBuilder   query() 
 * @method   Result         update(ModelCommon $ads) 
 * @method   Result         archive(ModelCommon|integer[]|integer $ads) 
 * @method   Result         delete(ModelCommon|integer[]|integer $ads) 
 * @method   Result         resume(ModelCommon|integer[]|integer $ads) 
 * @method   Result         suspend(ModelCommon|integer[]|integer $ads) 
 * @method   Result         unarchive(ModelCommon|integer[]|integer $ads) 
 * @method   Result         moderate(ModelCommon|integer[]|integer $ads) 
 * 
 * @package YandexDirectSDK\Services 
 */
class AdsService extends Service
{
    protected $serviceName = 'ads';

    protected $serviceModelClass = Ad::class;

    protected $serviceModelCollectionClass = Ads::class;

    protected $serviceMethods = [
        'add' => 'add:addCollection',
        'query' => 'get:selectionElements',
        'update' => 'update:updateCollection',
        'archive' => 'archive:actionByIds',
        'delete' => 'delete:actionByIds',
        'resume' => 'resume:actionByIds',
        'suspend' => 'suspend:actionByIds',
        'unarchive' => 'unarchive:actionByIds',
        'moderate' => 'moderate:actionByIds'
    ];
}