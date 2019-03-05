<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\Client;
use YandexDirectSDK\Services\AgencyClientsService;

/**  
 * Class Clients 
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class Clients extends ModelCollection 
{ 
    /** 
     * @var Client[] 
     */ 
    protected $items = []; 

    /** 
     * @var Client 
     */ 
    protected $compatibleModel = Client::class;

    protected $serviceProvidersMethods = [
        'add' => AgencyClientsService::class,
        'query' => AgencyClientsService::class,
        'update' => AgencyClientsService::class
    ];
}