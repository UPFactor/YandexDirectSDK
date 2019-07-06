<?php

namespace YandexDirectSDK\Models;

use YandexDirectSDK\Components\Model;

/** 
 * Class StrategyWeeklyClickPackage 
 * 
 * @property          integer   $clicksPerWeek
 * @property          integer   $averageCpc
 * @property          integer   $bidCeiling
 * 
 * @method            $this     setClicksPerWeek(integer $clicksPerWeek)
 * @method            $this     setAverageCpc(integer $averageCpc)
 * @method            $this     setBidCeiling(integer $bidCeiling)
 * 
 * @method            integer   getClicksPerWeek()
 * @method            integer   getAverageCpc()
 * @method            integer   getBidCeiling()
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