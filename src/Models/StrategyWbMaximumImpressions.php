<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class StrategyWbMaximumImpressions 
 * 
 * @property     integer     $averageCpm
 * @property     integer     $spendLimit
 *                           
 * @method       $this       setAverageCpm(integer $averageCpm)
 * @method       integer     getAverageCpm()
 * @method       $this       setSpendLimit(integer $spendLimit)
 * @method       integer     getSpendLimit()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class StrategyWbMaximumImpressions extends Model 
{
    protected static $properties = [
        'averageCpm' => 'integer',
        'spendLimit' => 'integer'
    ];
}