<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\ClientSetting; 

/** 
 * Class ClientSettings 
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class ClientSettings extends ModelCollection 
{ 
    /** 
     * @var ClientSetting[] 
     */ 
    protected $items = []; 

    /** 
     * @var ClientSetting 
     */ 
    protected $compatibleModel = ClientSetting::class; 

    protected $serviceProvidersMethods = []; 
}