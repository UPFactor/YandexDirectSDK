<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model;

/** 
 * Class NetworkByCoverage 
 * 
 * @property     integer     $targetCoverage
 * @property     integer     $increasePercent
 * @property     integer     $bidCeiling
 *                           
 * @method       $this       setTargetCoverage(integer $targetCoverage)
 * @method       integer     getTargetCoverage()
 * @method       $this       setIncreasePercent(integer $increasePercent)
 * @method       integer     getIncreasePercent()
 * @method       $this       setBidCeiling(integer $bidCeiling)
 * @method       integer     getBidCeiling()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class NetworkByCoverage extends Model 
{ 
    protected static $properties = [
        'targetCoverage' => 'integer',
        'increasePercent' => 'integer',
        'bidCeiling' => 'integer',
    ];
}