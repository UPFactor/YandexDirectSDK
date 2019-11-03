<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\ContextCoverages;
use YandexDirectSDK\Components\Model;

/** 
 * Class ContextCoverage 
 * 
 * @property-read     double      $probability
 * @property-read     integer     $price
 *                                
 * @method            double      getProbability()
 * @method            integer     getPrice()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class ContextCoverage extends Model 
{ 
    protected static $compatibleCollection = ContextCoverages::class;

    protected static $properties = [
        'probability' => 'double',
        'price' => 'integer'
    ];

    protected static $nonWritableProperties = [
        'probability',
        'price'
    ];
}