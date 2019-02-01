<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Result;

/**
 * Class ServiceBids
 *
 * @method Result get(array $params)
 * @method Result set(array $params)
 * @method Result setAuto(array $params)
 *
 * @see https://tech.yandex.ru/direct/doc/ref-v5/bids/bids-docpage/
 * @package YandexDirectSDK\Services
 */
class ServiceBids extends Service
{
    final protected function getServiceName(){
        return 'bids';
    }

    final protected function getMethodList(){
        return array('get','set','setAuto');
    }
}