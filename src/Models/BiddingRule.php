<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model;

/** 
 * Class BiddingRule 
 * 
 * @property   SearchByTrafficVolume   $searchByTrafficVolume 
 * @property   NetworkByCoverage       $networkByCoverage 
 * 
 * @method     $this                   setSearchByTrafficVolume(SearchByTrafficVolume $searchByTrafficVolume) 
 * @method     $this                   setNetworkByCoverage(NetworkByCoverage $networkByCoverage) 
 * 
 * @method     SearchByTrafficVolume   getSearchByTrafficVolume() 
 * @method     NetworkByCoverage       getNetworkByCoverage() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class BiddingRule extends Model 
{ 
    protected $compatibleCollection; 

    protected $serviceProvidersMethods = []; 

    protected $properties = [
        'searchByTrafficVolume' => 'object:' . SearchByTrafficVolume::class,
        'networkByCoverage' => 'object:' . NetworkByCoverage::class
    ];

    protected $nonWritableProperties = []; 

    protected $nonReadableProperties = []; 

    protected $requiredProperties = [
        'searchByTrafficVolume|networkByCoverage'
    ];
}