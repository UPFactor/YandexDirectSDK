<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model;

/** 
 * Class Phone 
 * 
 * @property     string     $countryCode
 * @property     string     $cityCode
 * @property     string     $phoneNumber
 * @property     string     $extension
 *                          
 * @method       $this      setCountryCode(string $countryCode)
 * @method       string     getCountryCode()
 * @method       $this      setCityCode(string $cityCode)
 * @method       string     getCityCode()
 * @method       $this      setPhoneNumber(string $phoneNumber)
 * @method       string     getPhoneNumber()
 * @method       $this      setExtension(string $extension)
 * @method       string     getExtension()
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