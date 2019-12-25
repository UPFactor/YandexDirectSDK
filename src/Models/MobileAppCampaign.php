<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\MobileAppCampaignSettings;
use YandexDirectSDK\Components\Model as Model;

/** 
 * Class MobileAppCampaign 
 * 
 * @property     MobileAppCampaignSettings     $settings
 * @property     MobileAppCampaignStrategy     $biddingStrategy
 *                                             
 * @method       $this                         setSettings(MobileAppCampaignSettings|array $settings)
 * @method       MobileAppCampaignSettings     getSettings()
 * @method       $this                         setBiddingStrategy(MobileAppCampaignStrategy|array $biddingStrategy)
 * @method       MobileAppCampaignStrategy     getBiddingStrategy()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class MobileAppCampaign extends Model 
{
    protected static $properties = [
        'settings' => 'object:' . MobileAppCampaignSettings::class,
        'biddingStrategy' => 'object:' . MobileAppCampaignStrategy::class
    ];
}