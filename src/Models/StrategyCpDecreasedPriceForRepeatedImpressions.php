<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class StrategyCpDecreasedPriceForRepeatedImpressions 
 * 
 * @property     integer     $averageCpm
 * @property     integer     $spendLimit
 * @property     string      $startDate
 * @property     string      $endDate
 * @property     string      $autoContinue
 *                           
 * @method       $this       setAverageCpm(integer $averageCpm)
 * @method       integer     getAverageCpm()
 * @method       $this       setSpendLimit(integer $spendLimit)
 * @method       integer     getSpendLimit()
 * @method       $this       setStartDate(string $startDate)
 * @method       string      getStartDate()
 * @method       $this       setEndDate(string $endDate)
 * @method       string      getEndDate()
 * @method       $this       setAutoContinue(string $autoContinue)
 * @method       string      getAutoContinue()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class StrategyCpDecreasedPriceForRepeatedImpressions extends Model 
{
    const YES = 'YES';
    const NO = 'NO';

    protected static $properties = [
        'averageCpm' => 'integer',
        'spendLimit' => 'integer',
        'startDate' => 'string',
        'endDate' => 'string',
        'autoContinue' => 'enum:' . self::YES . ',' .self::NO
    ];
}