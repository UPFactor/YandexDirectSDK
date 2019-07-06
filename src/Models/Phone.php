<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model;

/** 
 * Class Phone 
 * 
 * @property       string   $countryCode
 * @property       string   $cityCode
 * @property       string   $phoneNumber
 * @property       string   $extension
 * 
 * @method         $this    setCountryCode(string $countryCode)
 * @method         $this    setCityCode(string $cityCode)
 * @method         $this    setPhoneNumber(string $phoneNumber)
 * @method         $this    setExtension(string $extension)
 * 
 * @method         string   getCountryCode()
 * @method         string   getCityCode()
 * @method         string   getPhoneNumber()
 * @method         string   getExtension()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class Phone extends Model 
{ 
    protected static $properties = [
        'countryCode' => 'string',
        'cityCode' => 'string',
        'phoneNumber' => 'string',
        'extension' => 'string'
    ];
}