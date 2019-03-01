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
    protected $compatibleCollection; 

    protected $serviceProvidersMethods = []; 

    protected $properties = [
        'coverageItems' => 'object:' . NetworkCoverageItems::class
    ];

    protected $nonWritableProperties = [
        'coverageItems'
    ];

    protected $nonReadableProperties = []; 

    protected $requiredProperties = []; 
}