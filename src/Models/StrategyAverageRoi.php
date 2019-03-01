<?php

namespace YandexDirectSDK\Models;

use YandexDirectSDK\Components\Model;

/** 
 * Class StrategyAverageRoi 
 * 
 * @property   integer   $reserveReturn 
 * @property   integer   $roiCoef 
 * @property   integer   $goalId 
 * @property   integer   $weeklySpendLimit 
 * @property   integer   $bidCeiling 
 * @property   integer   $profitability 
 * 
 * @method     $this     setReserveReturn(integer $reserveReturn) 
 * @method     $this     setRoiCoef(integer $roiCoef) 
 * @method     $this     setGoalId(integer $goalId) 
 * @method     $this     setWeeklySpendLimit(integer $weeklySpendLimit) 
 * @method     $this     setBidCeiling(integer $bidCeiling) 
 * @method     $this     setProfitability(integer $profitability) 
 * 
 * @method     integer   getReserveReturn() 
 * @method     integer   getRoiCoef() 
 * @method     integer   getGoalId() 
 * @method     integer   getWeeklySpendLimit() 
 * @method     integer   getBidCeiling() 
 * @method     integer   getProfitability() 
 * 
 * @package YandexDirectSDK\Models 
 */
class StrategyAverageRoi extends Model
{
    protected $properties = [
        'reserveReturn' => 'integer',
        'roiCoef' => 'integer',
        'goalId' => 'integer',
        'weeklySpendLimit' => 'integer',
        'bidCeiling' => 'integer',
        'profitability' => 'integer'
    ];

    protected $nonWritableProperties = [];

    protected $nonReadableProperties = [];

    protected $requiredProperties = [
        'reserveReturn',
        'roiCoef',
        'goalId'
    ];
}