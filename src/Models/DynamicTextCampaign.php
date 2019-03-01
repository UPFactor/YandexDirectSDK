<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\DynamicTextCampaignSettings;
use YandexDirectSDK\Components\Model as Model;

/** 
 * Class DynamicTextCampaign 
 * 
 * @property   DynamicTextCampaignStrategy   $biddingStrategy 
 * @property   DynamicTextCampaignSettings   $settings 
 * @property   integer[]                     $counterIds 
 * 
 * @method     $this                         setBiddingStrategy(DynamicTextCampaignStrategy $biddingStrategy) 
 * @method     $this                         setSettings(DynamicTextCampaignSettings $settings) 
 * @method     $this                         setCounterIds(integer[] $counterIds) 
 * 
 * @method     DynamicTextCampaignStrategy   getBiddingStrategy() 
 * @method     DynamicTextCampaignSettings   getSettings() 
 * @method     integer[]                     getCounterIds() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class DynamicTextCampaign extends Model 
{
    protected $properties = [
        'biddingStrategy' => 'object:' . DynamicTextCampaignStrategy::class,
        'settings' => 'object:' . DynamicTextCampaignSettings::class,
        'counterIds' => 'array:integer'
    ];

    protected $nonWritableProperties = [];

    protected $nonReadableProperties = [];

    protected $requiredProperties = [
        'biddingStrategy'
    ];
}