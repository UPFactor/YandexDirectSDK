<?php

namespace YandexDirectSDK\Models;

use YandexDirectSDK\Components\Model;

/** 
 * Class StrategyAverageCpc 
 * 
 * @property       integer   $weeklySpendLimit
 * @property       integer   $averageCpc
 * 
 * @method         $this     setWeeklySpendLimit(integer $weeklySpendLimit)
 * @method         $this     setAverageCpc(integer $averageCpc)
 * 
 * @method         integer   getWeeklySpendLimit()
 * @method         integer   getAverageCpc()
 * 
 * @package YandexDirectSDK\Models 
 */
class StrategyAverageCpc extends Model
{
    protected static $properties = [
        'weeklySpendLimit' => 'integer',
        'averageCpc' => 'integer'
    ];
}