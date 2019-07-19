<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\QueryBuilder; 
use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\Lead;
use YandexDirectSDK\Services\LeadsService;

/** 
 * Class Leads 
 * 
 * @method   QueryBuilder   query()
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class Leads extends ModelCollection 
{ 
    /** 
     * @var Lead[] 
     */ 
    protected $items = []; 

    /** 
     * @var Lead 
     */ 
    protected static $compatibleModel = Lead::class;

    protected static $staticMethods = [
        'query' => LeadsService::class
    ];
}