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
 * @method static     Result           add(Ad|Ads|ModelCommonInterface $ads)
 * @method static     QueryBuilder     query()
 * @method static     Ad|Ads|null      find(integer|integer[]|string|string[] $ids, string[] $fields)
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