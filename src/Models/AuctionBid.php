<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model;

/** 
 * Class AuctionBid 
 * 
 * @property-read   string    $position 
 * @property-read   integer   $bid 
 * @property-read   integer   $price 
 * 
 * @method          string    getPosition() 
 * @method          integer   getBid() 
 * @method          integer   getPrice() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class AuctionBid extends Model 
{ 
    protected $serviceProvidersMethods = []; 

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

    protected $nonReadableProperties = []; 

    protected $requiredProperties = []; 
}