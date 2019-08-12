<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class TimeTargetingOnPublicHolidays 
 * 
 * @property     string      $suspendOnHolidays
 * @property     integer     $bidPercent
 * @property     integer     $startHour
 * @property     integer     $endHour
 *                           
 * @method       $this       setSuspendOnHolidays(string $suspendOnHolidays)
 * @method       string      getSuspendOnHolidays()
 * @method       $this       setBidPercent(integer $bidPercent)
 * @method       integer     getBidPercent()
 * @method       $this       setStartHour(integer $startHour)
 * @method       integer     getStartHour()
 * @method       $this       setEndHour(integer $endHour)
 * @method       integer     getEndHour()
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