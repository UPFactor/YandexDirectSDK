<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\AuctionBidItem; 

/** 
 * Class AuctionBidItems 
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class AuctionBidItems extends ModelCollection 
{ 
    /** 
     * @var AuctionBidItem[] 
     */ 
    protected $items = []; 

    /** 
     * @var AuctionBidItem[] 
     */ 
    protected $compatibleModel = AuctionBidItem::class; 

    protected $serviceProvidersMethods = []; 
}