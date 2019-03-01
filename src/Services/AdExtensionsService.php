<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Collections\AdExtensions;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Interfaces\ModelCommon;
use YandexDirectSDK\Models\AdExtension;

/** 
 * Class AdExtensionsService 
 * 
 * @method   Result         add(ModelCommon $adExtensions) 
 * @method   QueryBuilder   query() 
 * @method   Result         delete(ModelCommon|integer[]|integer $adExtensions) 
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
        'delete' => 'delete:actionByIds'
    ];
}