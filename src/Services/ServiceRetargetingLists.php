<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Result;

/**
 * Class ServiceRetargetingLists
 *
 * @method Result add(array $params)
 * @method Result delete(array $params)
 * @method Result get(array $params)
 * @method Result update(array $params)
 *
 * @see https://tech.yandex.ru/direct/doc/ref-v5/retargetinglists/retargetinglists-docpage/
 * @package YandexDirectSDK\Services
 */
class ServiceRetargetingLists extends Service
{
    final protected function getServiceName(){
        return 'retargetinglists';
    }

    final protected function getMethodList(){
        return array('add','delete','get','update');
    }
}