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
    protected $properties = [
        'bid' => 'integer',
        'coverage' => 'object:' . Coverage::class
    ];

    protected $nonWritableProperties = [
        'bid',
        'coverage'
    ];
}