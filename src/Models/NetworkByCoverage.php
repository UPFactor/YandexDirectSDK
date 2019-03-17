<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model;

/** 
 * Class NetworkByCoverage 
 * 
 * @property   integer   $targetCoverage 
 * @property   integer   $increasePercent 
 * @property   integer   $bidCeiling 
 * 
 * @method     $this     setTargetCoverage(integer $targetCoverage) 
 * @method     $this     setIncreasePercent(integer $increasePercent) 
 * @method     $this     setBidCeiling(integer $bidCeiling) 
 * 
 * @method     integer   getTargetCoverage() 
 * @method     integer   getIncreasePercent() 
 * @method     integer   getBidCeiling() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class NetworkByCoverage extends Model 
{ 
    protected $properties = [
        'targetCoverage' => 'integer',
        'increasePercent' => 'integer',
        'bidCeiling' => 'integer',
    ];
}