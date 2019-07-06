<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\ModelCollection as ModelCollection; 
use YandexDirectSDK\Models\AdExtensionAd; 

/** 
 * Class AdExtensionsAd 
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class AdExtensionsAd extends ModelCollection 
{ 
    /** 
     * @var AdExtensionAd[] 
     */ 
    protected $items = []; 

    protected static $compatibleModel = AdExtensionAd::class;
}