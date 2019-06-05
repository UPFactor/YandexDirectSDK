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
    protected $compatibleCollection = AuctionBidItems::class;

    protected $properties = [
        'trafficVolume' => 'integer',
        'bid' => 'integer',
        'price' => 'integer'
    ];

    protected $nonWritableProperties = [
        'trafficVolume',
        'bid',
        'price'
    ];
}