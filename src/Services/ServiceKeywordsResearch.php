<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Result;

/**
 * Class ServiceKeywordsResearch
 *
 * @method Result hasSearchVolume(array $params)
 *
 * @see https://tech.yandex.ru/direct/doc/ref-v5/keywordsresearch/keywordsresearch-docpage/
 * @package YandexDirectSDK\Services
 */
class ServiceKeywordsResearch extends Service
{
    final protected function getServiceName(){
        return 'keywordsresearch';
    }

    final protected function getMethodList(){
        return array('hasSearchVolume');
    }
}