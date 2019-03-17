<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\DemographicsAdjustment; 

/** 
 * Class DemographicsAdjustments 
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class DemographicsAdjustments extends ModelCollection 
{ 
    /** 
     * @var DemographicsAdjustment[] 
     */ 
    protected $items = []; 

    /** 
     * @var DemographicsAdjustment 
     */ 
    protected $compatibleModel = DemographicsAdjustment::class;
}