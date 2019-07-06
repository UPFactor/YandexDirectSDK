<?php

namespace YandexDirectSDK\Models;

use YandexDirectSDK\Collections\PriorityGoals;
use YandexDirectSDK\Components\Model;

/** 
 * Class PriorityGoal 
 * 
 * @property          integer   $goalId
 * @property          integer   $value
 * @property          string    $operation
 * 
 * @method            $this     setGoalId(integer $goalId)
 * @method            $this     setValue(integer $value)
 * @method            $this     setOperation(string $operation)
 * 
 * @method            integer   getGoalId()
 * @method            integer   getValue()
 * @method            string    getOperation()
 * 
 * @package YandexDirectSDK\Models 
 */
class PriorityGoal extends Model
{
    const SET = 'SET';

    protected static $compatibleCollection = PriorityGoals::class;

    protected static $properties = [
        'goalId' => 'integer',
        'value' => 'integer',
        'operation' => 'enum:' . self::SET
    ];

    protected static $nonAddableProperties = [
        'operation'
    ];
}