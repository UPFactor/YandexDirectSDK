<?php 
namespace YandexDirectSDK\Models; 

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
    protected $compatibleCollection; 

    protected $serviceProvidersMethods = []; 

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

    protected $nonReadableProperties = []; 

    protected $requiredProperties = []; 
}