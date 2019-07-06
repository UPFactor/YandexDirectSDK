<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\Client;

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
    protected static $compatibleModel = Client::class;
}