<?php

namespace YandexDirectSDK\Models;

use YandexDirectSDK\Components\Model;

/** 
 * Class TextCampaignNetworkStrategy 
 * 
 * @property       string                          $biddingStrategyType
 * @property       StrategyNetworkDefault          $networkDefault
 * @property       StrategyMaximumClicks           $wbMaximumClicks
 * @property       StrategyMaximumConversionRate   $wbMaximumConversionRate
 * @property       StrategyAverageCpc              $averageCpc
 * @property       StrategyAverageCpa              $averageCpa
 * @property       StrategyAverageRoi              $averageRoi
 * @property       StrategyWeeklyClickPackage      $weeklyClickPackage
 * 
 * @method         $this                           setBiddingStrategyType(string $biddingStrategyType)
 * @method         $this                           setNetworkDefault(StrategyNetworkDefault $networkDefault)
 * @method         $this                           setWbMaximumClicks(StrategyMaximumClicks $wbMaximumClicks)
 * @method         $this                           setWbMaximumConversionRate(StrategyMaximumConversionRate $wbMaximumConversionRate)
 * @method         $this                           setAverageCpc(StrategyAverageCpc $averageCpc)
 * @method         $this                           setAverageCpa(StrategyAverageCpa $averageCpa)
 * @method         $this                           setAverageRoi(StrategyAverageRoi $averageRoi)
 * @method         $this                           setWeeklyClickPackage(StrategyWeeklyClickPackage $weeklyClickPackage)
 * 
 * @method         string                          getBiddingStrategyType()
 * @method         StrategyNetworkDefault          getNetworkDefault()
 * @method         StrategyMaximumClicks           getWbMaximumClicks()
 * @method         StrategyMaximumConversionRate   getWbMaximumConversionRate()
 * @method         StrategyAverageCpc              getAverageCpc()
 * @method         StrategyAverageCpa              getAverageCpa()
 * @method         StrategyAverageRoi              getAverageRoi()
 * @method         StrategyWeeklyClickPackage      getWeeklyClickPackage()
 * 
 * @package YandexDirectSDK\Models 
 */
class TextCampaignNetworkStrategy extends Model
{
    const NETWORK_DEFAULT = 'NETWORK_DEFAULT';
    const MAXIMUM_COVERAGE = 'MAXIMUM_COVERAGE';
    const WB_MAXIMUM_CLICKS = 'WB_MAXIMUM_CLICKS';
    const WB_MAXIMUM_CONVERSION_RATE = 'WB_MAXIMUM_CONVERSION_RATE';
    const AVERAGE_CPC = 'AVERAGE_CPC';
    const AVERAGE_CPA = 'AVERAGE_CPA';
    const AVERAGE_ROI = 'AVERAGE_ROI';
    const WEEKLY_CLICK_PACKAGE = 'WEEKLY_CLICK_PACKAGE';
    const SERVING_OFF = 'SERVING_OFF';

    protected static $properties = [
        'biddingStrategyType' => 'enum:' . self::NETWORK_DEFAULT . ',' . self::MAXIMUM_COVERAGE . ',' . self::WB_MAXIMUM_CLICKS . ',' . self::WB_MAXIMUM_CONVERSION_RATE . ',' . self::AVERAGE_CPC . ',' . self::AVERAGE_CPA . ',' . self::AVERAGE_ROI . ',' . self::WEEKLY_CLICK_PACKAGE . ',' . self::SERVING_OFF,
        'networkDefault' => 'object:' . StrategyNetworkDefault::class,
        'wbMaximumClicks' => 'object:' . StrategyMaximumClicks::class,
        'wbMaximumConversionRate' => 'object:' . StrategyMaximumConversionRate::class,
        'averageCpc' => 'object:' . StrategyAverageCpc::class,
        'averageCpa' => 'object:' . StrategyAverageCpa::class,
        'averageRoi' => 'object:' . StrategyAverageRoi::class,
        'weeklyClickPackage' => 'object:' . StrategyWeeklyClickPackage::class
    ];
}