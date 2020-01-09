<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Collections\AgencyClients;
use YandexDirectSDK\Interfaces\Model;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Models\AgencyClient;

/** 
 * Class AgencyClientsService 
 * 
 * @method static     Result           create(AgencyClient|Model $agencyClient)
 * @method static     Result           update(AgencyClient|AgencyClients|ModelCommonInterface $agencyClients)
 * @method static     QueryBuilder     query()
 * 
 * @package YandexDirectSDK\Services 
 */
class AgencyClientsService extends Service
{
    protected static $name = 'agencyclients';

    protected static $modelClass = AgencyClient::class;

    protected static $modelCollectionClass = AgencyClients::class;

    protected static $methods = [
        'create' => 'add:addModel',
        'update' => 'update:updateCollection',
        'query' => 'get:createQueryBuilder'
    ];

    /**
     * @param string|string[] $logins
     * @param array $fields
     * @return AgencyClient|AgencyClients|null
     */
    public static function find($logins, array $fields) : ModelCommonInterface
    {
        return static::selectByProperty('get', 'Logins', 'Login', $logins, $fields);
    }
}