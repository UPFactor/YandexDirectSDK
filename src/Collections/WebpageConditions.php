<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\WebpageCondition; 

/** 
 * Class WebpageConditions 
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class WebpageConditions extends ModelCollection 
{ 
    /** 
     * @var WebpageCondition[] 
     */ 
    protected $items = []; 

    /** 
     * @var WebpageCondition 
     */ 
    protected $compatibleModel = WebpageCondition::class; 

    protected $serviceProvidersMethods = []; 
}