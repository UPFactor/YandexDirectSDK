<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Result;

/**
 * Class ServiceAgencyClients
 *
 * @method Result add(array $params)
 * @method Result get(array $params)
 * @method Result update(array $params)
 *
 * @see https://tech.yandex.ru/direct/doc/ref-v5/agencyclients/agencyclients-docpage/
 * @package YandexDirectSDK\Services
 */
class ServiceAgencyClients extends Service
{
    final protected function getServiceName(){
        return 'agencyclients';
    }

    final protected function getMethodList(){
        return array('add','get','update');
    }
}