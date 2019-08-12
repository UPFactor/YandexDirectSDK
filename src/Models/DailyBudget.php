<?php

namespace YandexDirectSDK\Models;

use YandexDirectSDK\Components\Model;

/** 
 * Class DailyBudget 
 * 
 * @property     integer     $amount
 * @property     string      $mode
 *                           
 * @method       $this       setAmount(integer $amount)
 * @method       integer     getAmount()
 * @method       $this       setMode(string $mode)
 * @method       string      getMode()
 * 
 * @package YandexDirectSDK\Models 
 */
class DailyBudget extends Model
{
    const STANDARD = 'STANDARD';
    const DISTRIBUTED = 'DISTRIBUTED';

    protected static $properties = [
        'amount' => 'integer',
        'mode' => 'enum:' . self::STANDARD . ',' . self::DISTRIBUTED
    ];
}