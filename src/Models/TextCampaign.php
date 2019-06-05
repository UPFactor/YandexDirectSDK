<?php

namespace YandexDirectSDK\Models;

use YandexDirectSDK\Collections\PriorityGoals;
use YandexDirectSDK\Collections\TextCampaignSettings;
use YandexDirectSDK\Components\Model;

/** 
 * Class TextCampaign 
 * 
 * @property          TextCampaignStrategy      $biddingStrategy
 * @property          TextCampaignSettings      $settings
 * @property          integer[]                 $counterIds
 * @property          RelevantKeywordsSetting   $relevantKeywords
 * @property          PriorityGoals             $priorityGoals
 * 
 * @method            $this                     setBiddingStrategy(TextCampaignStrategy $biddingStrategy)
 * @method            $this                     setSettings(TextCampaignSettings $settings)
 * @method            $this                     setCounterIds(integer[] $counterIds)
 * @method            $this                     setRelevantKeywords(RelevantKeywordsSetting $relevantKeywords)
 * @method            $this                     setPriorityGoals(PriorityGoals $priorityGoals)
 * 
 * @method            TextCampaignStrategy      getBiddingStrategy()
 * @method            TextCampaignSettings      getSettings()
 * @method            integer[]                 getCounterIds()
 * @method            RelevantKeywordsSetting   getRelevantKeywords()
 * @method            PriorityGoals             getPriorityGoals()
 * 
 * @package YandexDirectSDK\Models 
 */
class TextCampaign extends Model
{
    protected $properties = [
        'biddingStrategy' => 'object:' . TextCampaignStrategy::class,
        'settings' => 'object:' . TextCampaignSettings::class,
        'counterIds' => 'array:integer',
        'relevantKeywords' => 'object:' . RelevantKeywordsSetting::class,
        'priorityGoals' => 'arrayOfObject:' . PriorityGoals::class,
    ];
}