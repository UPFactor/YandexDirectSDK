<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\NetworkCoverageItems;
use YandexDirectSDK\Components\Model;

/** 
 * Class NetworkCoverageItem 
 * 
 * @property-readable   integer   $probability
 * @property-readable   integer   $bid
 * 
 * @method              integer   getProbability()
 * @method              integer   getBid()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class NetworkCoverageItem extends Model 
{
    protected $compatibleCollection = NetworkCoverageItems::class;

    protected $properties = [
        'probability' => 'integer',
        'bid' => 'integer'
    ];

    protected $nonWritableProperties = [
        'probability',
        'bid'
    ];
}