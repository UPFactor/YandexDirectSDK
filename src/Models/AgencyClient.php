<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\AgencyClients;
use YandexDirectSDK\Collections\ClientRestrictions;
use YandexDirectSDK\Collections\ClientSettings;
use YandexDirectSDK\Collections\Grands;
use YandexDirectSDK\Collections\Representatives;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Services\AgencyClientsService;

/** 
 * Class AgencyClient 
 * 
 * @property-read     double                              $accountQuality
 * @property-read     string                              $archived
 * @property          integer                             $clientId
 * @property          string                              $clientInfo
 * @property-read     integer                             $countryId
 * @property-read     string                              $createdAt
 * @property          string                              $login
 * @property-read     string                              $password
 * @property-read     string                              $email
 * @property          string                              $firstName
 * @property          string                              $lastName
 * @property          string                              $currency
 * @property          Grands                              $grants
 * @property          ClientNotification                  $notification
 * @property          string                              $phone
 * @property-read     integer                             $overdraftSumAvailable
 * @property-read     Representatives                     $representatives
 * @property-read     ClientRestrictions                  $restrictions
 * @property          ClientSettings                      $settings
 * @property-read     string                              $type
 * @property-read     double                              $vatRate
 *                                                        
 * @method static     QueryBuilder                        query()
 * @method static     AgencyClient|AgencyClients|null     find($logins, array $fields)
 * @method            Result                              create()
 * @method            Result                              update()
 * @method            double                              getAccountQuality()
 * @method            string                              getArchived()
 * @method            $this                               setClientId(integer $clientId)
 * @method            integer                             getClientId()
 * @method            $this                               setClientInfo(string $clientInfo)
 * @method            string                              getClientInfo()
 * @method            integer                             getCountryId()
 * @method            string                              getCreatedAt()
 * @method            $this                               setLogin(string $login)
 * @method            string                              getLogin()
 * @method            string                              getPassword()
 * @method            string                              getEmail()
 * @method            $this                               setFirstName(string $firstName)
 * @method            string                              getFirstName()
 * @method            $this                               setLastName(string $lastName)
 * @method            string                              getLastName()
 * @method            $this                               setCurrency(string $currency)
 * @method            string                              getCurrency()
 * @method            $this                               setGrants(Grands|array $grants)
 * @method            Grands                              getGrants()
 * @method            $this                               setNotification(ClientNotification|array $notification)
 * @method            ClientNotification                  getNotification()
 * @method            $this                               setPhone(string $phone)
 * @method            string                              getPhone()
 * @method            integer                             getOverdraftSumAvailable()
 * @method            Representatives                     getRepresentatives()
 * @method            ClientRestrictions                  getRestrictions()
 * @method            $this                               setSettings(ClientSettings|array $settings)
 * @method            ClientSettings                      getSettings()
 * @method            string                              getType()
 * @method            double                              getVatRate()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class AgencyClient extends Model 
{
    /**
     * @var string|AgencyClients
     */
    protected static $compatibleCollection = AgencyClients::class;

    protected static $staticMethods = [
        'query' => AgencyClientsService::class,
        'find' => AgencyClientsService::class
    ];

    protected static $methods = [
        'create' => AgencyClientsService::class,
        'update' => AgencyClientsService::class
    ];

    protected static $properties = [
        'accountQuality' => 'float',
        'archived' => 'string',
        'clientId' => 'integer',
        'clientInfo' => 'string',
        'countryId' => 'integer',
        'createdAt' => 'string',
        'login' => 'string',
        'password' => 'string',
        'email' => 'string',
        'firstName' => 'string',
        'lastName' => 'string',
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
        'countryId',
        'createdAt',
        'password',
        'email',
        'overdraftSumAvailable',
        'representatives',
        'restrictions',
        'type',
        'vatRate'
    ];

    protected static $nonUpdatableProperties = [
        'login',
        'firstName',
        'lastName',
        'currency'
    ];

    protected static $nonAddableProperties = [
        'clientId',
        'clientInfo',
        'phone'
    ];
}