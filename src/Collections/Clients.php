<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\ModelCollection;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Models\Client;
use YandexDirectSDK\Services\ClientsService;

/** 
 * Class Clients 
 * 
 * @method static     QueryBuilder     query()
 * @method            Result           update()
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
    protected static $compatibleModel = Client::class;

    protected static $staticMethods = [
        'query' => ClientsService::class
    ];

    protected static $methods = [
        'update' => ClientsService::class
    ];
}