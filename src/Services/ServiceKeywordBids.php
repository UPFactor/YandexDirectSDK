<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Result;

/**
 * Class ServiceKeywordBids
 *
 * @method Result get(array $params)
 * @method Result set(array $params)
 * @method Result setAuto(array $params)
 *
 * @see https://tech.yandex.ru/direct/doc/ref-v5/keywordbids/keywordbids-docpage/
 * @package YandexDirectSDK\Services
 */
class ServiceKeywordBids extends Service
{
    final protected function getServiceName(){
        return 'keywordbids';
    }

    final protected function getMethodList(){
        return array('get','set','setAuto');
    }
}