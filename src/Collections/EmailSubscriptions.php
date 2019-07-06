<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\EmailSubscription; 

/** 
 * Class EmailSubscriptions 
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class EmailSubscriptions extends ModelCollection 
{ 
    /** 
     * @var EmailSubscription[] 
     */ 
    protected $items = []; 

    /** 
     * @var EmailSubscription 
     */ 
    protected static $compatibleModel = EmailSubscription::class;
}