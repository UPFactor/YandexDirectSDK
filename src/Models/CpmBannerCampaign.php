<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\CpmBannerCampaignSettings;
use YandexDirectSDK\Components\Model as Model;

/** 
 * Class CpmBannerCampaign 
 * 
 * @property     CpmBannerCampaignStrategy     $biddingStrategy
 * @property     CpmBannerCampaignSettings     $settings
 * @property     integer[]                     $counterIds
 * @property     FrequencyCapSetting           $frequencyCap
 *                                             
 * @method       $this                         setBiddingStrategy(CpmBannerCampaignStrategy $biddingStrategy)
 * @method       CpmBannerCampaignStrategy     getBiddingStrategy()
 * @method       $this                         setSettings(CpmBannerCampaignSettings $settings)
 * @method       CpmBannerCampaignSettings     getSettings()
 * @method       $this                         setCounterIds(integer[] $counterIds)
 * @method       integer[]                     getCounterIds()
 * @method       $this                         setFrequencyCap(FrequencyCapSetting $frequencyCap)
 * @method       FrequencyCapSetting           getFrequencyCap()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class CpmBannerCampaign extends Model 
{
    protected static $properties = [
        'biddingStrategy' => 'object:' . CpmBannerCampaignStrategy::class,
        'settings' => 'object:' . CpmBannerCampaignSettings::class,
        'counterIds' => 'array:integer',
        'frequencyCap' => 'object:' . FrequencyCapSetting::class
    ];
}