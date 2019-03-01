<?php

namespace YandexDirectSDK\Models;

use YandexDirectSDK\Components\Model;

/** 
 * Class StrategyMaximumConversionRate 
 * 
 * @property   integer   $weeklySpendLimit 
 * @property   integer   $bidCeiling 
 * @property   integer   $goalId 
 * 
 * @method     $this     setWeeklySpendLimit(integer $weeklySpendLimit) 
 * @method     $this     setBidCeiling(integer $bidCeiling) 
 * @method     $this     setGoalId(integer $goalId) 
 * 
 * @method     integer   getWeeklySpendLimit() 
 * @method     integer   getBidCeiling() 
 * @method     integer   getGoalId() 
 * 
 * @package YandexDirectSDK\Models 
 */
class StrategyMaximumConversionRate extends Model
{
    protected $properties = [
        'weeklySpendLimit' => 'integer',
        'bidCeiling' => 'integer',
        'goalId' => 'integer'
    ];

    protected $nonWritableProperties = [];

    protected $nonReadableProperties = [];

    protected $requiredProperties = [
        'weeklySpendLimit',
        'goalId'
    ];
}