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
 * @property     string                      $attributionModel
 *                                           
 * @method       $this                       setBiddingStrategy(TextCampaignStrategy|array $biddingStrategy)
 * @method       TextCampaignStrategy        getBiddingStrategy()
 * @method       $this                       setSettings(TextCampaignSettings|array $settings)
 * @method       TextCampaignSettings        getSettings()
 * @method       $this                       setCounterIds(integer[] $counterIds)
 * @method       integer[]                   getCounterIds()
 * @method       $this                       setRelevantKeywords(RelevantKeywordsSetting|array $relevantKeywords)
 * @method       RelevantKeywordsSetting     getRelevantKeywords()
 * @method       $this                       setPriorityGoals(PriorityGoals|array $priorityGoals)
 * @method       PriorityGoals               getPriorityGoals()
 * @method       $this                       setAttributionModel(string $attributionModel)
 * @method       string                      getAttributionModel()
 * 
 * @package YandexDirectSDK\Models 
 */
class TextCampaign extends Model
{
    const FC = 'FC';
    const LC = 'LC';
    const LSC = 'LSC';
    const LYDC = 'LYDC';

    protected static $properties = [
        'biddingStrategy' => 'object:' . TextCampaignStrategy::class,
        'settings' => 'object:' . TextCampaignSettings::class,
        'counterIds' => 'array:integer',
        'relevantKeywords' => 'object:' . RelevantKeywordsSetting::class,
        'priorityGoals' => 'arrayOfObject:' . PriorityGoals::class,
        'attributionModel' => 'enum:'.self::FC.','.self::LC.','.self::LSC.','.self::LYDC
    ];
}