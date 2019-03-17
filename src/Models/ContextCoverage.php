<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model;

/** 
 * Class ContextCoverage 
 * 
 * @property-read   integer   $probability 
 * @property-read   integer   $price 
 * 
 * @method          integer   getProbability() 
 * @method          integer   getPrice() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class ContextCoverage extends Model 
{ 
    protected $properties = [
        'probability' => 'integer',
        'price' => 'integer'
    ];

    protected $nonWritableProperties = [
        'probability',
        'price'
    ];
}