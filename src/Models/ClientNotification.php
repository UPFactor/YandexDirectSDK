<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\EmailSubscriptions;
use YandexDirectSDK\Components\Model;

/** 
 * Class ClientNotification 
 * 
 * @property            string               $lang 
 * @property-readable   string               $smsPhoneNumber 
 * @property            string               $email 
 * @property            EmailSubscriptions   $emailSubscriptions 
 * 
 * @method              $this                setLang(string $lang) 
 * @method              $this                setEmail(string $email) 
 * @method              $this                setEmailSubscriptions(EmailSubscriptions $emailSubscriptions) 
 * 
 * @method              string               getLang() 
 * @method              string               getSmsPhoneNumber() 
 * @method              string               getEmail() 
 * @method              EmailSubscriptions   getEmailSubscriptions() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class ClientNotification extends Model 
{ 
    const RU = 'RU';
    const UK = 'UK';
    const EN = 'EN';
    const TR = 'TR';

    protected $properties = [
        'lang' => 'enum:' . self::RU . ',' . self::UK . ',' . self::EN . ',' . self::TR,
        'smsPhoneNumber' => 'string',
        'email' => 'string',
        'emailSubscriptions' => 'object:' . EmailSubscriptions::class,
    ];

    protected $nonWritableProperties = [
        'smsPhoneNumber'
    ];
}