<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder; 
use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\AdImage;
use YandexDirectSDK\Services\AdImagesService;

/** 
 * Class AdImages 
 * 
 * @method static     QueryBuilder     query()
 * @method            Result           create()
 * @method            Result           delete()
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class AdImages extends ModelCollection 
{ 
    /** 
     * @var AdImage[] 
     */ 
    protected $items = []; 

    /** 
     * @var AdImage 
     */ 
    protected static $compatibleModel = AdImage::class;

    protected static $staticMethods = [
        'query' => AdImagesService::class
    ];

    protected static $methods = [
        'create' => AdImagesService::class,
        'delete' => AdImagesService::class
    ];
}