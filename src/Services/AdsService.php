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
 * @method static     Result           create(Ad|Ads|ModelCommonInterface $ads)
 * @method static     QueryBuilder     query()
 * @method static     Ad|Ads|null      find(integer|integer[]|string|string[] $ids, string[] $fields=null)
 * @method static     Result           update(Ad|Ads|ModelCommonInterface $ads)
 * @method static     Result           archive(integer|integer[]|Ad|Ads|ModelCommonInterface $ads)
 * @method static     Result           delete(integer|integer[]|Ad|Ads|ModelCommonInterface $ads)
 * @method static     Result           resume(integer|integer[]|Ad|Ads|ModelCommonInterface $ads)
 * @method static     Result           suspend(integer|integer[]|Ad|Ads|ModelCommonInterface $ads)
 * @method static     Result           unarchive(integer|integer[]|Ad|Ads|ModelCommonInterface $ads)
 * @method static     Result           moderate(integer|integer[]|Ad|Ads|ModelCommonInterface $ads)
 * 
 * @package YandexDirectSDK\Services 
 */
class AdsService extends Service
{
    protected static $name = 'ads';

    protected static $modelClass = Ad::class;

    protected static $modelCollectionClass = Ads::class;

    protected static $methods = [
        'create' => 'add:addCollection',
        'query' => 'get:createQueryBuilder',
        'find' => 'get:selectById',
        'update' => 'update:updateCollection',
        'archive' => 'archive:actionById',
        'delete' => 'delete:actionById',
        'resume' => 'resume:actionById',
        'suspend' => 'suspend:actionById',
        'unarchive' => 'unarchive:actionById',
        'moderate' => 'moderate:actionById'
    ];
}