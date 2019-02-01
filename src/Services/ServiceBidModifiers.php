<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Result;

/**
 * Class ServiceBidModifiers
 *
 * @method Result add(array $params)
 * @method Result delete(array $params)
 * @method Result get(array $params)
 * @method Result set(array $params)
 * @method Result toggle(array $params)
 *
 * @see https://tech.yandex.ru/direct/doc/ref-v5/bidmodifiers/bidmodifiers-docpage/
 * @package YandexDirectSDK\Services
 */
class ServiceBidModifiers extends Service
{
    final protected function getServiceName(){
        return 'bidmodifiers';
    }

    final protected function getMethodList(){
        return array('add','delete','get','set','toggle');
    }
}