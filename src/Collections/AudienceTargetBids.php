<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\AudienceTargetBid;
use YandexDirectSDK\Services\AudienceTargetsService;

/** 
 * Class AudienceTargetBids 
 * 
 * @method   Result   setBids()
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class AudienceTargetBids extends ModelCollection 
{ 
    /** 
     * @var AudienceTargetBid[] 
     */ 
    protected $items = []; 

    /** 
     * @var AudienceTargetBid 
     */ 
    protected $compatibleModel = AudienceTargetBid::class;

    protected $serviceProvidersMethods = [
        'setBids' => AudienceTargetsService::class
    ];
}