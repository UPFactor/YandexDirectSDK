<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class CpmBannerCampaignStrategy 
 * 
 * @property     CpmBannerCampaignSearchStrategy      $search
 * @property     CpmBannerCampaignNetworkStrategy     $network
 *                                                    
 * @method       $this                                setSearch(CpmBannerCampaignSearchStrategy|array $search)
 * @method       CpmBannerCampaignSearchStrategy      getSearch()
 * @method       $this                                setNetwork(CpmBannerCampaignNetworkStrategy|array $network)
 * @method       CpmBannerCampaignNetworkStrategy     getNetwork()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class CpmBannerCampaignStrategy extends Model 
{
    protected static $properties = [
        'search' => 'object:' . CpmBannerCampaignSearchStrategy::class,
        'network' => 'object:' . CpmBannerCampaignNetworkStrategy::class
    ];
}