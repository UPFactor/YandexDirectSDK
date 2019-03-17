<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class MobileAppAdGroup 
 * 
 * @property        string                $storeUrl 
 * @property        string[]              $targetDeviceType 
 * @property        string                $targetCarrier 
 * @property        string                $targetOperatingSystemVersion 
 * @property-read   ExtensionModeration   $appIconModeration 
 * @property-read   string                $appOperatingSystemType 
 * @property-read   string                $appAvailabilityStatus 
 * 
 * @method          $this                 setStoreUrl(string $storeUrl) 
 * @method          $this                 setTargetDeviceType(string[] $targetDeviceType) 
 * @method          $this                 setTargetCarrier(string $targetCarrier) 
 * @method          $this                 setTargetOperatingSystemVersion(string $targetOperatingSystemVersion) 
 * 
 * @method          string                getStoreUrl() 
 * @method          string[]              getTargetDeviceType() 
 * @method          string                getTargetCarrier() 
 * @method          string                getTargetOperatingSystemVersion() 
 * @method          ExtensionModeration   getAppIconModeration() 
 * @method          string                getAppOperatingSystemType() 
 * @method          string                getAppAvailabilityStatus() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class MobileAppAdGroup extends Model 
{
    const DEVICE_TYPE_MOBILE = 'DEVICE_TYPE_MOBILE';
    const DEVICE_TYPE_TABLET = 'DEVICE_TYPE_TABLET';
    const WI_FI_ONLY = 'WI_FI_ONLY';
    const WI_FI_AND_CELLULAR = 'WI_FI_AND_CELLULAR';

    protected $properties = [
        'storeUrl' => 'string',
        'targetDeviceType' => 'set:' . self::DEVICE_TYPE_MOBILE . ',' . self::DEVICE_TYPE_TABLET,
        'targetCarrier' => 'enum:' . self::WI_FI_ONLY . ',' . self::WI_FI_AND_CELLULAR,
        'targetOperatingSystemVersion' => 'string',
        'appIconModeration' => 'object:' . ExtensionModeration::class,
        'appOperatingSystemType' => 'string',
        'appAvailabilityStatus' => 'string'
    ];

    protected $nonWritableProperties = [
        'appIconModeration',
        'appOperatingSystemType',
        'appAvailabilityStatus'
    ];

    protected $nonUpdatableProperties = [
        'storeUrl'
    ];
}