<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\NetworkCoverageItem; 

/** 
 * Class NetworkCoverageItems 
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class NetworkCoverageItems extends ModelCollection 
{ 
    /** 
     * @var NetworkCoverageItem[] 
     */ 
    protected $items = []; 

    /** 
     * @var NetworkCoverageItem
     */ 
    protected $compatibleModel = NetworkCoverageItem::class;
}