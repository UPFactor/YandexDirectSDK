<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Collections\Creatives;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Models\Creative;

/** 
 * Class CreativesService 
 * 
 * @method   QueryBuilder              query()
 * @method   Creative|Creatives|null   find(integer|integer[]|Creative|Creatives|ModelCommonInterface $ids, string[] $fields)
 * 
 * @package YandexDirectSDK\Services 
 */
class CreativesService extends Service
{
    protected $serviceName = 'creatives';

    protected $serviceModelClass = Creative::class;

    protected $serviceModelCollectionClass = Creatives::class;

    protected $serviceMethods = [
        'query' => 'get:selectionElements',
        'find' => 'get:selectionByIds'
    ];
}