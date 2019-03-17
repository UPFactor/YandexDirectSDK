<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class StrategyCpMaximumImpressions 
 * 
 * @property   integer   $averageCpm 
 * @property   integer   $spendLimit 
 * @property   string    $startDate 
 * @property   string    $endDate 
 * @property   string    $autoContinue 
 * 
 * @method     $this     setAverageCpm(integer $averageCpm) 
 * @method     $this     setSpendLimit(integer $spendLimit) 
 * @method     $this     setStartDate(string $startDate) 
 * @method     $this     setEndDate(string $endDate) 
 * @method     $this     setAutoContinue(string $autoContinue) 
 * 
 * @method     integer   getAverageCpm() 
 * @method     integer   getSpendLimit() 
 * @method     string    getStartDate() 
 * @method     string    getEndDate() 
 * @method     string    getAutoContinue() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class StrategyCpMaximumImpressions extends Model 
{
    const YES = 'YES';
    const NO = 'NO';

    protected $properties = [
        'averageCpm' => 'integer',
        'spendLimit' => 'integer',
        'startDate' => 'string',
        'endDate' => 'string',
        'autoContinue' => 'enum:' . self::YES . ',' .self::NO
    ];
}