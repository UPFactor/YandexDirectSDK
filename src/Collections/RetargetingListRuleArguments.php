<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\RetargetingListRuleArgument; 

/** 
 * Class RetargetingListRuleArguments 
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class RetargetingListRuleArguments extends ModelCollection 
{ 
    /** 
     * @var RetargetingListRuleArgument[] 
     */ 
    protected $items = []; 

    /** 
     * @var RetargetingListRuleArgument 
     */ 
    protected $compatibleModel = RetargetingListRuleArgument::class; 

    protected $serviceProvidersMethods = []; 
}