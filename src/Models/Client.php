<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\ClientRestrictions;
use YandexDirectSDK\Collections\Clients;
use YandexDirectSDK\Collections\ClientSettings;
use YandexDirectSDK\Collections\Grands;
use YandexDirectSDK\Collections\Representatives;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Services\AgencyClientsService;

/**  
 * Class Client 
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

    protected $serviceProvidersMethods = [
        'add' => AgencyClientsService::class,
        'query' => AgencyClientsService::class,
        'update' => AgencyClientsService::class
    ];

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
        'overdraftSumAvailable' => 'integer',
        'phone' => 'string',
        'representatives' => 'object:' . Representatives::class,
        'restrictions' => 'object:' . ClientRestrictions::class,
        'settings' => 'object:' . ClientSettings::class,
        'type' => 'string',
        'vatRate' => 'float'
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

    protected $nonReadableProperties = []; 

    protected $requiredProperties = [
        'login',
        'firstName',
        'lastName',
        'currency',
        'notification'
    ];
}