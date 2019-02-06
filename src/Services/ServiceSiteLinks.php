<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Result;

/**
 * Class ServiceSitelinks
 *
 * @method Result add(array $params)
 * @method Result delete(array $params)
 * @method Result get(array $params)
 *
 * @see https://tech.yandex.ru/direct/doc/ref-v5/sitelinks/sitelinks-docpage/
 * @package YandexDirectSDK\Services
 */
class ServiceSiteLinks extends Service
{
    final protected function getServiceName(){
        return 'sitelinks';
    }

    final protected function getMethodList(){
        return array('add','delete','get');
    }
}