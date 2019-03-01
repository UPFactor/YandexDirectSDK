<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Collections\SitelinksSets;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Interfaces\ModelCommon;
use YandexDirectSDK\Models\SitelinksSet;

/** 
 * Class SitelinksService 
 * 
 * @method   Result         add(ModelCommon $sitelinksSets) 
 * @method   QueryBuilder   query() 
 * @method   Result         delete(ModelCommon|integer[]|integer $sitelinksSets) 
 * 
 * @package YandexDirectSDK\Services 
 */
class SitelinksService extends Service
{
    protected $serviceName = 'sitelinks';

    protected $serviceModelClass = SitelinksSet::class;

    protected $serviceModelCollectionClass = SitelinksSets::class;

    protected $serviceMethods = [
        'add' => 'add:addCollection',
        'query' => 'get:selectionElements',
        'delete' => 'delete:actionByIds'
    ];
}