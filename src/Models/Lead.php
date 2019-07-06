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
 * @method              QueryBuilder   query()
 * 
 * @method              integer        getId()
 * @method              string         getSubmittedAt()
 * @method              integer        getTurboPageId()
 * @method              string         getTurboPageName()
 * @method              LeadData       getData()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class Lead extends Model 
{ 
    protected static $compatibleCollection = Leads::class;

    protected static $serviceMethods = [
        'query' => LeadsService::class
    ];

    protected static $properties = [
        'id' => 'integer',
        'submittedAt' => 'string',
        'turboPageId' => 'integer',
        'turboPageName' => 'string',
        'data' => 'object:' . LeadData::class
    ];

    protected static $nonWritableProperties = [
        'id',
        'submittedAt',
        'turboPageId',
        'turboPageName',
        'data'
    ];

    protected static $nonAddableProperties = [
        'id'
    ];
}