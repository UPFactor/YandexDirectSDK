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
 * @property-readable   double               $accountQuality 
 * @property-readable   string               $archived 
 * @property            integer              $clientId 
 * @property            string               $clientInfo 
 * @property-readable   integer              $countryId 
 * @property-readable   string               $createdAt 
 * @property            string               $login 
 * @property            string               $firstName 
 * @property            string               $lastName 
 * @property            string               $currency 
 * @property            Grands               $grants 
 * @property            ClientNotification   $notification 
 * @property            string               $phone 
 * @property-readable   integer              $overdraftSumAvailable 
 * @property-readable   Representatives      $representatives 
 * @property-readable   ClientRestrictions   $restrictions 
 * @property            ClientSettings       $settings 
 * @property-readable   string               $type 
 * @property-readable   double               $vatRate 
 * 
 * @method              $this                setClientId(integer $clientId) 
 * @method              $this                setClientInfo(string $clientInfo) 
 * @method              $this                setLogin(string $login) 
 * @method              $this                setFirstName(string $firstName) 
 * @method              $this                setLastName(string $lastName) 
 * @method              $this                setCurrency(string $currency) 
 * @method              $this                setGrants(Grands $grants) 
 * @method              $this                setNotification(ClientNotification $notification) 
 * @method              $this                setPhone(string $phone) 
 * @method              $this                setSettings(ClientSettings $settings) 
 * 
 * @method              double               getAccountQuality() 
 * @method              string               getArchived() 
 * @method              integer              getClientId() 
 * @method              string               getClientInfo() 
 * @method              integer              getCountryId() 
 * @method              string               getCreatedAt() 
 * @method              string               getLogin() 
 * @method              string               getFirstName() 
 * @method              string               getLastName() 
 * @method              string               getCurrency() 
 * @method              Grands               getGrants() 
 * @method              ClientNotification   getNotification() 
 * @method              string               getPhone() 
 * @method              integer              getOverdraftSumAvailable() 
 * @method              Representatives      getRepresentatives() 
 * @method              ClientRestrictions   getRestrictions() 
 * @method              ClientSettings       getSettings() 
 * @method              string               getType() 
 * @method              double               getVatRate() 
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

    protected $compatibleCollection = Clients::class;

    protected $properties = [
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

    protected $nonAddableProperties = [
        'clientInfo',
        'phone'
    ];

    protected $nonUpdatableProperties = [
        'login',
        'firstName',
        'lastName',
        'currency'
    ];

    protected $nonWritableProperties = [
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