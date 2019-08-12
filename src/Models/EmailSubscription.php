<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\EmailSubscriptions;
use YandexDirectSDK\Components\Model;

/** 
 * Class EmailSubscription 
 * 
 * @property     string     $option
 * @property     string     $value
 *                          
 * @method       $this      setOption(string $option)
 * @method       string     getOption()
 * @method       $this      setValue(string $value)
 * @method       string     getValue()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class EmailSubscription extends Model 
{ 
    const RECEIVE_RECOMMENDATIONS = 'RECEIVE_RECOMMENDATIONS';
    const TRACK_MANAGED_CAMPAIGNS = 'TRACK_MANAGED_CAMPAIGNS';
    const TRACK_POSITION_CHANGES = 'TRACK_POSITION_CHANGES';
    const YES = 'YES';
    const NO = 'NO';

    protected static $compatibleCollection = EmailSubscriptions::class;

    protected static $properties = [
        'option' => 'enum:' . self::RECEIVE_RECOMMENDATIONS . ',' . self::TRACK_MANAGED_CAMPAIGNS . ',' . self::TRACK_POSITION_CHANGES,
        'value' => 'enum:' . self::YES . ',' . self::NO
    ];

    /**
     * Returns the [EmailSubscription] instance
     * with the [RECEIVE_RECOMMENDATIONS] option set.
     *
     * @param bool $switchOn
     * @return static
     */
    public static function receiveRecommendations($switchOn = true){
        return (new static())
            ->setOption(self::RECEIVE_RECOMMENDATIONS)
            ->setValue($switchOn === true ? self::YES : self::NO);
    }

    /**
     * Returns the [EmailSubscription] instance
     * with the [TRACK_MANAGED_CAMPAIGNS] option set.
     *
     * @param bool $switchOn
     * @return static
     */
    public static function trackManagedCampaigns($switchOn = true){
        return (new static())
            ->setOption(self::TRACK_MANAGED_CAMPAIGNS)
            ->setValue($switchOn === true ? self::YES : self::NO);
    }

    /**
     * Returns the [EmailSubscription] instance
     * with the [TRACK_POSITION_CHANGES] option set.
     *
     * @param bool $switchOn
     * @return static
     */
    public static function trackPositionChanges($switchOn = true){
        return (new static())
            ->setOption(self::TRACK_POSITION_CHANGES)
            ->setValue($switchOn === true ? self::YES : self::NO);
    }
}