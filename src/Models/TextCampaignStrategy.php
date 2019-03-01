<?php

namespace YandexDirectSDK\Models;

use YandexDirectSDK\Components\Model;

/** 
 * Class TextCampaignStrategy 
 * 
 * @property   TextCampaignSearchStrategy    $search 
 * @property   TextCampaignNetworkStrategy   $network 
 * 
 * @method     $this                         setSearch(TextCampaignSearchStrategy $search) 
 * @method     $this                         setNetwork(TextCampaignNetworkStrategy $network) 
 * 
 * @method     TextCampaignSearchStrategy    getSearch() 
 * @method     TextCampaignNetworkStrategy   getNetwork() 
 * 
 * @package YandexDirectSDK\Models 
 */
class TextCampaignStrategy extends Model
{
    protected $properties = [
        'search' => 'object:' . TextCampaignSearchStrategy::class,
        'network' => 'object:' . TextCampaignNetworkStrategy::class
    ];

    protected $nonWritableProperties = [];

    protected $nonReadableProperties = [];

    protected $requiredProperties = [
        'search',
        'network'
    ];
}