<?php

namespace YandexDirectSDK\Services;

use UPTools\Arr;
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
 * @package YandexDirectSDK\Services 
 */
class ClientsService extends Service
{
    protected static $name = 'clients';

    protected static $modelClass = Client::class;

    protected static $modelCollectionClass = Clients::class;

    /**
     * Creating a query builder.
     *
     * @return QueryBuilder
     */
    public static function query() : QueryBuilder
    {
        return static::createQueryBuilder('get', function($query){
            return ['FieldNames' => $query['FieldNames']];
        });
    }

    /**
     * Method for updating collection data.
     *
     * @param Client|Clients|ModelCommonInterface $clients
     * @return Result
     */
    public static function update(ModelCommonInterface $clients):Result
    {
        if ($clients instanceof ModelInterface){
            $clients = $clients->toCollection();
        }

        $requestData = $clients->toData(Model::IS_UPDATABLE)->map(function($data){
            if (isset($data['Settings'])){
                $data['Settings'] =  array_values(Arr::filter($data['Settings'], function($setting){
                    return $setting['Option'] !== 'SHARED_ACCOUNT_ENABLED';
                }));
            }
            return $data;
        });

        $result = static::call('update', '{"' . $clients::getClassName() . '":' . $requestData->toJson() . '}');
        return $result->setResource(
            $clients->insert($result->data->get('UpdateResults'))
        );
    }
}