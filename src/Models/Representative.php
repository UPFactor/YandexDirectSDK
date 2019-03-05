<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\Representatives;
use YandexDirectSDK\Components\Model;

/** 
 * Class Representative 
 * 
 * @property-read   string   $login 
 * @property-read   string   $email 
 * @property-read   string   $role 
 * 
 * @method          string   getLogin() 
 * @method          string   getEmail() 
 * @method          string   getRole() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class Representative extends Model 
{ 
    const CHIEF = 'CHIEF';
    const DELEGATE = 'DELEGATE';
    const UNKNOWN = 'UNKNOWN';

    protected $compatibleCollection = Representatives::class;

    protected $serviceProvidersMethods = []; 

    protected $properties = [
        'login' => 'string',
        'email' => 'string',
        'role' => 'enum:' . self::CHIEF . ',' . self::DELEGATE . ',' . self::UNKNOWN,
    ];

    protected $nonWritableProperties = [
        'login',
        'email',
        'role'
    ];

    protected $nonReadableProperties = [];

    protected $requiredProperties = []; 
}