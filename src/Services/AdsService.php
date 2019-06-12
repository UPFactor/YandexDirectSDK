<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Collections\Ads;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Models\Ad;


/** 
 * Class AdsService 
 * 
 * @method   Result         add(Ad|Ads|ModelCommonInterface $ads)
 * @method   QueryBuilder   query()
 * @method   Ad|Ads|null    find(integer|integer[]|Ad|Ads|ModelCommonInterface $ids, string[] $fields)
 * @method   Result         update(Ad|Ads|ModelCommonInterface $ads)
 * @method   Result         archive(integer|integer[]|Ad|Ads|ModelCommonInterface $ads)
 * @method   Result         delete(integer|integer[]|Ad|Ads|ModelCommonInterface $ads)
 * @method   Result         resume(integer|integer[]|Ad|Ads|ModelCommonInterface $ads)
 * @method   Result         suspend(integer|integer[]|Ad|Ads|ModelCommonInterface $ads)
 * @method   Result         unarchive(integer|integer[]|Ad|Ads|ModelCommonInterface $ads)
 * @method   Result         moderate(integer|integer[]|Ad|Ads|ModelCommonInterface $ads)
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
        'find' => 'get:selectionByIds',
        'update' => 'update:updateCollection',
        'archive' => 'archive:actionByIds',
        'delete' => 'delete:actionByIds',
        'resume' => 'resume:actionByIds',
        'suspend' => 'suspend:actionByIds',
        'unarchive' => 'unarchive:actionByIds',
        'moderate' => 'moderate:actionByIds'
    ];
}