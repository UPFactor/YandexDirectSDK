<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model;

/** 
 * Class SearchByTrafficVolume 
 * 
 * @property     integer     $targetTrafficVolume
 * @property     integer     $increasePercent
 * @property     integer     $bidCeiling
 *                           
 * @method       $this       setTargetTrafficVolume(integer $targetTrafficVolume)
 * @method       integer     getTargetTrafficVolume()
 * @method       $this       setIncreasePercent(integer $increasePercent)
 * @method       integer     getIncreasePercent()
 * @method       $this       setBidCeiling(integer $bidCeiling)
 * @method       integer     getBidCeiling()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class SearchByTrafficVolume extends Model 
{ 
    protected static $properties = [
        'targetTrafficVolume' => 'integer',
        'increasePercent' => 'integer',
        'bidCeiling' => 'integer'
    ];
}