<?php

namespace YandexDirectSDK\Models;

use YandexDirectSDK\Components\Model;

/** 
 * Class SmsSettings 
 * 
 * @property   string[]   $events 
 * @property   string     $timeFrom 
 * @property   string     $timeTo 
 * 
 * @method     $this      setEvents(string[] $events) 
 * @method     $this      setTimeFrom(string $timeFrom) 
 * @method     $this      setTimeTo(string $timeTo) 
 * 
 * @method     string[]   getEvents() 
 * @method     string     getTimeFrom() 
 * @method     string     getTimeTo() 
 * 
 * @package YandexDirectSDK\Models 
 */
class SmsSettings extends Model
{
    const MONITORING = 'MONITORING';
    const MODERATION = 'MODERATION';
    const MONEY_IN = 'MONEY_IN';
    const MONEY_OUT = 'MONEY_OUT';
    const FINISHED = 'FINISHED';

    protected $properties = [
        'events' => 'set:' . self::MONITORING . ',' . self::MODERATION . ',' . self::MONEY_IN . ',' . self::MONEY_OUT . ',' . self::FINISHED,
        'timeFrom' => 'string',
        'timeTo' => 'string'
    ];
}