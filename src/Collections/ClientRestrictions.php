<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\ClientRestriction; 

/** 
 * Class ClientRestrictions 
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class ClientRestrictions extends ModelCollection 
{ 
    /** 
     * @var ClientRestriction[] 
     */ 
    protected $items = []; 

    /** 
     * @var ClientRestriction 
     */ 
    protected static $compatibleModel = ClientRestriction::class;
}