<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model;

/** 
 * Class SearchByTrafficVolume 
 * 
 * @property       integer   $targetTrafficVolume
 * @property       integer   $IncreasePercent
 * @property       integer   $BidCeiling
 * 
 * @method         $this     setTargetTrafficVolume(integer $targetTrafficVolume)
 * @method         $this     setIncreasePercent(integer $IncreasePercent)
 * @method         $this     setBidCeiling(integer $BidCeiling)
 * 
 * @method         integer   getTargetTrafficVolume()
 * @method         integer   getIncreasePercent()
 * @method         integer   getBidCeiling()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class SearchByTrafficVolume extends Model 
{ 
    protected static $properties = [
        'targetTrafficVolume' => 'integer',
        'IncreasePercent' => 'integer',
        'BidCeiling' => 'integer'
    ];
}