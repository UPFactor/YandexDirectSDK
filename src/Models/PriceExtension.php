<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model; 

/**  
 * Class PriceExtension 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class PriceExtension extends Model 
{
    const FROM = 'FROM';
    const UP_TO = 'UP_TO';
    const NONE = 'NONE';
    const RUB = 'RUB';
    const BYN = 'BYN';
    const CHF = 'CHF';
    const EUR = 'EUR';
    const KZT = 'KZT';
    const TRY = 'TRY';
    const UAH = 'UAH';
    const USD = 'USD';

    protected $compatibleCollection; 

    protected $serviceProvidersMethods = []; 

    protected $properties = [
        'price' => 'integer',
        'oldPrice' => 'integer',
        'priceQualifier' => 'enum:' . self::FROM . ',' . self::UP_TO . ',' . self::NONE,
        'priceCurrency' => 'enum:' . self::RUB . ',' . self::BYN . ',' . self::CHF . ',' . self::EUR . ',' . self::KZT . ',' . self::TRY . ',' . self::UAH . ',' . self::USD,
    ];
}