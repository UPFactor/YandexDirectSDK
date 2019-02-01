<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Result;

/**
 * Class ServiceClients
 *
 * @method Result get(array $params)
 * @method Result update(array $params)
 *
 * @see https://tech.yandex.ru/direct/doc/ref-v5/clients/clients-docpage/
 * @package YandexDirectSDK\Services
 */
class ServiceClients extends Service
{
    final protected function getServiceName(){
        return 'clients';
    }

    final protected function getMethodList(){
        return array('get','update');
    }
}