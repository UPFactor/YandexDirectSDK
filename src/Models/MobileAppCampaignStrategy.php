<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class MobileAppCampaignStrategy 
 * 
 * @property          MobileAppCampaignSearchStrategy    $search
 * @property          MobileAppCampaignNetworkStrategy   $network
 * 
 * @method            $this                              setSearch(MobileAppCampaignSearchStrategy $search)
 * @method            $this                              setNetwork(MobileAppCampaignNetworkStrategy $network)
 * 
 * @method            MobileAppCampaignSearchStrategy    getSearch()
 * @method            MobileAppCampaignNetworkStrategy   getNetwork()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class MobileAppCampaignStrategy extends Model 
{
    protected static $properties = [
        'search' => 'object:' . MobileAppCampaignSearchStrategy::class,
        'network' => 'object:' . MobileAppCampaignNetworkStrategy::class
    ];
}