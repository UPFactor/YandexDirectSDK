<?php

namespace YandexDirectSDK\Services;

use InvalidArgumentException;
use YandexDirectSDK\Interfaces\ModelCommon;
use YandexDirectSDK\Collections\Clients;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Models\Client;

/** 
 * Class ClientsService 
 * 
 * @method   Result   update(ModelCommon $clients) 
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

    protected $serviceName = 'clients';

    protected $serviceModelClass = Client::class;

    protected $serviceModelCollectionClass = Clients::class;

    protected $serviceMethods = [
        'update' => 'update:updateCollection'
    ];

    /**
     * Returns the parameters of the advertiser and the settings of the user - the representative of the advertiser
     * or the parameters of the agency and the settings of the user - the representative of the agency.
     *
     * @param string|string[] ...$fields
     * @return Result
     */
    public function get(...$fields){
        if (empty($fields)){
            throw new InvalidArgumentException(static::class.". Failed method [get]. Field list cannot be empty.");
        }

        return $this->selectionElements('get')->select($fields)->get();
    }
}