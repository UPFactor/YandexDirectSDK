<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Collections\Clients;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Models\Client;

/** 
 * Class ClientsService 
 * 
 * @method static     Result           update(Client|Clients|ModelCommonInterface $clients)
 * @method static     QueryBuilder     query()
 * 
 * @package YandexDirectSDK\Services 
 */
class ClientsService extends Service
{
    protected static $name = 'clients';

    protected static $modelClass = Client::class;

    protected static $modelCollectionClass = Clients::class;

    protected static $methods = [
        'update' => 'update:updateCollection',
        'query' => 'get:selectionElements'
    ];
}