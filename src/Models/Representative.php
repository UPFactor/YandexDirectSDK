<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\Representatives;
use YandexDirectSDK\Components\Model;

/** 
 * Class Representative 
 * 
 * @property-read     string     $login
 * @property-read     string     $email
 * @property-read     string     $role
 *                               
 * @method            string     getLogin()
 * @method            string     getEmail()
 * @method            string     getRole()
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