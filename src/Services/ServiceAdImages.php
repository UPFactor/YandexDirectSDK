<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Result;

/**
 * Class ServiceAdImages
 *
 * @method Result add(array $params)
 * @method Result delete(array $params)
 * @method Result get(array $params)
 *
 * @see https://tech.yandex.ru/direct/doc/ref-v5/adimages/adimages-docpage/
 * @package YandexDirectSDK\Services
 */
class ServiceAdImages extends Service
{
    final protected function getServiceName(){
        return 'adimages';
    }

    final protected function getMethodList(){
        return array('add','delete','get');
    }
}