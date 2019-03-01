<?php 
namespace YandexDirectSDK\Collections;

use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Components\ModelCollection as ModelCollection; 
use YandexDirectSDK\Models\Ad;
use YandexDirectSDK\Services\AdsService;

/** 
 * Class Ads 
 * 
 * @method   QueryBuilder   query() 
 * @method   Result         add() 
 * @method   Result         update() 
 * @method   Result         delete() 
 * @method   Result         suspend() 
 * @method   Result         resume() 
 * @method   Result         archive() 
 * @method   Result         unarchive() 
 * @method   Result         moderate() 
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class Ads extends ModelCollection 
{ 
    /** 
     * @var Ad[] 
     */ 
    protected $items = []; 

    protected $compatibleModel = Ad::class;

    protected $serviceProvidersMethods = [
        'query' => AdsService::class,
        'add' => AdsService::class,
        'update' => AdsService::class,
        'delete' => AdsService::class,
        'suspend' => AdsService::class,
        'resume' => AdsService::class,
        'archive' => AdsService::class,
        'unarchive' => AdsService::class,
        'moderate' => AdsService::class
    ];
}