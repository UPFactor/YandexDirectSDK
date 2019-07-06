<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model;

/** 
 * Class Search 
 * 
 * @property-read   integer       $bid
 * @property-read   AuctionBids   $auctionBids
 * 
 * @method          integer       getBid()
 * @method          AuctionBids   getAuctionBids()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class Search extends Model 
{ 
    protected static $properties = [
        'bid' => 'integer',
        'auctionBids' => 'object:' . AuctionBids::class
    ];

    protected static $nonWritableProperties = [
        'bid',
        'auctionBids'
    ];
}