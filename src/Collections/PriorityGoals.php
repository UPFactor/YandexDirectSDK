<?php

namespace YandexDirectSDK\Collections;

use YandexDirectSDK\Components\ModelCollection;
use YandexDirectSDK\Models\PriorityGoal;

/** 
 * Class PriorityGoals 
 * 
 * @package YandexDirectSDK\Collections 
 */
class PriorityGoals extends ModelCollection
{
    /**
     * @var PriorityGoal[]
     */
    protected $items = [];

    protected static $compatibleModel = PriorityGoal::class;
}