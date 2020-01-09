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
    protected static $compatibleCollection = Representatives::class;

    protected static $properties = [
        'login' => 'string',
        'email' => 'string',
        'role' => 'string',
    ];

    protected static $nonWritableProperties = [
        'login',
        'email',
        'role'
    ];
}