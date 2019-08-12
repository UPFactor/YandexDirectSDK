<?php

namespace YandexDirectSDK\Models;

use YandexDirectSDK\Components\Model;

/** 
 * Class StrategyAverageCpa 
 * 
 * @property     integer     $weeklySpendLimit
 * @property     integer     $bidCeiling
 * @property     integer     $goalId
 * @property     integer     $averageCpa
 *                           
 * @method       $this       setWeeklySpendLimit(integer $weeklySpendLimit)
 * @method       integer     getWeeklySpendLimit()
 * @method       $this       setBidCeiling(integer $bidCeiling)
 * @method       integer     getBidCeiling()
 * @method       $this       setGoalId(integer $goalId)
 * @method       integer     getGoalId()
 * @method       $this       setAverageCpa(integer $averageCpa)
 * @method       integer     getAverageCpa()
 * 
 * @package YandexDirectSDK\Models 
 */
class StrategyAverageCpa extends Model
{
    protected static $properties = [
        'weeklySpendLimit' => 'integer',
        'bidCeiling' => 'integer',
        'goalId' => 'integer',
        'averageCpa' => 'integer'
    ];
}