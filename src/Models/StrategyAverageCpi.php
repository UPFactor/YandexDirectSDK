<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class StrategyAverageCpi 
 * 
 * @property       integer   $averageCpi
 * @property       integer   $weeklySpendLimit
 * @property       integer   $bidCeiling
 * 
 * @method         $this     setAverageCpi(integer $averageCpi)
 * @method         $this     setWeeklySpendLimit(integer $weeklySpendLimit)
 * @method         $this     setBidCeiling(integer $bidCeiling)
 * 
 * @method         integer   getAverageCpi()
 * @method         integer   getWeeklySpendLimit()
 * @method         integer   getBidCeiling()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class StrategyAverageCpi extends Model 
{
    protected static $properties = [
        'averageCpi' => 'integer',
        'weeklySpendLimit' => 'integer',
        'bidCeiling' => 'integer'
    ];
}