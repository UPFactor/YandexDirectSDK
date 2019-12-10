<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Collections\Creatives;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Models\Creative;

/** 
 * Class CreativesService 
 * 
 * @method static     QueryBuilder                query()
 * @method static     Creative|Creatives|null     find(integer|integer[]|string|string[] $ids, string[] $fields=null)
 * 
 * @package YandexDirectSDK\Services 
 */
class CreativesService extends Service
{
    protected static $name = 'creatives';

    protected static $modelClass = Creative::class;

    protected static $modelCollectionClass = Creatives::class;

    protected static $methods = [
        'query' => 'get:createQueryBuilder',
        'find' => 'get:selectById'
    ];
}