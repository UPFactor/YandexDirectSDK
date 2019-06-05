<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\SearchPrices;
use YandexDirectSDK\Components\Model;

/** 
 * Class SearchPrice 
 * 
 * @property-readable   string    $position
 * @property-readable   integer   $price
 * 
 * @method              string    getPosition()
 * @method              integer   getPrice()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class SearchPrice extends Model 
{
    protected $compatibleCollection = SearchPrices::class;

    protected $properties = [
        'position' => 'string',
        'price' => 'integer'
    ];

    protected $nonWritableProperties = [
        'position',
        'price'
    ];
}