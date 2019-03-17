<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class MobileAppCampaignNetworkStrategy 
 * 
 * @property   string                       $biddingStrategyType 
 * @property   StrategyNetworkDefault       $networkDefault 
 * @property   StrategyMaximumClicks        $wbMaximumClicks 
 * @property   StrategyMaximumAppInstalls   $wbMaximumAppInstalls 
 * @property   StrategyAverageCpc           $averageCpc 
 * @property   StrategyAverageCpi           $averageCpi 
 * @property   StrategyWeeklyClickPackage   $weeklyClickPackage 
 * 
 * @method     $this                        setBiddingStrategyType(string $biddingStrategyType) 
 * @method     $this                        setNetworkDefault(StrategyNetworkDefault $networkDefault) 
 * @method     $this                        setWbMaximumClicks(StrategyMaximumClicks $wbMaximumClicks) 
 * @method     $this                        setWbMaximumAppInstalls(StrategyMaximumAppInstalls $wbMaximumAppInstalls) 
 * @method     $this                        setAverageCpc(StrategyAverageCpc $averageCpc) 
 * @method     $this                        setAverageCpi(StrategyAverageCpi $averageCpi) 
 * @method     $this                        setWeeklyClickPackage(StrategyWeeklyClickPackage $weeklyClickPackage) 
 * 
 * @method     string                       getBiddingStrategyType() 
 * @method     StrategyNetworkDefault       getNetworkDefault() 
 * @method     StrategyMaximumClicks        getWbMaximumClicks() 
 * @method     StrategyMaximumAppInstalls   getWbMaximumAppInstalls() 
 * @method     StrategyAverageCpc           getAverageCpc() 
 * @method     StrategyAverageCpi           getAverageCpi() 
 * @method     StrategyWeeklyClickPackage   getWeeklyClickPackage() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class MobileAppCampaignNetworkStrategy extends Model 
{
    const NETWORK_DEFAULT = 'NETWORK_DEFAULT';
    const MAXIMUM_COVERAGE = 'MAXIMUM_COVERAGE';
    const WB_MAXIMUM_CLICKS = 'WB_MAXIMUM_CLICKS';
    const WB_MAXIMUM_APP_INSTALLS = 'WB_MAXIMUM_APP_INSTALLS';
    const AVERAGE_CPC = 'AVERAGE_CPC';
    const AVERAGE_CPI = 'AVERAGE_CPI';
    const WEEKLY_CLICK_PACKAGE = 'WEEKLY_CLICK_PACKAGE';
    const SERVING_OFF = 'SERVING_OFF';

    protected $properties = [
        'biddingStrategyType' => 'enum:',
        'networkDefault' => 'object:' . StrategyNetworkDefault::class,
        'wbMaximumClicks' => 'object:' . StrategyMaximumClicks::class,
        'wbMaximumAppInstalls' => 'object:' . StrategyMaximumAppInstalls::class,
        'averageCpc' => 'object:' . StrategyAverageCpc::class,
        'averageCpi' => 'object:' . StrategyAverageCpi::class,
        'weeklyClickPackage' => 'object:' . StrategyWeeklyClickPackage::class
    ];

    protected function initialize(...$arguments)
    {
        $this->properties['biddingStrategyType'] = 'enum:' . implode(',',[
                self::NETWORK_DEFAULT,
                self::MAXIMUM_COVERAGE,
                self::WB_MAXIMUM_CLICKS,
                self::WB_MAXIMUM_APP_INSTALLS,
                self::AVERAGE_CPC,
                self::AVERAGE_CPI,
                self::WEEKLY_CLICK_PACKAGE,
                self::SERVING_OFF
            ]);
    }
}