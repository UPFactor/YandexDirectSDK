<?php

namespace YandexDirectSDK\Models;

use YandexDirectSDK\Components\Model;

/** 
 * Class StrategyNetworkDefault 
 * 
 * @property   integer   $limitPercent 
 * @property   integer   $bidPercent 
 * 
 * @method     $this     setLimitPercent(integer $limitPercent) 
 * @method     $this     setBidPercent(integer $bidPercent) 
 * 
 * @method     integer   getLimitPercent() 
 * @method     integer   getBidPercent() 
 * 
 * @package YandexDirectSDK\Models 
 */
class StrategyNetworkDefault extends Model
{
    protected $properties = [
        'limitPercent' => 'integer',
        'bidPercent' => 'integer'
    ];

    protected $nonWritableProperties = [];

    protected $nonReadableProperties = [];

    protected $requiredProperties = [];
}