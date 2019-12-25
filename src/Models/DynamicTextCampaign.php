<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\DynamicTextCampaignSettings;
use YandexDirectSDK\Collections\PriorityGoals;
use YandexDirectSDK\Components\Model as Model;

/** 
 * Class DynamicTextCampaign 
 * 
 * @property     DynamicTextCampaignStrategy     $biddingStrategy
 * @property     DynamicTextCampaignSettings     $settings
 * @property     integer[]                       $counterIds
 * @property     PriorityGoals                   $priorityGoals
 * @property     string                          $attributionModel
 *                                               
 * @method       $this                           setBiddingStrategy(DynamicTextCampaignStrategy|array $biddingStrategy)
 * @method       DynamicTextCampaignStrategy     getBiddingStrategy()
 * @method       $this                           setSettings(DynamicTextCampaignSettings|array $settings)
 * @method       DynamicTextCampaignSettings     getSettings()
 * @method       $this                           setCounterIds(integer[] $counterIds)
 * @method       integer[]                       getCounterIds()
 * @method       $this                           setPriorityGoals(PriorityGoals|array $priorityGoals)
 * @method       PriorityGoals                   getPriorityGoals()
 * @method       $this                           setAttributionModel(string $attributionModel)
 * @method       string                          getAttributionModel()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class DynamicTextCampaign extends Model 
{
    const FC = 'FC';
    const LC = 'LC';
    const LSC = 'LSC';
    const LYDC = 'LYDC';

    protected static $properties = [
        'biddingStrategy' => 'object:' . DynamicTextCampaignStrategy::class,
        'settings' => 'object:' . DynamicTextCampaignSettings::class,
        'counterIds' => 'array:integer',
        'priorityGoals' => 'arrayOfObject:' . PriorityGoals::class,
        'attributionModel' => 'enum:'.self::FC.','.self::LC.','.self::LSC.','.self::LYDC
    ];
}