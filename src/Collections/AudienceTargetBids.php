<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Collections\Foundation\On;
use YandexDirectSDK\Components\ModelCollection;
use YandexDirectSDK\Models\AudienceTargetBid;

/** 
 * Class AudienceTargetBids 
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class AudienceTargetBids extends ModelCollection 
{ 
    use On;

    /**
     * @var AudienceTargetBid[] 
     */ 
    protected $items = []; 

    /** 
     * @var AudienceTargetBid 
     */ 
    protected static $compatibleModel = AudienceTargetBid::class;
}