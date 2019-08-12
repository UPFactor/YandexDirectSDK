<?php

namespace YandexDirectSDK\Models;

use YandexDirectSDK\Components\Model;

/** 
 * Class StrategyAverageRoi 
 * 
 * @property     integer     $reserveReturn
 * @property     integer     $roiCoef
 * @property     integer     $goalId
 * @property     integer     $weeklySpendLimit
 * @property     integer     $bidCeiling
 * @property     integer     $profitability
 *                           
 * @method       $this       setReserveReturn(integer $reserveReturn)
 * @method       integer     getReserveReturn()
 * @method       $this       setRoiCoef(integer $roiCoef)
 * @method       integer     getRoiCoef()
 * @method       $this       setGoalId(integer $goalId)
 * @method       integer     getGoalId()
 * @method       $this       setWeeklySpendLimit(integer $weeklySpendLimit)
 * @method       integer     getWeeklySpendLimit()
 * @method       $this       setBidCeiling(integer $bidCeiling)
 * @method       integer     getBidCeiling()
 * @method       $this       setProfitability(integer $profitability)
 * @method       integer     getProfitability()
 * 
 * @package YandexDirectSDK\Models 
 */
class StrategyAverageRoi extends Model
{
    protected static $properties = [
        'reserveReturn' => 'integer',
        'roiCoef' => 'integer',
        'goalId' => 'integer',
        'weeklySpendLimit' => 'integer',
        'bidCeiling' => 'integer',
        'profitability' => 'integer'
    ];
}