<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\Representative; 

/**  
 * Class Representatives 
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class Representatives extends ModelCollection 
{ 
    /** 
     * @var Representative[] 
     */ 
    protected $items = []; 

    /** 
     * @var Representative 
     */ 
    protected $compatibleModel = Representative::class; 

    protected $serviceProvidersMethods = []; 
}