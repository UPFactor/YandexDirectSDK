<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\ModelCollection as ModelCollection; 
use YandexDirectSDK\Models\MobileAppAdFeature; 

/** 
 * Class MobileAppAdFeatures 
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class MobileAppAdFeatures extends ModelCollection 
{ 
    /** 
     * @var MobileAppAdFeature[] 
     */ 
    protected $items = []; 

    protected static $compatibleModel = MobileAppAdFeature::class;
}