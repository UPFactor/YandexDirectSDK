<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\ModelCollection;
use YandexDirectSDK\Models\WebpageBid;

/** 
 * Class WebpageBids 
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class WebpageBids extends ModelCollection 
{ 
    /** 
     * @var WebpageBid[] 
     */ 
    protected $items = []; 

    /** 
     * @var WebpageBid 
     */ 
    protected static $compatibleModel = WebpageBid::class;
}