<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model;

/** 
 * Class NetworkCoverageItem 
 * 
 * @property-read   integer   $probability 
 * @property-read   integer   $bid 
 * 
 * @method          integer   getProbability() 
 * @method          integer   getBid() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class NetworkCoverageItem extends Model 
{ 
    protected $properties = [
        'probability' => 'integer',
        'bid' => 'integer'
    ];

    protected $nonWritableProperties = [
        'probability',
        'bid'
    ];
}