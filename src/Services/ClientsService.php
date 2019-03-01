<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Components\Service;

/** 
 * Class ClientsService 
 * 
 * @package YandexDirectSDK\Services 
 */
class ClientsService extends Service
{
    protected $serviceName = 'clients';

    protected $serviceModelClass;

    protected $serviceModelCollectionClass;

    protected $serviceMethods = [];
}