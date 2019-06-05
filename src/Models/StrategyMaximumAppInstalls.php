<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class StrategyMaximumAppInstalls 
 * 
 * @property          integer   $weeklySpendLimit
 * @property          integer   $bidCeiling
 * 
 * @method            $this     setWeeklySpendLimit(integer $weeklySpendLimit)
 * @method            $this     setBidCeiling(integer $bidCeiling)
 * 
 * @method            integer   getWeeklySpendLimit()
 * @method            integer   getBidCeiling()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class StrategyMaximumAppInstalls extends Model 
{
    protected $properties = [
        'weeklySpendLimit' => 'integer',
        'bidCeiling' => 'integer'
    ];
}