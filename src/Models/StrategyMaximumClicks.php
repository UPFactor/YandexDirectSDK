<?php

namespace YandexDirectSDK\Models;

use YandexDirectSDK\Components\Model;

/** 
 * Class StrategyMaximumClicks 
 * 
 * @property   integer   $weeklySpendLimit 
 * @property   integer   $bidCeiling 
 * 
 * @method     $this     setWeeklySpendLimit(integer $weeklySpendLimit) 
 * @method     $this     setBidCeiling(integer $bidCeiling) 
 * 
 * @method     integer   getWeeklySpendLimit() 
 * @method     integer   getBidCeiling() 
 * 
 * @package YandexDirectSDK\Models 
 */
class StrategyMaximumClicks extends Model
{
    protected $properties = [
        'weeklySpendLimit' => 'integer',
        'bidCeiling' => 'integer'
    ];

    protected $nonWritableProperties = [];

    protected $nonReadableProperties = [];

    protected $requiredProperties = [
        'weeklySpendLimit'
    ];
}