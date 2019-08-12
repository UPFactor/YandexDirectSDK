<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\NetworkCoverageItems;
use YandexDirectSDK\Components\Model;

/** 
 * Class NetworkCoverageItem 
 * 
 * @property-read     integer     $probability
 * @property-read     integer     $bid
 *                                
 * @method            integer     getProbability()
 * @method            integer     getBid()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class NetworkCoverageItem extends Model 
{
    protected static $compatibleCollection = NetworkCoverageItems::class;

    protected static $properties = [
        'probability' => 'integer',
        'bid' => 'integer'
    ];

    protected static $nonWritableProperties = [
        'probability',
        'bid'
    ];
}