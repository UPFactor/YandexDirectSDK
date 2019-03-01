<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\CpmBannerCampaignSettings;
use YandexDirectSDK\Components\Model as Model;

/** 
 * Class CpmBannerCampaign 
 * 
 * @property   CpmBannerCampaignStrategy   $biddingStrategy 
 * @property   CpmBannerCampaignSettings   $settings 
 * @property   integer[]                   $counterIds 
 * @property   FrequencyCapSetting         $frequencyCap 
 * 
 * @method     $this                       setBiddingStrategy(CpmBannerCampaignStrategy $biddingStrategy) 
 * @method     $this                       setSettings(CpmBannerCampaignSettings $settings) 
 * @method     $this                       setCounterIds(integer[] $counterIds) 
 * @method     $this                       setFrequencyCap(FrequencyCapSetting $frequencyCap) 
 * 
 * @method     CpmBannerCampaignStrategy   getBiddingStrategy() 
 * @method     CpmBannerCampaignSettings   getSettings() 
 * @method     integer[]                   getCounterIds() 
 * @method     FrequencyCapSetting         getFrequencyCap() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class CpmBannerCampaign extends Model 
{
    protected $properties = [
        'biddingStrategy' => 'object:' . CpmBannerCampaignStrategy::class,
        'settings' => 'object:' . CpmBannerCampaignSettings::class,
        'counterIds' => 'array:integer',
        'frequencyCap' => 'object:' . FrequencyCapSetting::class
    ];

    protected $nonWritableProperties = [];

    protected $nonReadableProperties = [];

    protected $requiredProperties = [
        'biddingStrategy'
    ];
}