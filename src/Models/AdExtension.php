<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\AdExtensions;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Services\AdExtensionsService;

/** 
 * Class AdExtension 
 * 
 * @property            integer        $id
 * @property            Callout        $callout
 * 
 * @property-readable   string         $associated
 * @property-readable   string         $type
 * @property-readable   string         $state
 * @property-readable   string         $status
 * @property-readable   string         $statusClarification
 * 
 * @method              QueryBuilder   query()
 * @method              Result         add()
 * @method              Result         delete()
 * 
 * @method              $this          setId(integer $id)
 * @method              $this          setCallout(Callout $callout)
 * 
 * @method              integer        getId()
 * @method              string         getAssociated()
 * @method              string         getType()
 * @method              Callout        getCallout()
 * @method              string         getState()
 * @method              string         getStatus()
 * @method              string         getStatusClarification()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class AdExtension extends Model 
{ 
    protected static $compatibleCollection = AdExtensions::class;

    protected static $serviceMethods = [
        'query' => AdExtensionsService::class,
        'add' => AdExtensionsService::class,
        'delete' => AdExtensionsService::class
    ];

    protected static $properties = [
        'id' => 'integer',
        'associated' => 'string',
        'type' => 'string',
        'callout' => 'object:' . Callout::class,
        'state' => 'string',
        'status' => 'string',
        'statusClarification' => 'string'
    ];

    protected static $nonUpdatableProperties = [
        'callout'
    ];

    protected static $nonWritableProperties = [
        'associated',
        'type',
        'state',
        'status',
        'statusClarification'
    ];

    protected static $nonAddableProperties = [
        'id'
    ];
}