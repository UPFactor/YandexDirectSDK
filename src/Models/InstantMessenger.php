<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model;

/** 
 * Class InstantMessenger 
 * 
 * @property     string     $messengerClient
 * @property     string     $messengerLogin
 *                          
 * @method       $this      setMessengerClient(string $messengerClient)
 * @method       string     getMessengerClient()
 * @method       $this      setMessengerLogin(string $messengerLogin)
 * @method       string     getMessengerLogin()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class InstantMessenger extends Model 
{ 
    protected static $properties = [
        'messengerClient' => 'string',
        'messengerLogin' => 'string'
    ];
}