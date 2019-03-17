<?php

namespace YandexDirectSDK\Models;

use YandexDirectSDK\Collections\PriorityGoals;
use YandexDirectSDK\Components\Model;

/** 
 * Class PriorityGoal 
 * 
 * @property   integer   $goalId 
 * @property   integer   $value 
 * 
 * @method     $this     setGoalId(integer $goalId) 
 * @method     $this     setValue(integer $value) 
 * 
 * @method     integer   getGoalId() 
 * @method     integer   getValue() 
 * 
 * @package YandexDirectSDK\Models 
 */
class PriorityGoal extends Model
{
    const SET = 'SET';

    protected $compatibleCollection = PriorityGoals::class;

    protected $properties = [
        'goalId' => 'integer',
        'value' => 'integer',
        'operation' => 'enum:' . self::SET
    ];

    protected $nonAddableProperties = [
        'operation'
    ];
}