<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\AdExtensions;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Services\AdExtensionsService;

/** 
 * Class AdExtension 
 * 
 * @property          integer                           $id
 * @property-read     string                            $associated
 * @property-read     string                            $type
 * @property          Callout                           $callout
 * @property-read     string                            $state
 * @property-read     string                            $status
 * @property-read     string                            $statusClarification
 *                                                      
 * @method static     QueryBuilder                      query()
 * @method static     AdExtension|AdExtensions|null     find(integer|integer[]|AdExtension|AdExtensions|ModelCommonInterface $ids, string[] $fields)
 * @method            Result                            add()
 * @method            Result                            delete()
 * @method            $this                             setId(integer $id)
 * @method            integer                           getId()
 * @method            string                            getAssociated()
 * @method            string                            getType()
 * @method            $this                             setCallout(Callout $callout)
 * @method            Callout                           getCallout()
 * @method            string                            getState()
 * @method            string                            getStatus()
 * @method            string                            getStatusClarification()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class AdExtension extends Model 
{ 
    protected static $compatibleCollection = AdExtensions::class;

    protected static $staticMethods = [
        'query' => AdExtensionsService::class,
        'find' => AdExtensionsService::class
    ];

    protected static $methods = [
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