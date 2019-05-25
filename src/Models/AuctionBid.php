<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\AuctionBids;
use YandexDirectSDK\Components\Model;

/** 
 * Class AuctionBid 
 * 
 * @property-readable   string    $position 
 * @property-readable   integer   $bid 
 * @property-readable   integer   $price 
 * 
 * @method              string    getPosition() 
 * @method              integer   getBid() 
 * @method              integer   getPrice() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class AuctionBid extends Model 
{ 
    protected $compatibleCollection = AuctionBids::class;

    protected $properties = [
        'position' => 'string',
        'bid' => 'integer',
        'price' => 'integer'
    ];

    protected $nonWritableProperties = [
        'position',
        'bid',
        'price'
    ];
}