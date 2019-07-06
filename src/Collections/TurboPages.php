<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\QueryBuilder; 
use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\TurboPage;
use YandexDirectSDK\Services\TurboPagesService;

/** 
 * Class TurboPages 
 * 
 * @method   QueryBuilder   query()
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

    protected static $serviceMethods = [
        'query' => TurboPagesService::class,
    ];
}