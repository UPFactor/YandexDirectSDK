<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\Representatives;
use YandexDirectSDK\Components\Model;

/** 
 * Class Representative 
 * 
 * @property-readable   string   $login
 * @property-readable   string   $email
 * @property-readable   string   $role
 * 
 * @method              string   getLogin()
 * @method              string   getEmail()
 * @method              string   getRole()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class Representative extends Model 
{ 
    const CHIEF = 'CHIEF';
    const DELEGATE = 'DELEGATE';
    const UNKNOWN = 'UNKNOWN';

    protected static $compatibleCollection = Representatives::class;

    protected static $properties = [
        'login' => 'string',
        'email' => 'string',
        'role' => 'enum:' . self::CHIEF . ',' . self::DELEGATE . ',' . self::UNKNOWN,
    ];

    protected static $nonWritableProperties = [
        'login',
        'email',
        'role'
    ];
}