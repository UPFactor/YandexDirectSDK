<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Result;

/**
 * Class ServiceDictionaries
 *
 * @method Result get(array $params)
 *
 * @see https://tech.yandex.ru/direct/doc/ref-v5/dictionaries/dictionaries-docpage/
 * @package YandexDirectSDK\Services
 */
class ServiceDictionaries extends Service
{
    final protected function getServiceName(){
        return 'dictionaries';
    }

    final protected function getMethodList(){
        return array('get');
    }
}