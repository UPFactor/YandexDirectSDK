<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\ContextCoverages;
use YandexDirectSDK\Components\Model;

/** 
 * Class ContextCoverage 
 * 
 * @property-readable   integer   $probability
 * @property-readable   integer   $price
 * 
 * @method              integer   getProbability()
 * @method              integer   getPrice()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class ContextCoverage extends Model 
{ 
    protected static $compatibleCollection = ContextCoverages::class;

    protected static $properties = [
        'probability' => 'integer',
        'price' => 'integer'
    ];

    protected static $nonWritableProperties = [
        'probability',
        'price'
    ];
}