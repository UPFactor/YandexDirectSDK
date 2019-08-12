<?php

namespace YandexDirectSDK\Models;

use YandexDirectSDK\Components\Model;

/** 
 * Class StrategyMaximumConversionRate 
 * 
 * @property     integer     $weeklySpendLimit
 * @property     integer     $bidCeiling
 * @property     integer     $goalId
 *                           
 * @method       $this       setWeeklySpendLimit(integer $weeklySpendLimit)
 * @method       integer     getWeeklySpendLimit()
 * @method       $this       setBidCeiling(integer $bidCeiling)
 * @method       integer     getBidCeiling()
 * @method       $this       setGoalId(integer $goalId)
 * @method       integer     getGoalId()
 * 
 * @package YandexDirectSDK\Models 
 */
class StrategyMaximumConversionRate extends Model
{
    protected static $properties = [
        'weeklySpendLimit' => 'integer',
        'bidCeiling' => 'integer',
        'goalId' => 'integer'
    ];
}