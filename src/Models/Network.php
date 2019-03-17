<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model;

/** 
 * Class Network 
 * 
 * @property-read   integer    $bid 
 * @property-read   Coverage   $coverage 
 * 
 * @method          integer    getBid() 
 * @method          Coverage   getCoverage() 
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