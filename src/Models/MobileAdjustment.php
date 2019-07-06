<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model;

/** 
 * Class MobileAdjustment 
 * 
 * @property       integer   $bidModifier
 * @property       string    $operatingSystemType
 * 
 * @method         $this     setBidModifier(integer $bidModifier)
 * @method         $this     setOperatingSystemType(string $operatingSystemType)
 * 
 * @method         integer   getBidModifier()
 * @method         string    getOperatingSystemType()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class MobileAdjustment extends Model 
{ 
    const IOS = 'IOS';
    const ANDROID = 'ANDROID';

    protected static $properties = [
        'bidModifier' => 'integer',
        'operatingSystemType' => 'enum:' . self::IOS . ',' . self::ANDROID
    ];
}