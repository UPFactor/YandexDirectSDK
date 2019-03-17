<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\Sitelink; 

/** 
 * Class Sitelinks 
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class Sitelinks extends ModelCollection 
{ 
    /** 
     * @var Sitelink[] 
     */ 
    protected $items = []; 

    /** 
     * @var Sitelink[] 
     */ 
    protected $compatibleModel = Sitelink::class;
}