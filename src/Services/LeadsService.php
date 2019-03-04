<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Collections\Leads;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Models\Lead;

/** 
 * Class LeadsService 
 * 
 * @method   QueryBuilder   query() 
 * 
 * @package YandexDirectSDK\Services 
 */
class LeadsService extends Service
{
    protected $serviceName = 'leads';

    protected $serviceModelClass = Lead::class;

    protected $serviceModelCollectionClass = Leads::class;

    protected $serviceMethods = [
        'query' => 'get:selectionElements'
    ];
}