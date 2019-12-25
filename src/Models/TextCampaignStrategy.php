<?php

namespace YandexDirectSDK\Models;

use YandexDirectSDK\Components\Model;

/** 
 * Class TextCampaignStrategy 
 * 
 * @property     TextCampaignSearchStrategy      $search
 * @property     TextCampaignNetworkStrategy     $network
 *                                               
 * @method       $this                           setSearch(TextCampaignSearchStrategy|array $search)
 * @method       TextCampaignSearchStrategy      getSearch()
 * @method       $this                           setNetwork(TextCampaignNetworkStrategy|array $network)
 * @method       TextCampaignNetworkStrategy     getNetwork()
 * 
 * @package YandexDirectSDK\Models 
 */
class TextCampaignStrategy extends Model
{
    protected static $properties = [
        'search' => 'object:' . TextCampaignSearchStrategy::class,
        'network' => 'object:' . TextCampaignNetworkStrategy::class
    ];
}