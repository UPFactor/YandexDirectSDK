<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\AuctionBidItems;
use YandexDirectSDK\Components\Model;

/** 
 * Class AuctionBidItem 
 * 
 * @property-readable   integer   $trafficVolume
 * @property-readable   integer   $bid
 * @property-readable   integer   $price
 * 
 * @method              integer   getTrafficVolume()
 * @method              integer   getBid()
 * @method              integer   getPrice()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class AuctionBidItem extends Model 
{ 
    protected static $compatibleCollection = AuctionBidItems::class;

    protected static $properties = [
        'trafficVolume' => 'integer',
        'bid' => 'integer',
        'price' => 'integer'
    ];

    protected static $nonWritableProperties = [
        'trafficVolume',
        'bid',
        'price'
    ];
}