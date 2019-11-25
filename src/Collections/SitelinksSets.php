<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Collections\Foundation\On;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder; 
use YandexDirectSDK\Components\ModelCollection;
use YandexDirectSDK\Models\SitelinksSet;
use YandexDirectSDK\Services\SitelinksService;

/** 
 * Class SitelinksSets 
 * 
 * @method static     QueryBuilder                        query()
 * @method static     SitelinksSet|SitelinksSets|null     find(integer|integer[]|string|string[] $ids, string[] $fields=null)
 * @method            Result                              add()
 * @method            Result                              delete()
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class SitelinksSets extends ModelCollection 
{ 
    use On;

    /**
     * @var SitelinksSet[] 
     */ 
    protected $items = []; 

    /** 
     * @var SitelinksSet[] 
     */ 
    protected static $compatibleModel = SitelinksSet::class;

    protected static $staticMethods = [
        'query' => SitelinksService::class,
        'find' => SitelinksService::class
    ];

    protected static $methods = [
        'add' => SitelinksService::class,
        'delete' => SitelinksService::class
    ];
}