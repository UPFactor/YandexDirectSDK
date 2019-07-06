<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model;

/** 
 * Class Network 
 * 
 * @property-readable   integer    $bid
 * @property-readable   Coverage   $coverage
 * 
 * @method              integer    getBid()
 * @method              Coverage   getCoverage()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class Network extends Model 
{ 
    protected static $properties = [
        'bid' => 'integer',
        'coverage' => 'object:' . Coverage::class
    ];

    protected static $nonWritableProperties = [
        'bid',
        'coverage'
    ];
}