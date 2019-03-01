<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\ModelCollection as ModelCollection; 
use YandexDirectSDK\Models\CpmBannerCampaignSetting; 

/** 
 * Class CpmBannerCampaignSettings 
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class CpmBannerCampaignSettings extends ModelCollection 
{ 
    /** 
     * @var CpmBannerCampaignSetting[] 
     */ 
    protected $items = []; 

    protected $compatibleModel = CpmBannerCampaignSetting::class;
}