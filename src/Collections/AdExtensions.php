<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder; 
use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\AdExtension;
use YandexDirectSDK\Services\AdExtensionsService;

/** 
 * Class AdExtensions 
 * 
 * @method   QueryBuilder   query()
 * @method   Result         add()
 * @method   Result         delete()
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class AdExtensions extends ModelCollection 
{ 
    /** 
     * @var AdExtension[] 
     */ 
    protected $items = []; 

    /** 
     * @var AdExtension 
     */ 
    protected $compatibleModel = AdExtension::class;

    protected $serviceProvidersMethods = [
        'query' => AdExtensionsService::class,
        'add' => AdExtensionsService::class,
        'delete' => AdExtensionsService::class
    ];
}