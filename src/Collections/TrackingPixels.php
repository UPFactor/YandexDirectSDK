<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\ModelCollection;
use YandexDirectSDK\Models\TrackingPixel; 

/** 
 * Class TrackingPixels 
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class TrackingPixels extends ModelCollection 
{ 
    /** 
     * @var TrackingPixel[] 
     */ 
    protected $items = []; 

    /** 
     * @var TrackingPixel 
     */ 
    protected static $compatibleModel = TrackingPixel::class; 
}