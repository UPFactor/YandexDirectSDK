<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\ClientRestrictions;
use YandexDirectSDK\Collections\Clients;
use YandexDirectSDK\Collections\ClientSettings;
use YandexDirectSDK\Collections\Grands;
use YandexDirectSDK\Collections\Representatives;
use YandexDirectSDK\Components\Model;

/** 
 * Class Client 
 * 
 * @property-read     double                 $accountQuality
 * @property-read     string                 $archived
 * @property          integer                $clientId
 * @property          string                 $clientInfo
 * @property-read     integer                $countryId
 * @property-read     string                 $createdAt
 * @property          string                 $login
 * @property          string                 $firstName
 * @property          string                 $lastName
 * @property          string                 $currency
 * @property          Grands                 $grants
 * @property          ClientNotification     $notification
 * @property          string                 $phone
 * @property-read     integer                $overdraftSumAvailable
 * @property-read     Representatives        $representatives
 * @property-read     ClientRestrictions     $restrictions
 * @property          ClientSettings         $settings
 * @property-read     string                 $type
 * @property-read     double                 $vatRate
 *                                           
 * @method            double                 getAccountQuality()
 * @method            string                 getArchived()
 * @method            $this                  setClientId(integer $clientId)
 * @method            integer                getClientId()
 * @method            $this                  setClientInfo(string $clientInfo)
 * @method            string                 getClientInfo()
 * @method            integer                getCountryId()
 * @method            string                 getCreatedAt()
 * @method            $this                  setLogin(string $login)
 * @method            string                 getLogin()
 * @method            $this                  setFirstName(string $firstName)
 * @method            string                 getFirstName()
 * @method            $this                  setLastName(string $lastName)
 * @method            string                 getLastName()
 * @method            $this                  setCurrency(string $currency)
 * @method            string                 getCurrency()
 * @method            $this                  setGrants(Grands $grants)
 * @method            Grands                 getGrants()
 * @method            $this                  setNotification(ClientNotification $notification)
 * @method            ClientNotification     getNotification()
 * @method            $this                  setPhone(string $phone)
 * @method            string                 getPhone()
 * @method            integer                getOverdraftSumAvailable()
 * @method            Representatives        getRepresentatives()
 * @method            ClientRestrictions     getRestrictions()
 * @method            $this                  setSettings(ClientSettings $settings)
 * @method            ClientSettings         getSettings()
 * @method            string                 getType()
 * @method            double                 getVatRate()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class Client extends Model 
{ 
    const RUB = 'RUB';
    const BYN = 'BYN';
    const CHF = 'CHF';
    const EUR = 'EUR';
    const KZT = 'KZT';
    const TRY = 'TRY';
    const UAH = 'UAH';
    const USD = 'USD';

    protected static $compatibleCollection = Clients::class;

    protected static $properties = [
        'accountQuality' => 'float',
        'archived' => 'string',
        'clientId' => 'integer',
        'clientInfo' => 'string',
        'countryId' => 'integer',
        'createdAt' => 'string',
        'login' => 'string',
        'firstName' => 'string',
        'lastName' => 'string',
        'currency' => 'enum:' . self::RUB . ',' . self::BYN . ',' . self::CHF . ',' . self::EUR . ',' . self::KZT . ',' . self::TRY . ',' . self::UAH . ',' . self::USD,
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

    protected static $nonAddableProperties = [
        'clientInfo',
        'phone'
    ];

    protected static $nonUpdatableProperties = [
        'login',
        'firstName',
        'lastName',
        'currency'
    ];

    protected static $nonWritableProperties = [
        'accountQuality',
        'archived',
        'countryId',
        'createdAt',
        'overdraftSumAvailable',
        'representatives',
        'restrictions',
        'type',
        'vatRate'
    ];
}