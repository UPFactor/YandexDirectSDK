<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Interfaces\Model as ModelInterface;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Collections\Clients;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Models\Client;

/** 
 * Class ClientsService 
 * 
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
        'query' => 'get:createQueryBuilder'
    ];

    /**
     * @param Client|Clients|ModelCommonInterface $clients
     * @return Result
     */
    public static function update(ModelCommonInterface $clients):Result
    {
        if ($clients instanceof ModelInterface){
            $clients = $clients::getCompatibleCollectionClass()::make($clients);
        }

        $requestData = $clients->toArray(Model::IS_UPDATABLE);

        for ($i = 0; $i < $clients->count(); $i++){
            unset($requestData[$i]['Grants']);
            unset($requestData[$i]['ClientId']);
        }

        $result = static::call('update', [$clients::getClassName() => $requestData]);

        return $result->setResource(
            $clients->insert($result->data->get('UpdateResults'))
        );
    }
}