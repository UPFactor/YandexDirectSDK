<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Result;

/**
 * Class ServiceChanges
 *
 * @method Result check(array $params)
 * @method Result checkCampaigns(array $params)
 * @method Result checkDictionaries(array $params)
 *
 * @see https://tech.yandex.ru/direct/doc/ref-v5/changes/changes-docpage/
 * @package YandexDirectSDK\Services
 */
class ServiceChanges extends Service
{
    final protected function getServiceName(){
        return 'changes';
    }

    final protected function getMethodList(){
        return array('check','checkCampaigns','checkDictionaries');
    }
}