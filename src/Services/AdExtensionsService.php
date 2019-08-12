<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Collections\AdExtensions;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Models\AdExtension;

/** 
 * Class AdExtensionsService 
 * 
 * @method static     Result                            add(AdExtension|AdExtensions|ModelCommonInterface $adExtensions)
 * @method static     QueryBuilder                      query()
 * @method static     AdExtension|AdExtensions|null     find(integer|integer[]|AdExtension|AdExtensions|ModelCommonInterface $ids, string[] $fields)
 * @method static     Result                            delete(integer|integer[]|AdExtension|AdExtensions|ModelCommonInterface $adExtensions)
 * 
 * @package YandexDirectSDK\Services 
 */
class AdExtensionsService extends Service
{
    protected static $name = 'adextensions';

    protected static $modelClass = AdExtension::class;

    protected static $modelCollectionClass = AdExtensions::class;

    protected static $methods = [
        'add' => 'add:addCollection',
        'query' => 'get:selectionElements',
        'find' => 'get:selectionByIds',
        'delete' => 'delete:actionByIds'
    ];
}