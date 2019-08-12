<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class TimeTargeting 
 * 
 * @property     string[]                          $schedule
 * @property     string                            $considerWorkingWeekends
 * @property     TimeTargetingOnPublicHolidays     $holidaysSchedule
 *                                                 
 * @method       $this                             setSchedule(string[] $schedule)
 * @method       string[]                          getSchedule()
 * @method       $this                             setConsiderWorkingWeekends(string $considerWorkingWeekends)
 * @method       string                            getConsiderWorkingWeekends()
 * @method       $this                             setHolidaysSchedule(TimeTargetingOnPublicHolidays $holidaysSchedule)
 * @method       TimeTargetingOnPublicHolidays     getHolidaysSchedule()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class TimeTargeting extends Model 
{ 
    const YES = 'YES';
    const NO = 'NO';

    protected static $properties = [
        'schedule' => 'array:string',
        'considerWorkingWeekends' => 'enum:' . self::YES . ',' . self::NO,
        'holidaysSchedule' => 'object:' . TimeTargetingOnPublicHolidays::class
    ];
}