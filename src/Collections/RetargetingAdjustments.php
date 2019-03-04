<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\RetargetingAdjustment; 

/** 
 * Class RetargetingAdjustments 
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class RetargetingAdjustments extends ModelCollection 
{ 
    /** 
     * @var RetargetingAdjustment[] 
     */ 
    protected $items = []; 

    /** 
     * @var RetargetingAdjustment 
     */ 
    protected $compatibleModel = RetargetingAdjustment::class; 

    protected $serviceProvidersMethods = []; 
}