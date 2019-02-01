<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Result;

/**
 * Class ServiceCampaigns
 *
 * @method Result add(array $params)
 * @method Result archive(array $params)
 * @method Result delete(array $params)
 * @method Result get(array $params)
 * @method Result resume(array $params)
 * @method Result suspend(array $params)
 * @method Result unarchive(array $params)
 * @method Result update(array $params)
 *
 * @see https://tech.yandex.ru/direct/doc/ref-v5/campaigns/campaigns-docpage/
 * @package YandexDirectSDK\Services
 */
class ServiceCampaigns extends Service
{
    final protected function getServiceName(){
        return 'campaigns';
    }

    final protected function getMethodList(){
        return array('add','archive','delete','get','resume','suspend','unarchive','update');
    }
}