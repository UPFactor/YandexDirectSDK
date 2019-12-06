<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Collections\Foundation\To;
use YandexDirectSDK\Components\ModelCollection;
use YandexDirectSDK\Models\AudienceTargetBid;

/** 
 * Class AudienceTargetBids 
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class AudienceTargetBids extends ModelCollection 
{ 
    use To;

    /**
     * @var AudienceTargetBid[] 
     */ 
    protected $items = []; 

    /** 
     * @var AudienceTargetBid 
     */ 
    protected static $compatibleModel = AudienceTargetBid::class;
}