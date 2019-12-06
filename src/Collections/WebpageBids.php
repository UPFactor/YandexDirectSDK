<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\ModelCollection;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Models\WebpageBid;
use YandexDirectSDK\Services\DynamicTextAdTargetsService;

/** 
 * Class WebpageBids 
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
    protected static $compatibleModel = WebpageBid::class;

    public function apply():Result
    {
        return DynamicTextAdTargetsService::setBids($this);
    }
}