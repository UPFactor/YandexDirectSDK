<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Result;

/**
 * Class ServiceKeywords
 *
 * @method Result add(array $params)
 * @method Result delete(array $params)
 * @method Result get(array $params)
 * @method Result resume(array $params)
 * @method Result suspend(array $params)
 * @method Result update(array $params)
 *
 * @see https://tech.yandex.ru/direct/doc/ref-v5/keywords/keywords-docpage/
 * @package YandexDirectSDK\Services
 */
class ServiceKeywords extends Service
{
    final protected function getServiceName(){
        return 'keywords';
    }

    final protected function getMethodList(){
        return array('add','delete','get','resume','suspend','update');
    }
}