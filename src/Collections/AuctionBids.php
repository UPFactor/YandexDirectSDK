<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\AuctionBid; 

/** 
 * Class AuctionBids 
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class AuctionBids extends ModelCollection 
{ 
    /** 
     * @var AuctionBid[] 
     */ 
    protected $items = []; 

    /** 
     * @var AuctionBid[] 
     */ 
    protected static $compatibleModel = AuctionBid::class;
}