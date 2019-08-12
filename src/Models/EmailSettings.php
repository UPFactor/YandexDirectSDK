<?php

namespace YandexDirectSDK\Models;

use YandexDirectSDK\Components\Model;

/** 
 * Class EmailSettings 
 * 
 * @property     string      $email
 * @property     integer     $checkPositionInterval
 * @property     integer     $warningBalance
 * @property     string      $sendAccountNews
 * @property     string      $sendWarnings
 *                           
 * @method       $this       setEmail(string $email)
 * @method       string      getEmail()
 * @method       $this       setCheckPositionInterval(integer $checkPositionInterval)
 * @method       integer     getCheckPositionInterval()
 * @method       $this       setWarningBalance(integer $warningBalance)
 * @method       integer     getWarningBalance()
 * @method       $this       setSendAccountNews(string $sendAccountNews)
 * @method       string      getSendAccountNews()
 * @method       $this       setSendWarnings(string $sendWarnings)
 * @method       string      getSendWarnings()
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