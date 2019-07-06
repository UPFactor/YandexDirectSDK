<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\MobileAppAdFeatures;
use YandexDirectSDK\Components\Model as Model;

/** 
 * Class MobileAppAdFeature 
 * 
 * @property        string   $feature
 * @property        string   $enabled
 * 
 * @property-read   string   $isAvailable
 * 
 * @method          $this    setFeature(string $feature)
 * @method          $this    setEnabled(string $enabled)
 * 
 * @method          string   getFeature()
 * @method          string   getEnabled()
 * @method          string   getIsAvailable()
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

    protected static $compatibleCollection = MobileAppAdFeatures::class;

    protected static $properties = [
        'feature' => 'enum:' . self::PRICE.','.self::ICON.','.self::CUSTOMER_RATING.','.self::RATINGS,
        'enabled' => 'enum:' . self::YES.','.self::NO,
        'isAvailable' => 'string'
    ];

    protected static $nonWritableProperties = [
        'isAvailable'
    ];
}