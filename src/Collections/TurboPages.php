<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\QueryBuilder; 
use YandexDirectSDK\Components\ModelCollection;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Models\TurboPage;
use YandexDirectSDK\Services\TurboPagesService;

/** 
 * Class TurboPages 
 * 
 * @method static     QueryBuilder                  query()
 * @method static     TurboPage|TurboPages|null     find(integer|integer[]|TurboPage|TurboPages|ModelCommonInterface $ids, string[] $fields)
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class TurboPages extends ModelCollection 
{ 
    /** 
     * @var TurboPage[] 
     */ 
    protected $items = []; 

    /** 
     * @var TurboPage 
     */ 
    protected static $compatibleModel = TurboPage::class;

    protected static $staticMethods = [
        'query' => TurboPagesService::class,
        'find' => TurboPagesService::class
    ];
}