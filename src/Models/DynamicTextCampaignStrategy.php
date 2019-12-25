<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class DynamicTextCampaignStrategy 
 * 
 * @property     DynamicTextCampaignSearchStrategy      $search
 * @property     DynamicTextCampaignNetworkStrategy     $network
 *                                                      
 * @method       $this                                  setSearch(DynamicTextCampaignSearchStrategy|array $search)
 * @method       DynamicTextCampaignSearchStrategy      getSearch()
 * @method       $this                                  setNetwork(DynamicTextCampaignNetworkStrategy|array $network)
 * @method       DynamicTextCampaignNetworkStrategy     getNetwork()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class DynamicTextCampaignStrategy extends Model 
{
    protected static $properties = [
        'search' => 'object:' . DynamicTextCampaignSearchStrategy::class,
        'network' => 'object:' . DynamicTextCampaignNetworkStrategy::class
    ];
}