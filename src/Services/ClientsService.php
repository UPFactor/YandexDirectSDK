<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Exceptions\ServiceException;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Collections\Clients;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Models\Client;

/** 
 * Class ClientsService 
 * 
 * @method   Result   update(Client|Clients|ModelCommonInterface $clients)
 * 
 * @package YandexDirectSDK\Services 
 */
class ClientsService extends Service
{
    static protected $validFields = [
        "AccountQuality",
        "Archived",
        "ClientId",
        "ClientInfo",
        "CountryId",
        "CreatedAt",
        "Currency",
        "Grants",
        "Login",
        "Notification",
        "OverdraftSumAvailable",
        "Phone",
        "Representatives",
        "Restrictions",
        "Settings",
        "Type",
        "VatRate"
    ];

    protected static $name = 'clients';

    protected static $modelClass = Client::class;

    protected static $modelCollectionClass = Clients::class;

    protected static $methods = [
        'update' => 'update:updateCollection'
    ];

    /**
     * Returns the parameters of the advertiser and the settings of the user - the representative of the advertiser
     * or the parameters of the agency and the settings of the user - the representative of the agency.
     *
     * @param string|string[] ...$fields
     * @return Result
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws ServiceException
     */
    public function get(...$fields){
        if (empty($fields)){
            throw InvalidArgumentException::make(static::class."::get. Field list cannot be empty.");
        }

        return $this->selectionElements('get')->select($fields)->get();
    }
}