<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\AuctionBidItems;
use YandexDirectSDK\Components\Model;

/** 
 * Class AuctionBidItem 
 * 
 * @property-read   integer   $trafficVolume
 * @property-read   integer   $bid
 * @property-read   integer   $price
 * 
 * @method          integer   getTrafficVolume()
 * @method          integer   getBid()
 * @method          integer   getPrice()
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