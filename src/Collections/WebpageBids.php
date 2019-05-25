<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\ModelCollection;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Models\WebpageBid;
use YandexDirectSDK\Services\DynamicTextAdTargetsService;

/** 
 * Class WebpageBids 
 * 
 * @method   Result   setBids() 
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class WebpageBids extends ModelCollection 
{ 
    /** 
     * @var WebpageBid[] 
     */ 
    protected $items = []; 

    /** 
     * @var WebpageBid 
     */ 
    protected $compatibleModel = WebpageBid::class;

    protected $serviceProvidersMethods = [
        'setBids' => DynamicTextAdTargetsService::class
    ];
}