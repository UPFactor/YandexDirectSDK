<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Result;

/**
 * Class ServiceAds
 *
 * @method Result add(array $params)
 * @method Result archive(array $params)
 * @method Result delete(array $params)
 * @method Result get(array $params)
 * @method Result moderate(array $params)
 * @method Result resume(array $params)
 * @method Result suspend(array $params)
 * @method Result unarchive(array $params)
 * @method Result update(array $params)
 *
 * @see https://tech.yandex.ru/direct/doc/ref-v5/ads/ads-docpage/
 * @package YandexDirectSDK\Services
 */
class ServiceAds extends Service
{
    final protected function getServiceName(){
        return 'ads';
    }

    final protected function getMethodList(){
        return array('add','archive','delete','get','moderate','resume','suspend','unarchive','update');
    }
}