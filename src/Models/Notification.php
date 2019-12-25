<?php

namespace YandexDirectSDK\Models;

use YandexDirectSDK\Components\Model;

/** 
 * Class Notification 
 * 
 * @property     SmsSettings       $smsSettings
 * @property     EmailSettings     $emailSettings
 *                                 
 * @method       $this             setSmsSettings(SmsSettings|array $smsSettings)
 * @method       SmsSettings       getSmsSettings()
 * @method       $this             setEmailSettings(EmailSettings|array $emailSettings)
 * @method       EmailSettings     getEmailSettings()
 * 
 * @package YandexDirectSDK\Models 
 */
class Notification extends Model
{
    protected static $properties = [
        'smsSettings' => 'object:' . SmsSettings::class,
        'emailSettings' => 'object:' . EmailSettings::class
    ];
}