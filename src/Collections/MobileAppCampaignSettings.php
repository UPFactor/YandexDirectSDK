<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\ModelCollection as ModelCollection; 
use YandexDirectSDK\Models\MobileAppCampaignSetting; 

/** 
 * Class MobileAppCampaignSettings 
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class MobileAppCampaignSettings extends ModelCollection 
{ 
    /** 
     * @var MobileAppCampaignSetting[] 
     */ 
    protected $items = []; 

    protected $compatibleModel = MobileAppCampaignSetting::class;
}