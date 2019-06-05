<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\BidAuto;
use YandexDirectSDK\Services\BidsService;

/** 
 * Class BidsAuto 
 * 
 * @method   Result   setAuto()
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class BidsAuto extends ModelCollection 
{ 
    /**
     * @var BidAuto[] 
     */ 
    protected $items = []; 

    /** 
     * @var BidAuto[] 
     */ 
    protected $compatibleModel = BidAuto::class;

    protected $serviceProvidersMethods = [
        'setAuto' => BidsService::class
    ];
}