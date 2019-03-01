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
    protected $compatibleCollection; 

    protected $serviceProvidersMethods = []; 

    protected $properties = [
        'auctionBidItems' => 'object:' . AuctionBidItems::class
    ];

    protected $nonWritableProperties = [
        'auctionBidItems'
    ];

    protected $nonReadableProperties = []; 

    protected $requiredProperties = []; 
}