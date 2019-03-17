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
 * @property        integer        $id 
 * @property        Callout        $callout 
 * @property-read   string         $associated 
 * @property-read   string         $type 
 * @property-read   string         $state 
 * @property-read   string         $status 
 * @property-read   string         $statusClarification 
 * 
 * @method          $this          setId(integer $id) 
 * @method          $this          setCallout(Callout $callout) 
 * 
 * @method          integer        getId() 
 * @method          Callout        getCallout() 
 * @method          string         getAssociated() 
 * @method          string         getType() 
 * @method          string         getState() 
 * @method          string         getStatus() 
 * @method          string         getStatusClarification() 
 * 
 * @method          QueryBuilder   query() 
 * @method          Result         add() 
 * @method          Result         delete() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class AdExtension extends Model 
{ 
    protected $compatibleCollection = AdExtensions::class;

    protected $serviceProvidersMethods = [
        'query' => AdExtensionsService::class,
        'add' => AdExtensionsService::class,
        'delete' => AdExtensionsService::class
    ];

    protected $properties = [
        'id' => 'integer',
        'associated' => 'string',
        'type' => 'string',
        'callout' => 'object:' . Callout::class,
        'state' => 'string',
        'status' => 'string',
        'statusClarification' => 'string'
    ];

    protected $nonUpdatableProperties = [
        'callout'
    ];

    protected $nonWritableProperties = [
        'associated',
        'type',
        'state',
        'status',
        'statusClarification'
    ];
}