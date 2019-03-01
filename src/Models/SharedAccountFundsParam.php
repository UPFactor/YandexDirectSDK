<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class SharedAccountFundsParam 
 * 
 * @property-read   integer   $refund 
 * @property-read   integer   $spend 
 * 
 * @method          integer   getRefund() 
 * @method          integer   getSpend() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class SharedAccountFundsParam extends Model 
{ 
    protected $properties = [
        'refund' => 'integer',
        'spend' => 'integer'
    ];

    protected $nonWritableProperties = [
        'refund',
        'spend'
    ];

    protected $nonReadableProperties = []; 

    protected $requiredProperties = []; 
}