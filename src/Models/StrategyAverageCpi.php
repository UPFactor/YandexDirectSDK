<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class StrategyAverageCpi 
 * 
 * @property     integer     $averageCpi
 * @property     integer     $weeklySpendLimit
 * @property     integer     $bidCeiling
 *                           
 * @method       $this       setAverageCpi(integer $averageCpi)
 * @method       integer     getAverageCpi()
 * @method       $this       setWeeklySpendLimit(integer $weeklySpendLimit)
 * @method       integer     getWeeklySpendLimit()
 * @method       $this       setBidCeiling(integer $bidCeiling)
 * @method       integer     getBidCeiling()
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