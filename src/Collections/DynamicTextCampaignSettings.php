<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\ModelCollection as ModelCollection; 
use YandexDirectSDK\Models\DynamicTextCampaignSetting; 

/** 
 * Class DynamicTextCampaignSettings 
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class DynamicTextCampaignSettings extends ModelCollection 
{ 
   /** 
    * @var DynamicTextCampaignSetting[] 
    */ 
    protected $items = []; 

    protected $compatibleModel = DynamicTextCampaignSetting::class;
}