<?php

namespace YandexDirectSDK\Models;

use YandexDirectSDK\Components\Model;

/** 
 * Class StrategyMaximumClicks 
 * 
 * @property     integer     $weeklySpendLimit
 * @property     integer     $bidCeiling
 *                           
 * @method       $this       setWeeklySpendLimit(integer $weeklySpendLimit)
 * @method       integer     getWeeklySpendLimit()
 * @method       $this       setBidCeiling(integer $bidCeiling)
 * @method       integer     getBidCeiling()
 * 
 * @package YandexDirectSDK\Models 
 */
class StrategyMaximumClicks extends Model
{
    protected static $properties = [
        'weeklySpendLimit' => 'integer',
        'bidCeiling' => 'integer'
    ];
}