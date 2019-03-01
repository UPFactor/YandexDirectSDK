<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Components\Service;

/** 
 * Class AdExtensionsService 
 * 
 * @package YandexDirectSDK\Services 
 */
class AdExtensionsService extends Service
{
    protected $serviceName = 'adextensions';

    protected $serviceModelClass;

    protected $serviceModelCollectionClass;

    protected $serviceMethods = [
        'add' => 'add:addCollection',
        'query' => 'get:selectionElements',
        'delete' => 'delete:actionByIds'
    ];
}