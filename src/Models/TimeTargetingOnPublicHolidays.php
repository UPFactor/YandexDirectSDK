<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class TimeTargetingOnPublicHolidays 
 * 
 * @property          string    $suspendOnHolidays
 * @property          integer   $bidPercent
 * @property          integer   $startHour
 * @property          integer   $endHour
 * 
 * @method            $this     setSuspendOnHolidays(string $suspendOnHolidays)
 * @method            $this     setBidPercent(integer $bidPercent)
 * @method            $this     setStartHour(integer $startHour)
 * @method            $this     setEndHour(integer $endHour)
 * 
 * @method            string    getSuspendOnHolidays()
 * @method            integer   getBidPercent()
 * @method            integer   getStartHour()
 * @method            integer   getEndHour()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class TimeTargetingOnPublicHolidays extends Model 
{
    const YES = 'YES';
    const NO = 'NO';

    protected static $properties = [
        'suspendOnHolidays' => 'enum:' . self::YES . ',' . self::NO,
        'bidPercent' => 'integer',
        'startHour' => 'integer',
        'endHour' => 'integer'
    ];
}