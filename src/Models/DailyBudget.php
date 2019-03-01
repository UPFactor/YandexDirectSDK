<?php

namespace YandexDirectSDK\Models;

use YandexDirectSDK\Components\Model;

/** 
 * Class DailyBudget 
 * 
 * @property   integer   $amount 
 * @property   string    $mode 
 * 
 * @method     $this     setAmount(integer $amount) 
 * @method     $this     setMode(string $mode) 
 * 
 * @method     integer   getAmount() 
 * @method     string    getMode() 
 * 
 * @package YandexDirectSDK\Models 
 */
class DailyBudget extends Model
{
    const STANDARD = 'STANDARD';
    const DISTRIBUTED = 'DISTRIBUTED';

    protected $properties = [
        'amount' => 'integer',
        'mode' => 'enum:' . self::STANDARD . ',' . self::DISTRIBUTED
    ];

    protected $nonWritableProperties = [];

    protected $nonReadableProperties = [];

    protected $requiredProperties = [
        'amount',
        'mode'
    ];
}