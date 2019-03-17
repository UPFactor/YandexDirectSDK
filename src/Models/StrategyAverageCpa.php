<?php

namespace YandexDirectSDK\Models;

use YandexDirectSDK\Components\Model;

/** 
 * Class StrategyAverageCpa 
 * 
 * @property   integer   $weeklySpendLimit 
 * @property   integer   $bidCeiling 
 * @property   integer   $goalId 
 * @property   integer   $averageCpa 
 * 
 * @method     $this     setWeeklySpendLimit(integer $weeklySpendLimit) 
 * @method     $this     setBidCeiling(integer $bidCeiling) 
 * @method     $this     setGoalId(integer $goalId) 
 * @method     $this     setAverageCpa(integer $averageCpa) 
 * 
 * @method     integer   getWeeklySpendLimit() 
 * @method     integer   getBidCeiling() 
 * @method     integer   getGoalId() 
 * @method     integer   getAverageCpa() 
 * 
 * @package YandexDirectSDK\Models 
 */
class StrategyAverageCpa extends Model
{
    protected $properties = [
        'weeklySpendLimit' => 'integer',
        'bidCeiling' => 'integer',
        'goalId' => 'integer',
        'averageCpa' => 'integer'
    ];
}