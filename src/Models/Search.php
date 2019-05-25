<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model;

/** 
 * Class Search 
 * 
 * @property-readable   integer       $bid 
 * @property-readable   AuctionBids   $auctionBids 
 * 
 * @method              integer       getBid() 
 * @method              AuctionBids   getAuctionBids() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class Search extends Model 
{ 
    protected $properties = [
        'bid' => 'integer',
        'auctionBids' => 'object:' . AuctionBids::class
    ];

    protected $nonWritableProperties = [
        'bid',
        'auctionBids'
    ];
}