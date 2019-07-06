<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\NetworkCoverageItems;
use YandexDirectSDK\Components\Model;

/** 
 * Class Coverage 
 * 
 * @property-read   NetworkCoverageItems   $coverageItems
 * 
 * @method          NetworkCoverageItems   getCoverageItems()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class Coverage extends Model 
{ 
    protected static $properties = [
        'coverageItems' => 'object:' . NetworkCoverageItems::class
    ];

    protected static $nonWritableProperties = [
        'coverageItems'
    ];
}