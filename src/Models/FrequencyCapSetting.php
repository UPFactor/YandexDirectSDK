<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class FrequencyCapSetting 
 * 
 * @property     integer     $impressions
 * @property     integer     $periodDays
 *                           
 * @method       $this       setImpressions(integer $impressions)
 * @method       integer     getImpressions()
 * @method       $this       setPeriodDays(integer $periodDays)
 * @method       integer     getPeriodDays()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class FrequencyCapSetting extends Model 
{
    protected static $properties = [
        'impressions' => 'integer',
        'periodDays' => 'integer'
    ];
}