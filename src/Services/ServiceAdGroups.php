<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Result;

/**
 * Class ServiceAdGroups
 *
 * @method Result add(array $params)
 * @method Result delete(array $params)
 * @method Result get(array $params)
 * @method Result update(array $params)
 *
 * @see https://tech.yandex.ru/direct/doc/ref-v5/adgroups/adgroups-docpage/
 * @package YandexDirectSDK\Services
 */
class ServiceAdGroups extends Service
{
    final protected function getServiceName(){
        return 'adgroups';
    }

    final protected function getMethodList(){
        return array('add','delete','get','update');
    }
}