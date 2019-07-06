<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\AuctionBidItems;
use YandexDirectSDK\Components\Model;

/** 
 * Class AuctionBids 
 * 
 * @property-read   AuctionBidItems   $auctionBidItems
 * 
 * @method          AuctionBidItems   getAuctionBidItems()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class AuctionBids extends Model 
{ 
    protected static $properties = [
        'auctionBidItems' => 'object:' . AuctionBidItems::class
    ];

    protected static $nonWritableProperties = [
        'auctionBidItems'
    ];
}