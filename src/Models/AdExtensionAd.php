<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\AdExtensionsAd;
use YandexDirectSDK\Components\Model as Model;

/** 
 * Class AdExtensionAd 
 * 
 * @property          integer     $adExtensionId
 * @property-read     string      $type
 * @property          string      $operation
 *                                
 * @method            $this       setAdExtensionId(integer $adExtensionId)
 * @method            integer     getAdExtensionId()
 * @method            string      getType()
 * @method            $this       setOperation(string $operation)
 * @method            string      getOperation()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class AdExtensionAd extends Model 
{
    const ADD = 'ADD';
    const REMOVE = 'REMOVE';
    const SET = 'SET';

    protected static $compatibleCollection = AdExtensionsAd::class;

    protected static $properties = [
        'adExtensionId' => 'integer',
        'type' => 'string',
        'operation' => 'enum:' . self::ADD . ',' . self::REMOVE . ',' . self::SET
    ];

    protected static $nonAddableProperties = [
        'operation'
    ];

    protected static $nonWritableProperties = [
        'type'
    ];
}