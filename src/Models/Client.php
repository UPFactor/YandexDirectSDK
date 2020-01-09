<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\ClientRestrictions;
use YandexDirectSDK\Collections\Clients;
use YandexDirectSDK\Collections\ClientSettings;
use YandexDirectSDK\Collections\Grands;
use YandexDirectSDK\Collections\Representatives;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Services\ClientsService;

/** 
 * Class Client 
 * 
 * @property-read     double                 $accountQuality
 * @property-read     string                 $archived
 * @property-read     integer                $clientId
 * @property          string                 $clientInfo
 * @property-read     integer                $countryId
 * @property-read     string                 $createdAt
 * @property-read     string                 $login
 * @property-read     string                 $currency
 * @property-read     Grands                 $grants
 * @property          ClientNotification     $notification
 * @property          string                 $phone
 * @property-read     integer                $overdraftSumAvailable
 * @property-read     Representatives        $representatives
 * @property-read     ClientRestrictions     $restrictions
 * @property          ClientSettings         $settings
 * @property-read     string                 $type
 * @property-read     double                 $vatRate
 *                                           
 * @method static     QueryBuilder           query()
 * @method            Result                 update()
 * @method            double                 getAccountQuality()
 * @method            string                 getArchived()
 * @method            integer                getClientId()
 * @method            $this                  setClientInfo(string $clientInfo)
 * @method            string                 getClientInfo()
 * @method            integer                getCountryId()
 * @method            string                 getCreatedAt()
 * @method            string                 getLogin()
 * @method            string                 getCurrency()
 * @method            Grands                 getGrants()
 * @method            $this                  setNotification(ClientNotification|array $notification)
 * @method            ClientNotification     getNotification()
 * @method            $this                  setPhone(string $phone)
 * @method            string                 getPhone()
 * @method            integer                getOverdraftSumAvailable()
 * @method            Representatives        getRepresentatives()
 * @method            ClientRestrictions     getRestrictions()
 * @method            $this                  setSettings(ClientSettings|array $settings)
 * @method            ClientSettings         getSettings()
 * @method            string                 getType()
 * @method            double                 getVatRate()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class Client extends Model 
{ 
    protected static $compatibleCollection = Clients::class;

    protected static $staticMethods = [
        'query' => ClientsService::class
    ];

    protected static $methods = [
        'update' => ClientsService::class
    ];

    protected static $properties = [
        'accountQuality' => 'float',
        'archived' => 'string',
        'clientId' => 'integer',
        'clientInfo' => 'string',
        'countryId' => 'integer',
        'createdAt' => 'string',
        'login' => 'string',
        'currency' => 'string',
        'grants' => 'object:' . Grands::class,
        'notification' => 'object:' . ClientNotification::class,
        'phone' => 'string',
        'overdraftSumAvailable' => 'integer',
        'representatives' => 'object:' . Representatives::class,
        'restrictions' => 'object:' . ClientRestrictions::class,
        'settings' => 'object:' . ClientSettings::class,
        'type' => 'string',
        'vatRate' => 'float'
    ];

    protected static $nonWritableProperties = [
        'accountQuality',
        'archived',
        'clientId',
        'countryId',
        'createdAt',
        'login',
        'currency',
        'grants',
        'overdraftSumAvailable',
        'representatives',
        'restrictions',
        'type',
        'vatRate'
    ];
}