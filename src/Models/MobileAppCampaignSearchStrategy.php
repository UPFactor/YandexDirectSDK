<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class MobileAppCampaignSearchStrategy 
 * 
 * @property     string                         $biddingStrategyType
 * @property     StrategyMaximumClicks          $wbMaximumClicks
 * @property     StrategyMaximumAppInstalls     $wbMaximumAppInstalls
 * @property     StrategyAverageCpc             $averageCpc
 * @property     StrategyAverageCpi             $averageCpi
 * @property     StrategyWeeklyClickPackage     $weeklyClickPackage
 *                                              
 * @method       $this                          setBiddingStrategyType(string $biddingStrategyType)
 * @method       string                         getBiddingStrategyType()
 * @method       $this                          setWbMaximumClicks(StrategyMaximumClicks|array $wbMaximumClicks)
 * @method       StrategyMaximumClicks          getWbMaximumClicks()
 * @method       $this                          setWbMaximumAppInstalls(StrategyMaximumAppInstalls|array $wbMaximumAppInstalls)
 * @method       StrategyMaximumAppInstalls     getWbMaximumAppInstalls()
 * @method       $this                          setAverageCpc(StrategyAverageCpc|array $averageCpc)
 * @method       StrategyAverageCpc             getAverageCpc()
 * @method       $this                          setAverageCpi(StrategyAverageCpi|array $averageCpi)
 * @method       StrategyAverageCpi             getAverageCpi()
 * @method       $this                          setWeeklyClickPackage(StrategyWeeklyClickPackage|array $weeklyClickPackage)
 * @method       StrategyWeeklyClickPackage     getWeeklyClickPackage()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class MobileAppCampaignSearchStrategy extends Model 
{
    const HIGHEST_POSITION = 'HIGHEST_POSITION';
    const WB_MAXIMUM_CLICKS = 'WB_MAXIMUM_CLICKS';
    const WB_MAXIMUM_APP_INSTALLS = 'WB_MAXIMUM_APP_INSTALLS';
    const AVERAGE_CPC = 'AVERAGE_CPC';
    const AVERAGE_CPI = 'AVERAGE_CPI';
    const WEEKLY_CLICK_PACKAGE = 'WEEKLY_CLICK_PACKAGE';
    const SERVING_OFF = 'SERVING_OFF';

    protected static $properties = [
        'biddingStrategyType' => 'enum:'
            .self::HIGHEST_POSITION.','
            .self::WB_MAXIMUM_CLICKS.','
            .self::WB_MAXIMUM_APP_INSTALLS.','
            .self::AVERAGE_CPC.','
            .self::AVERAGE_CPI.','
            .self::WEEKLY_CLICK_PACKAGE.','
            .self::SERVING_OFF,
        'wbMaximumClicks' => 'object:' . StrategyMaximumClicks::class,
        'wbMaximumAppInstalls' => 'object:' . StrategyMaximumAppInstalls::class,
        'averageCpc' => 'object:' . StrategyAverageCpc::class,
        'averageCpi' => 'object:' . StrategyAverageCpi::class,
        'weeklyClickPackage' => 'object:' . StrategyWeeklyClickPackage::class
    ];
}