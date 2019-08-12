<?php

namespace YandexDirectSDK\Models;

use YandexDirectSDK\Collections\PriorityGoals;
use YandexDirectSDK\Collections\TextCampaignSettings;
use YandexDirectSDK\Components\Model;

/** 
 * Class TextCampaign 
 * 
 * @property     TextCampaignStrategy        $biddingStrategy
 * @property     TextCampaignSettings        $settings
 * @property     integer[]                   $counterIds
 * @property     RelevantKeywordsSetting     $relevantKeywords
 * @property     PriorityGoals               $priorityGoals
 *                                           
 * @method       $this                       setBiddingStrategy(TextCampaignStrategy $biddingStrategy)
 * @method       TextCampaignStrategy        getBiddingStrategy()
 * @method       $this                       setSettings(TextCampaignSettings $settings)
 * @method       TextCampaignSettings        getSettings()
 * @method       $this                       setCounterIds(integer[] $counterIds)
 * @method       integer[]                   getCounterIds()
 * @method       $this                       setRelevantKeywords(RelevantKeywordsSetting $relevantKeywords)
 * @method       RelevantKeywordsSetting     getRelevantKeywords()
 * @method       $this                       setPriorityGoals(PriorityGoals $priorityGoals)
 * @method       PriorityGoals               getPriorityGoals()
 * 
 * @package YandexDirectSDK\Models 
 */
class TextCampaign extends Model
{
    protected static $properties = [
        'biddingStrategy' => 'object:' . TextCampaignStrategy::class,
        'settings' => 'object:' . TextCampaignSettings::class,
        'counterIds' => 'array:integer',
        'relevantKeywords' => 'object:' . RelevantKeywordsSetting::class,
        'priorityGoals' => 'arrayOfObject:' . PriorityGoals::class,
    ];
}