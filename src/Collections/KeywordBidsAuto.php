<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\KeywordBidAuto;
use YandexDirectSDK\Services\KeywordBidsService;

/** 
 * Class KeywordBidsAuto 
 * 
 * @method   Result   setAuto()
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class KeywordBidsAuto extends ModelCollection 
{ 
    /** 
     * @var KeywordBidAuto[] 
     */ 
    protected $items = []; 

    /** 
     * @var KeywordBidAuto 
     */ 
    protected $compatibleModel = KeywordBidAuto::class;

    protected $serviceProvidersMethods = [
        'setAuto' => KeywordBidsService::class
    ];
}