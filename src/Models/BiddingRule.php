<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model;

/** 
 * Class BiddingRule 
 * 
 * @property     SearchByTrafficVolume     $searchByTrafficVolume
 * @property     NetworkByCoverage         $networkByCoverage
 *                                         
 * @method       $this                     setSearchByTrafficVolume(SearchByTrafficVolume|array $searchByTrafficVolume)
 * @method       SearchByTrafficVolume     getSearchByTrafficVolume()
 * @method       $this                     setNetworkByCoverage(NetworkByCoverage|array $networkByCoverage)
 * @method       NetworkByCoverage         getNetworkByCoverage()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class BiddingRule extends Model 
{ 
    protected static $compatibleCollection;

    protected static $properties = [
        'searchByTrafficVolume' => 'object:' . SearchByTrafficVolume::class,
        'networkByCoverage' => 'object:' . NetworkByCoverage::class
    ];
}