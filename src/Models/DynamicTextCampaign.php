<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\DynamicTextCampaignSettings;
use YandexDirectSDK\Components\Model as Model;

/** 
 * Class DynamicTextCampaign 
 * 
 * @property     DynamicTextCampaignStrategy     $biddingStrategy
 * @property     DynamicTextCampaignSettings     $settings
 * @property     integer[]                       $counterIds
 *                                               
 * @method       $this                           setBiddingStrategy(DynamicTextCampaignStrategy $biddingStrategy)
 * @method       DynamicTextCampaignStrategy     getBiddingStrategy()
 * @method       $this                           setSettings(DynamicTextCampaignSettings $settings)
 * @method       DynamicTextCampaignSettings     getSettings()
 * @method       $this                           setCounterIds(integer[] $counterIds)
 * @method       integer[]                       getCounterIds()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class DynamicTextCampaign extends Model 
{
    protected static $properties = [
        'biddingStrategy' => 'object:' . DynamicTextCampaignStrategy::class,
        'settings' => 'object:' . DynamicTextCampaignSettings::class,
        'counterIds' => 'array:integer'
    ];
}