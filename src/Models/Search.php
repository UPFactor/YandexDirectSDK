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
    protected $compatibleCollection; 

    protected $serviceProvidersMethods = []; 

    protected $properties = [
        'bid' => 'integer',
        'auctionBids' => 'object:' . AuctionBids::class
    ];

    protected $nonWritableProperties = [
        'bid',
        'auctionBids'
    ];

    protected $nonReadableProperties = []; 

    protected $requiredProperties = []; 
}