<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class StrategyWbDecreasedPriceForRepeatedImpressions 
 * 
 * @property          integer   $averageCpm
 * @property          integer   $spendLimit
 * 
 * @method            $this     setAverageCpm(integer $averageCpm)
 * @method            $this     setSpendLimit(integer $spendLimit)
 * 
 * @method            integer   getAverageCpm()
 * @method            integer   getSpendLimit()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class StrategyWbDecreasedPriceForRepeatedImpressions extends Model 
{
    protected $properties = [
        'averageCpm' => 'integer',
        'spendLimit' => 'integer'
    ];
}