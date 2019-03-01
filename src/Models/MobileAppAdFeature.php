<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class MobileAppAdFeature 
 * 
 * @property   string   $feature 
 * @property   string   $enabled 
 * 
 * @method     $this    setFeature(string $feature) 
 * @method     $this    setEnabled(string $enabled) 
 * 
 * @method     string   getFeature() 
 * @method     string   getEnabled() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class MobileAppAdFeature extends Model 
{
    const PRICE = 'PRICE';
    const ICON = 'ICON';
    const CUSTOMER_RATING = 'CUSTOMER_RATING';
    const RATINGS = 'RATINGS';
    const YES = 'YES';
    const NO = 'NO';

    protected $serviceProvidersMethods = []; 

    protected $properties = [
        'feature' => 'enum:' . self::PRICE.','.self::ICON.','.self::CUSTOMER_RATING.','.self::RATINGS,
        'enabled' => 'enum:' . self::YES.','.self::NO
    ];

    protected $nonWritableProperties = []; 

    protected $nonReadableProperties = []; 

    protected $requiredProperties = [
        'feature',
        'enabled'
    ];
}