<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\SearchPrices;
use YandexDirectSDK\Components\Model;

/** 
 * Class SearchPrice 
 * 
 * @property-read   string    $position 
 * @property-read   integer   $price 
 * 
 * @method          string    getPosition() 
 * @method          integer   getPrice() 
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