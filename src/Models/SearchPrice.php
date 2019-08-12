<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\SearchPrices;
use YandexDirectSDK\Components\Model;

/** 
 * Class SearchPrice 
 * 
 * @property-read     string      $position
 * @property-read     integer     $price
 *                                
 * @method            string      getPosition()
 * @method            integer     getPrice()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class SearchPrice extends Model 
{
    protected static $compatibleCollection = SearchPrices::class;

    protected static $properties = [
        'position' => 'string',
        'price' => 'integer'
    ];

    protected static $nonWritableProperties = [
        'position',
        'price'
    ];
}