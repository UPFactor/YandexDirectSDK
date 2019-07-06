<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Interfaces\Model;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Collections\Clients;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Models\Client;

/** 
 * Class AgencyClientsService 
 * 
 * @method   Result         add(Client|Model $client)
 * @method   Result         update(Client|Clients|ModelCommonInterface $clients)
 * @method   QueryBuilder   query()
 * 
 * @package YandexDirectSDK\Services 
 */
class AgencyClientsService extends Service
{
    protected static $name = 'agencyclients';

    protected static $modelClass = Client::class;

    protected static $modelCollectionClass = Clients::class;

    protected static $methods = [
        'add' => 'add:addModel',
        'update' => 'update:updateCollection',
        'query' => 'get:selectionElements'
    ];
}