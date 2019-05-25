<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\RetargetingListRule; 

/** 
 * Class RetargetingListRules 
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class RetargetingListRules extends ModelCollection 
{ 
    /** 
     * @var RetargetingListRule[] 
     */ 
    protected $items = []; 

    /** 
     * @var RetargetingListRule 
     */ 
    protected $compatibleModel = RetargetingListRule::class;
}