<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\LeadData;
use YandexDirectSDK\Collections\Leads;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Services\LeadsService;

/** 
 * Class Lead 
 * 
 * @property-readable   integer        $id 
 * @property-readable   string         $submittedAt 
 * @property-readable   integer        $turboPageId 
 * @property-readable   string         $turboPageName 
 * @property-readable   LeadData       $data 
 * 
 * @method              integer        getId() 
 * @method              string         getSubmittedAt() 
 * @method              integer        getTurboPageId() 
 * @method              string         getTurboPageName() 
 * @method              LeadData       getData() 
 * 
 * @method              QueryBuilder   query() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class Lead extends Model 
{ 
    protected $compatibleCollection = Leads::class;

    protected $serviceProvidersMethods = [
        'query' => LeadsService::class
    ];

    protected $properties = [
        'id' => 'integer',
        'submittedAt' => 'string',
        'turboPageId' => 'integer',
        'turboPageName' => 'string',
        'data' => 'object:' . LeadData::class
    ];

    protected $nonWritableProperties = [
        'id',
        'submittedAt',
        'turboPageId',
        'turboPageName',
        'data'
    ];

    protected $nonAddableProperties = [
        'id'
    ];
}