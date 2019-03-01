<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder; 
use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\SitelinksSet;
use YandexDirectSDK\Services\SitelinksService;

/** 
 * Class SitelinksSets 
 * 
 * @method   Result         add() 
 * @method   Result         delete() 
 * @method   QueryBuilder   query() 
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class SitelinksSets extends ModelCollection 
{ 
    /** 
     * @var SitelinksSet[] 
     */ 
    protected $items = []; 

    /** 
     * @var SitelinksSet[] 
     */ 
    protected $compatibleModel = SitelinksSet::class;

    protected $serviceProvidersMethods = [
        'add' => SitelinksService::class,
        'delete' => SitelinksService::class,
        'query' => SitelinksService::class
    ];
}