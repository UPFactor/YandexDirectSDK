<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Result;

/**
 * Class ServiceDynamicTextAdTargets
 *
 * @method Result add(array $params)
 * @method Result delete(array $params)
 * @method Result get(array $params)
 * @method Result resume(array $params)
 * @method Result setBids(array $params)
 * @method Result suspend(array $params)
 *
 * @see https://tech.yandex.ru/direct/doc/ref-v5/dynamictextadtargets/dynamictextadtargets-docpage/
 * @package YandexDirectSDK\Services
 */
class ServiceDynamicTextAdTargets extends Service
{
    final protected function getServiceName(){
        return 'dynamictextadtargets';
    }

    final protected function getMethodList(){
        return array('add','delete','get','resume','setBids','suspend');
    }
}