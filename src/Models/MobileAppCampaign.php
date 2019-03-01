<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\MobileAppCampaignSettings;
use YandexDirectSDK\Components\Model as Model;

/** 
 * Class MobileAppCampaign 
 * 
 * @property   MobileAppCampaignStrategy   $biddingStrategy 
 * @property   MobileAppCampaignSettings   $settings 
 * 
 * @method     $this                       setBiddingStrategy(MobileAppCampaignStrategy $biddingStrategy) 
 * @method     $this                       setSettings(MobileAppCampaignSettings $settings) 
 * 
 * @method     MobileAppCampaignStrategy   getBiddingStrategy() 
 * @method     MobileAppCampaignSettings   getSettings() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class MobileAppCampaign extends Model 
{
    protected $properties = [
        'biddingStrategy' => 'object:' . MobileAppCampaignStrategy::class,
        'settings' => 'object:' . MobileAppCampaignSettings::class,
    ];

    protected $nonWritableProperties = [];

    protected $nonReadableProperties = [];

    protected $requiredProperties = [
        'biddingStrategy'
    ];
}