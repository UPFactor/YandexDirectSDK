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
 * @method   Result                          add(AdExtension|AdExtensions|ModelCommonInterface $adExtensions)
 * @method   QueryBuilder                    query()
 * @method   AdExtension|AdExtensions|null   find(integer|integer[]|AdExtension|AdExtensions|ModelCommonInterface $ids, string[] $fields)
 * @method   Result                          delete(integer|integer[]|AdExtension|AdExtensions|ModelCommonInterface $adExtensions)
 * 
 * @package YandexDirectSDK\Services 
 */
class AdExtensionsService extends Service
{
    protected $serviceName = 'adextensions';

    protected $serviceModelClass = AdExtension::class;

    protected $serviceModelCollectionClass = AdExtensions::class;

    protected $serviceMethods = [
        'add' => 'add:addCollection',
        'query' => 'get:selectionElements',
        'find' => 'get:selectionByIds',
        'delete' => 'delete:actionByIds'
    ];
}