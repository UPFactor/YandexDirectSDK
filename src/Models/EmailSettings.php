<?php

namespace YandexDirectSDK\Models;

use YandexDirectSDK\Components\Model;

/** 
 * Class EmailSettings 
 * 
 * @property          string    $email
 * @property          integer   $checkPositionInterval
 * @property          integer   $warningBalance
 * @property          string    $sendAccountNews
 * @property          string    $sendWarnings
 * 
 * @method            $this     setEmail(string $email)
 * @method            $this     setCheckPositionInterval(integer $checkPositionInterval)
 * @method            $this     setWarningBalance(integer $warningBalance)
 * @method            $this     setSendAccountNews(string $sendAccountNews)
 * @method            $this     setSendWarnings(string $sendWarnings)
 * 
 * @method            string    getEmail()
 * @method            integer   getCheckPositionInterval()
 * @method            integer   getWarningBalance()
 * @method            string    getSendAccountNews()
 * @method            string    getSendWarnings()
 * 
 * @package YandexDirectSDK\Models 
 */
class EmailSettings extends Model
{
    const YES = 'YES';
    const NO = 'NO';

    protected static $properties = [
        'email' => 'string',
        'checkPositionInterval' => 'integer',
        'warningBalance' => 'integer',
        'sendAccountNews' => 'enum:' . self::YES . ',' . self::NO,
        'sendWarnings' => 'enum:' . self::YES . ',' . self::NO
    ];
}