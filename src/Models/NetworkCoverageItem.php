<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\NetworkCoverageItems;
use YandexDirectSDK\Components\Model;

/** 
 * Class NetworkCoverageItem 
 * 
 * @property-read     double      $probability
 * @property-read     integer     $bid
 *                                
 * @method            double      getProbability()
 * @method            integer     getBid()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class NetworkCoverageItem extends Model 
{
    protected static $compatibleCollection = NetworkCoverageItems::class;

    protected static $properties = [
        'probability' => 'double',
        'bid' => 'integer'
    ];

    protected static $nonWritableProperties = [
        'probability',
        'bid'
    ];
}