<?php

namespace YandexDirectSDK\Models;

use YandexDirectSDK\Components\Model;

/** 
 * Class RelevantKeywordsSetting 
 * 
 * @property          integer   $budgetPercent
 * @property          integer   $optimizeGoalId
 * 
 * @method            $this     setBudgetPercent(integer $budgetPercent)
 * @method            $this     setOptimizeGoalId(integer $optimizeGoalId)
 * 
 * @method            integer   getBudgetPercent()
 * @method            integer   getOptimizeGoalId()
 * 
 * @package YandexDirectSDK\Models 
 */
class RelevantKeywordsSetting extends Model
{
    protected static $properties = [
        'budgetPercent' => 'integer',
        'optimizeGoalId' => 'integer'
    ];
}