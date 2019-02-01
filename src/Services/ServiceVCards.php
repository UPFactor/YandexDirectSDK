<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Result;

/**
 * Class ServiceVCards
 *
 * @method Result add(array $params)
 * @method Result delete(array $params)
 * @method Result get(array $params)
 *
 * @see https://tech.yandex.ru/direct/doc/ref-v5/vcards/vcards-docpage/
 * @package YandexDirectSDK\Services
 */
class ServiceVCards extends Service
{
    final protected function getServiceName(){
        return 'vcards';
    }

    final protected function getMethodList(){
        return array('add','delete','get');
    }
}