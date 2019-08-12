<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\AuctionBids;
use YandexDirectSDK\Components\Model;

/** 
 * Class AuctionBid 
 * 
 * @property-read     string      $position
 * @property-read     integer     $bid
 * @property-read     integer     $price
 *                                
 * @method            string      getPosition()
 * @method            integer     getBid()
 * @method            integer     getPrice()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class AuctionBid extends Model 
{ 
    protected static $compatibleCollection = AuctionBids::class;

    protected static $properties = [
        'position' => 'string',
        'bid' => 'integer',
        'price' => 'integer'
    ];

    protected static $nonWritableProperties = [
        'position',
        'bid',
        'price'
    ];
}