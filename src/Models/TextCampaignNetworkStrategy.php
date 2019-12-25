<?php

namespace YandexDirectSDK\Models;

use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Components\ModelProperty;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;

/** 
 * Class TextCampaignNetworkStrategy 
 * 
 * @property     string                                 $biddingStrategyType
 * @property     StrategyNetworkDefault|null|object     $networkDefault
 * @property     StrategyMaximumClicks                  $wbMaximumClicks
 * @property     StrategyMaximumConversionRate          $wbMaximumConversionRate
 * @property     StrategyAverageCpc                     $averageCpc
 * @property     StrategyAverageCpa                     $averageCpa
 * @property     StrategyAverageRoi                     $averageRoi
 * @property     StrategyWeeklyClickPackage             $weeklyClickPackage
 *                                                      
 * @method       $this                                  setBiddingStrategyType(string $biddingStrategyType)
 * @method       string                                 getBiddingStrategyType()
 * @method       StrategyNetworkDefault|null|object     getNetworkDefault()
 * @method       $this                                  setWbMaximumClicks(StrategyMaximumClicks|array $wbMaximumClicks)
 * @method       StrategyMaximumClicks                  getWbMaximumClicks()
 * @method       $this                                  setWbMaximumConversionRate(StrategyMaximumConversionRate|array $wbMaximumConversionRate)
 * @method       StrategyMaximumConversionRate          getWbMaximumConversionRate()
 * @method       $this                                  setAverageCpc(StrategyAverageCpc|array $averageCpc)
 * @method       StrategyAverageCpc                     getAverageCpc()
 * @method       $this                                  setAverageCpa(StrategyAverageCpa|array $averageCpa)
 * @method       StrategyAverageCpa                     getAverageCpa()
 * @method       $this                                  setAverageRoi(StrategyAverageRoi|array $averageRoi)
 * @method       StrategyAverageRoi                     getAverageRoi()
 * @method       $this                                  setWeeklyClickPackage(StrategyWeeklyClickPackage|array $weeklyClickPackage)
 * @method       StrategyWeeklyClickPackage             getWeeklyClickPackage()
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
        'networkDefault' => 'custom:' . StrategyNetworkDefault::class . ',null,object',
        'wbMaximumClicks' => 'object:' . StrategyMaximumClicks::class,
        'wbMaximumConversionRate' => 'object:' . StrategyMaximumConversionRate::class,
        'averageCpc' => 'object:' . StrategyAverageCpc::class,
        'averageCpa' => 'object:' . StrategyAverageCpa::class,
        'averageRoi' => 'object:' . StrategyAverageRoi::class,
        'weeklyClickPackage' => 'object:' . StrategyWeeklyClickPackage::class
    ];

    public function setNetworkDefault(StrategyNetworkDefault $networkDefault = null)
    {
        if (is_null($networkDefault)){
            $this->data['networkDefault'] = (object) [];
        } else {
            $this->data['networkDefault'] = $networkDefault;
        }

        return $this;
    }

    public function importNetworkDefault($sourceValue, $currentValue, ModelProperty $property)
    {
        if (is_null($sourceValue)){
            return $sourceValue;
        }

        if (is_array($sourceValue) and !empty($sourceValue)){
            /** @var ModelCommonInterface $permissibleValue */
            $permissibleValue = $property->permissibleValues[0];
            if (isset($currentValue) and $currentValue instanceof $permissibleValue){
                $currentValue->insert($sourceValue);
            } else {
                $permissibleValue = new $permissibleValue();
                $currentValue = $permissibleValue->insert($sourceValue);
            }
            return $currentValue;
        }

        if ((is_array($sourceValue) and empty($sourceValue)) or is_object($sourceValue)){
            return (object) [];
        }

        return null;
    }

    public function exportNetworkDefault($value)
    {
        return $value;
    }
}