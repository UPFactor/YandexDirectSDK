<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model;

/** 
 * Class Network 
 * 
 * @property-read     integer      $bid
 * @property-read     Coverage     $coverage
 *                                 
 * @method            integer      getBid()
 * @method            Coverage     getCoverage()
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