<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Collections\Leads;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Models\Lead;

/** 
 * Class LeadsService 
 * 
 * @method static     QueryBuilder     query()
 * 
 * @package YandexDirectSDK\Services 
 */
class LeadsService extends Service
{
    protected static $name = 'leads';

    protected static $modelClass = Lead::class;

    protected static $modelCollectionClass = Leads::class;

    protected static $methods = [
        'query' => 'get:createQueryBuilder'
    ];
}