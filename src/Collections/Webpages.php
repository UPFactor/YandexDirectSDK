<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder; 
use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\Webpage;
use YandexDirectSDK\Services\DynamicTextAdTargetsService;

/** 
 * Class Webpages 
 * 
 * @method   Result         add() 
 * @method   Result         delete() 
 * @method   QueryBuilder   query() 
 * @method   Result         resume() 
 * @method   Result         suspend() 
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class Webpages extends ModelCollection 
{ 
    /** 
     * @var Webpage[] 
     */ 
    protected $items = []; 

    /** 
     * @var Webpage 
     */ 
    protected $compatibleModel = Webpage::class;

    protected $serviceProvidersMethods = [
        'add' => DynamicTextAdTargetsService::class,
        'delete' => DynamicTextAdTargetsService::class,
        'query' => DynamicTextAdTargetsService::class,
        'resume' => DynamicTextAdTargetsService::class,
        'suspend' => DynamicTextAdTargetsService::class
    ];
}