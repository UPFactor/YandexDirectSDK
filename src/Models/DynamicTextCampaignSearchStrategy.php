<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class DynamicTextCampaignSearchStrategy 
 * 
 * @property     string                            $biddingStrategyType
 * @property     StrategyMaximumClicks             $wbMaximumClicks
 * @property     StrategyMaximumConversionRate     $wbMaximumConversionRate
 * @property     StrategyAverageCpc                $averageCpc
 * @property     StrategyAverageCpa                $averageCpa
 * @property     StrategyAverageRoi                $averageRoi
 * @property     StrategyWeeklyClickPackage        $weeklyClickPackage
 *                                                 
 * @method       $this                             setBiddingStrategyType(string $biddingStrategyType)
 * @method       string                            getBiddingStrategyType()
 * @method       $this                             setWbMaximumClicks(StrategyMaximumClicks $wbMaximumClicks)
 * @method       StrategyMaximumClicks             getWbMaximumClicks()
 * @method       $this                             setWbMaximumConversionRate(StrategyMaximumConversionRate $wbMaximumConversionRate)
 * @method       StrategyMaximumConversionRate     getWbMaximumConversionRate()
 * @method       $this                             setAverageCpc(StrategyAverageCpc $averageCpc)
 * @method       StrategyAverageCpc                getAverageCpc()
 * @method       $this                             setAverageCpa(StrategyAverageCpa $averageCpa)
 * @method       StrategyAverageCpa                getAverageCpa()
 * @method       $this                             setAverageRoi(StrategyAverageRoi $averageRoi)
 * @method       StrategyAverageRoi                getAverageRoi()
 * @method       $this                             setWeeklyClickPackage(StrategyWeeklyClickPackage $weeklyClickPackage)
 * @method       StrategyWeeklyClickPackage        getWeeklyClickPackage()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class DynamicTextCampaignSearchStrategy extends Model 
{ 
    const HIGHEST_POSITION = 'HIGHEST_POSITION';
    const WB_MAXIMUM_CLICKS = 'WB_MAXIMUM_CLICKS';
    const WB_MAXIMUM_CONVERSION_RATE = 'WB_MAXIMUM_CONVERSION_RATE';
    const AVERAGE_CPC = 'AVERAGE_CPC';
    const AVERAGE_CPA = 'AVERAGE_CPA';
    const AVERAGE_ROI = 'AVERAGE_ROI';
    const WEEKLY_CLICK_PACKAGE = 'WEEKLY_CLICK_PACKAGE';

    protected static $properties = [
        'biddingStrategyType' => 'enum:'.self::HIGHEST_POSITION.','.self::WB_MAXIMUM_CLICKS.','.self::WB_MAXIMUM_CONVERSION_RATE.','.self::AVERAGE_CPC.','.self::AVERAGE_CPA.','.self::AVERAGE_ROI.','.self::WEEKLY_CLICK_PACKAGE,
        'wbMaximumClicks' => 'object:' . StrategyMaximumClicks::class,
        'wbMaximumConversionRate' => 'object:' . StrategyMaximumConversionRate::class,
        'averageCpc' => 'object:' . StrategyAverageCpc::class,
        'averageCpa' => 'object:' . StrategyAverageCpa::class,
        'averageRoi' => 'object:' . StrategyAverageRoi::class,
        'weeklyClickPackage' => 'object:' . StrategyWeeklyClickPackage::class
    ];
}