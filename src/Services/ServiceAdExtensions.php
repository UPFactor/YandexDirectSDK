<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Result;

/**
 * Class ServiceAdExtensions
 *
 * @method Result add(array $params)
 * @method Result delete(array $params)
 * @method Result get(array $params)
 *
 * @see https://tech.yandex.ru/direct/doc/ref-v5/adextensions/adextensions-docpage/
 * @package YandexDirectSDK\Services
 */
class ServiceAdExtensions extends Service
{
    final protected function getServiceName(){
        return 'adextensions';
    }

    final protected function getMethodList(){
        return array('add','delete','get');
    }
}