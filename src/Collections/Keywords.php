<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder; 
use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\Keyword;
use YandexDirectSDK\Services\KeywordsService;

/** 
 * Class Keywords 
 * 
 * @method   Result         add() 
 * @method   Result         delete() 
 * @method   QueryBuilder   query() 
 * @method   Result         resume() 
 * @method   Result         suspend() 
 * @method   Result         update() 
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class Keywords extends ModelCollection 
{ 
    /** 
     * @var Keyword[] 
     */ 
    protected $items = []; 

    /** 
     * @var Keyword[] 
     */ 
    protected $compatibleModel = Keyword::class;

    protected $serviceProvidersMethods = [
        'add' => KeywordsService::class,
        'delete' => KeywordsService::class,
        'query' => KeywordsService::class,
        'resume' => KeywordsService::class,
        'suspend' => KeywordsService::class,
        'update' => KeywordsService::class
    ];
}