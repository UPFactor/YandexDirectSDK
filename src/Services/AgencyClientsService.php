<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Components\Service;

/** 
 * Class AgencyClientsService 
 * 
 * @package YandexDirectSDK\Services 
 */
class AgencyClientsService extends Service
{
    protected $serviceName = 'agencyclients';

    protected $serviceModelClass;

    protected $serviceModelCollectionClass;

    protected $serviceMethods = [
        'add' => 'add:addModel',
        'update' => 'update:updateCollection',
        'query' => 'get:selectionElements'
    ];
}