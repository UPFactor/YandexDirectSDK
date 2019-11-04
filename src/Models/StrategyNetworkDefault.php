<?php

namespace YandexDirectSDK\Models;

use YandexDirectSDK\Components\Model;

/** 
 * Class StrategyNetworkDefault 
 * 
 * @property     integer     $limitPercent
 *                           
 * @method       $this       setLimitPercent(integer $limitPercent)
 * @method       integer     getLimitPercent()
 * 
 * @package YandexDirectSDK\Models 
 */
class StrategyNetworkDefault extends Model
{
    protected static $properties = [
        'limitPercent' => 'integer'
    ];
}