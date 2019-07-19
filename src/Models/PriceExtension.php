<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model; 

/** 
 * Class PriceExtension 
 * 
 * @property       integer   $price
 * @property       integer   $oldPrice
 * @property       string    $priceQualifier
 * @property       string    $priceCurrency
 * 
 * @method         $this     setPrice(integer $price)
 * @method         $this     setOldPrice(integer $oldPrice)
 * @method         $this     setPriceQualifier(string $priceQualifier)
 * @method         $this     setPriceCurrency(string $priceCurrency)
 * 
 * @method         integer   getPrice()
 * @method         integer   getOldPrice()
 * @method         string    getPriceQualifier()
 * @method         string    getPriceCurrency()
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

    protected static $compatibleCollection;

    protected static $properties = [
        'price' => 'integer',
        'oldPrice' => 'integer',
        'priceQualifier' => 'enum:' . self::FROM . ',' . self::UP_TO . ',' . self::NONE,
        'priceCurrency' => 'enum:' . self::RUB . ',' . self::BYN . ',' . self::CHF . ',' . self::EUR . ',' . self::KZT . ',' . self::TRY . ',' . self::UAH . ',' . self::USD,
    ];
}