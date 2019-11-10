<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\QueryBuilder; 
use YandexDirectSDK\Components\ModelCollection;
use YandexDirectSDK\Models\Creative;
use YandexDirectSDK\Services\CreativesService;

/** 
 * Class Creatives 
 * 
 * @method static     QueryBuilder                query()
 * @method static     Creative|Creatives|null     find(integer|integer[]|string|string[] $ids, string[] $fields=null)
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class Creatives extends ModelCollection 
{ 
    /** 
     * @var Creative[] 
     */ 
    protected $items = []; 

    /** 
     * @var Creative 
     */ 
    protected static $compatibleModel = Creative::class;

    protected static $staticMethods = [
        'query' => CreativesService::class,
        'find' => CreativesService::class
    ];
}