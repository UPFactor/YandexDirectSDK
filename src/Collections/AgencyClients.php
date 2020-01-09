<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder; 
use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\AgencyClient;
use YandexDirectSDK\Services\AgencyClientsService;

/** 
 * Class AgencyClients 
 * 
 * @method static     QueryBuilder                        query()
 * @method static     AgencyClient|AgencyClients|null     find($logins, array $fields)
 * @method            Result                              update()
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class AgencyClients extends ModelCollection 
{
    /**
     * @var AgencyClient[] 
     */ 
    protected $items = []; 

    /** 
     * @var string|AgencyClient
     */ 
    protected static $compatibleModel = AgencyClient::class;

    protected static $staticMethods = [
        'query' => AgencyClientsService::class,
        'find' => AgencyClientsService::class
    ];

    protected static $methods = [
        'update' => AgencyClientsService::class
    ];

    public static function getClassName(): string
    {
        return 'Clients';
    }
}