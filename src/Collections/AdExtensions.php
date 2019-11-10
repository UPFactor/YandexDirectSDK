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
 * @method static     QueryBuilder                      query()
 * @method static     AdExtension|AdExtensions|null     find(integer|integer[]|string|string[] $ids, string[] $fields=null)
 * @method            Result                            add()
 * @method            Result                            delete()
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
    protected static $compatibleModel = AdExtension::class;

    protected static $staticMethods = [
        'query' => AdExtensionsService::class,
        'find' => AdExtensionsService::class
    ];

    protected static $methods = [
        'add' => AdExtensionsService::class,
        'delete' => AdExtensionsService::class
    ];
}