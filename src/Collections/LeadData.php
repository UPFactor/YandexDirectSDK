<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\LeadDataItem; 

/** 
 * Class LeadData 
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class LeadData extends ModelCollection 
{ 
    /** 
     * @var LeadDataItem[] 
     */ 
    protected $items = []; 

    /** 
     * @var LeadDataItem 
     */ 
    protected $compatibleModel = LeadDataItem::class; 

    protected $serviceProvidersMethods = []; 
}