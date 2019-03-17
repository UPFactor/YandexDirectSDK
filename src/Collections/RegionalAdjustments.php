<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\RegionalAdjustment; 

/** 
 * Class RegionalAdjustments 
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class RegionalAdjustments extends ModelCollection 
{ 
    /** 
     * @var RegionalAdjustment[] 
     */ 
    protected $items = []; 

    /** 
     * @var RegionalAdjustment 
     */ 
    protected $compatibleModel = RegionalAdjustment::class;
}