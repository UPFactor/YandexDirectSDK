<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\EmailSubscriptions;
use YandexDirectSDK\Components\Model;

/** 
 * Class ClientNotification 
 * 
 * @property        string               $lang
 * @property        string               $email
 * @property        EmailSubscriptions   $emailSubscriptions
 * 
 * @property-read   string               $smsPhoneNumber
 * 
 * @method          $this                setLang(string $lang)
 * @method          $this                setEmail(string $email)
 * @method          $this                setEmailSubscriptions(EmailSubscriptions $emailSubscriptions)
 * 
 * @method          string               getLang()
 * @method          string               getSmsPhoneNumber()
 * @method          string               getEmail()
 * @method          EmailSubscriptions   getEmailSubscriptions()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class ClientNotification extends Model 
{ 
    const RU = 'RU';
    const UK = 'UK';
    const EN = 'EN';
    const TR = 'TR';

    protected static $properties = [
        'lang' => 'enum:' . self::RU . ',' . self::UK . ',' . self::EN . ',' . self::TR,
        'smsPhoneNumber' => 'string',
        'email' => 'string',
        'emailSubscriptions' => 'object:' . EmailSubscriptions::class,
    ];

    protected static $nonWritableProperties = [
        'smsPhoneNumber'
    ];
}