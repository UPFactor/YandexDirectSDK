<?php

namespace YandexDirectSDK\Models;

use YandexDirectSDK\Components\Model;

/** 
 * Class Notification 
 * 
 * @property     SmsSettings       $smsSettings
 * @property     EmailSettings     $emailSettings
 *                                 
 * @method       $this             setSmsSettings(SmsSettings $smsSettings)
 * @method       SmsSettings       getSmsSettings()
 * @method       $this             setEmailSettings(EmailSettings $emailSettings)
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