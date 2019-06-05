<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class CpmBannerCampaignStrategy 
 * 
 * @property          CpmBannerCampaignSearchStrategy    $search
 * @property          CpmBannerCampaignNetworkStrategy   $network
 * 
 * @method            $this                              setSearch(CpmBannerCampaignSearchStrategy $search)
 * @method            $this                              setNetwork(CpmBannerCampaignNetworkStrategy $network)
 * 
 * @method            CpmBannerCampaignSearchStrategy    getSearch()
 * @method            CpmBannerCampaignNetworkStrategy   getNetwork()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class CpmBannerCampaignStrategy extends Model 
{
    protected $properties = [
        'search' => 'object:' . CpmBannerCampaignSearchStrategy::class,
        'network' => 'object:' . CpmBannerCampaignNetworkStrategy::class
    ];
}