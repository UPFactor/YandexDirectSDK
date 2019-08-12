<?php

namespace YandexDirectSDK\Models;

use YandexDirectSDK\Components\Model;

/** 
 * Class StrategyWeeklyClickPackage 
 * 
 * @property     integer     $clicksPerWeek
 * @property     integer     $averageCpc
 * @property     integer     $bidCeiling
 *                           
 * @method       $this       setClicksPerWeek(integer $clicksPerWeek)
 * @method       integer     getClicksPerWeek()
 * @method       $this       setAverageCpc(integer $averageCpc)
 * @method       integer     getAverageCpc()
 * @method       $this       setBidCeiling(integer $bidCeiling)
 * @method       integer     getBidCeiling()
 * 
 * @package YandexDirectSDK\Models 
 */
class StrategyWeeklyClickPackage extends Model
{
    protected static $properties = [
        'clicksPerWeek' => 'integer',
        'averageCpc' => 'integer',
        'bidCeiling' => 'integer'
    ];
}