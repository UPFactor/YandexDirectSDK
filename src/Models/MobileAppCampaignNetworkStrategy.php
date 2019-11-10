<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model;
use YandexDirectSDK\Components\ModelProperty;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;

/** 
 * Class MobileAppCampaignNetworkStrategy 
 * 
 * @property     string                                 $biddingStrategyType
 * @property     StrategyNetworkDefault|null|object     $networkDefault
 * @property     StrategyMaximumClicks                  $wbMaximumClicks
 * @property     StrategyMaximumAppInstalls             $wbMaximumAppInstalls
 * @property     StrategyAverageCpc                     $averageCpc
 * @property     StrategyAverageCpi                     $averageCpi
 * @property     StrategyWeeklyClickPackage             $weeklyClickPackage
 *                                                      
 * @method       $this                                  setBiddingStrategyType(string $biddingStrategyType)
 * @method       string                                 getBiddingStrategyType()
 * @method       StrategyNetworkDefault|null|object     getNetworkDefault()
 * @method       $this                                  setWbMaximumClicks(StrategyMaximumClicks $wbMaximumClicks)
 * @method       StrategyMaximumClicks                  getWbMaximumClicks()
 * @method       $this                                  setWbMaximumAppInstalls(StrategyMaximumAppInstalls $wbMaximumAppInstalls)
 * @method       StrategyMaximumAppInstalls             getWbMaximumAppInstalls()
 * @method       $this                                  setAverageCpc(StrategyAverageCpc $averageCpc)
 * @method       StrategyAverageCpc                     getAverageCpc()
 * @method       $this                                  setAverageCpi(StrategyAverageCpi $averageCpi)
 * @method       StrategyAverageCpi                     getAverageCpi()
 * @method       $this                                  setWeeklyClickPackage(StrategyWeeklyClickPackage $weeklyClickPackage)
 * @method       StrategyWeeklyClickPackage             getWeeklyClickPackage()
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

    protected static $properties = [
        'biddingStrategyType' => 'enum:'
            .self::NETWORK_DEFAULT.','
            .self::MAXIMUM_COVERAGE.','
            .self::WB_MAXIMUM_CLICKS.','
            .self::WB_MAXIMUM_APP_INSTALLS.','
            .self::AVERAGE_CPC.','
            .self::AVERAGE_CPI.','
            .self::WEEKLY_CLICK_PACKAGE.','
            .self::SERVING_OFF,
        'networkDefault' => 'custom:' . StrategyNetworkDefault::class . ',null,object',
        'wbMaximumClicks' => 'object:' . StrategyMaximumClicks::class,
        'wbMaximumAppInstalls' => 'object:' . StrategyMaximumAppInstalls::class,
        'averageCpc' => 'object:' . StrategyAverageCpc::class,
        'averageCpi' => 'object:' . StrategyAverageCpi::class,
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