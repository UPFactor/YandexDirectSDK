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
 * @method   QueryBuilder   query()
 * @method   Result         add()
 * @method   Result         delete()
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
    protected $compatibleModel = AdImage::class;

    protected $serviceProvidersMethods = [
        'query' => AdImagesService::class,
        'add' => AdImagesService::class,
        'delete' => AdImagesService::class
    ];
}