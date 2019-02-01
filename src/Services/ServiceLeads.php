<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Result;

/**
 * Class ServiceLeads
 *
 * @method Result get(array $params)
 *
 * @see https://tech.yandex.ru/direct/doc/ref-v5/leads/leads-docpage/
 * @package YandexDirectSDK\Services
 */
class ServiceLeads extends Service
{
    final protected function getServiceName(){
        return 'leads';
    }

    final protected function getMethodList(){
        return array('get');
    }
}