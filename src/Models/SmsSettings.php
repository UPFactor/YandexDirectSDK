<?php

namespace YandexDirectSDK\Models;

use YandexDirectSDK\Components\Model;

/** 
 * Class SmsSettings 
 * 
 * @property     string[]     $events
 * @property     string       $timeFrom
 * @property     string       $timeTo
 *                            
 * @method       $this        setEvents(string[] $events)
 * @method       string[]     getEvents()
 * @method       $this        setTimeFrom(string $timeFrom)
 * @method       string       getTimeFrom()
 * @method       $this        setTimeTo(string $timeTo)
 * @method       string       getTimeTo()
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

    protected static $properties = [
        'events' => 'set:' . self::MONITORING . ',' . self::MODERATION . ',' . self::MONEY_IN . ',' . self::MONEY_OUT . ',' . self::FINISHED,
        'timeFrom' => 'string',
        'timeTo' => 'string'
    ];
}