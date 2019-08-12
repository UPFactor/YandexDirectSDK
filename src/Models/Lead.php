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
 * @property-read     integer          $id
 * @property-read     string           $submittedAt
 * @property-read     integer          $turboPageId
 * @property-read     string           $turboPageName
 * @property-read     LeadData         $data
 *                                     
 * @method static     QueryBuilder     query()
 * @method            integer          getId()
 * @method            string           getSubmittedAt()
 * @method            integer          getTurboPageId()
 * @method            string           getTurboPageName()
 * @method            LeadData         getData()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class Lead extends Model 
{ 
    protected static $compatibleCollection = Leads::class;

    protected static $staticMethods = [
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