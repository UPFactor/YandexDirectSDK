<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\Grand; 

/** 
 * Class Grands 
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class Grands extends ModelCollection 
{ 
    /** 
     * @var Grand[] 
     */ 
    protected $items = []; 

    /** 
     * @var Grand 
     */ 
    protected $compatibleModel = Grand::class; 

    protected $serviceProvidersMethods = []; 
}