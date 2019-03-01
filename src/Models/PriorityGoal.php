<?php

namespace YandexDirectSDK\Models;

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
    protected $properties = [
        'goalId' => 'integer',
        'value' => 'integer'
    ];

    protected $nonWritableProperties = [];

    protected $nonReadableProperties = [];

    protected $requiredProperties = [
        'goalId',
        'value'
    ];
}