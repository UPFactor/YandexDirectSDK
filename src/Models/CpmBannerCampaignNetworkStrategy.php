<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class CpmBannerCampaignNetworkStrategy 
 * 
 * @property     string                                             $biddingStrategyType
 * @property     StrategyWbMaximumImpressions                       $wbMaximumImpressions
 * @property     StrategyCpMaximumImpressions                       $cpMaximumImpressions
 * @property     StrategyWbDecreasedPriceForRepeatedImpressions     $wbDecreasedPriceForRepeatedImpressions
 * @property     StrategyCpDecreasedPriceForRepeatedImpressions     $cpDecreasedPriceForRepeatedImpressions
 *                                                                  
 * @method       $this                                              setBiddingStrategyType(string $biddingStrategyType)
 * @method       string                                             getBiddingStrategyType()
 * @method       $this                                              setWbMaximumImpressions(StrategyWbMaximumImpressions $wbMaximumImpressions)
 * @method       StrategyWbMaximumImpressions                       getWbMaximumImpressions()
 * @method       $this                                              setCpMaximumImpressions(StrategyCpMaximumImpressions $cpMaximumImpressions)
 * @method       StrategyCpMaximumImpressions                       getCpMaximumImpressions()
 * @method       $this                                              setWbDecreasedPriceForRepeatedImpressions(StrategyWbDecreasedPriceForRepeatedImpressions $wbDecreasedPriceForRepeatedImpressions)
 * @method       StrategyWbDecreasedPriceForRepeatedImpressions     getWbDecreasedPriceForRepeatedImpressions()
 * @method       $this                                              setCpDecreasedPriceForRepeatedImpressions(StrategyCpDecreasedPriceForRepeatedImpressions $cpDecreasedPriceForRepeatedImpressions)
 * @method       StrategyCpDecreasedPriceForRepeatedImpressions     getCpDecreasedPriceForRepeatedImpressions()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class CpmBannerCampaignNetworkStrategy extends Model 
{
    const MANUAL_CPM = 'MANUAL_CPM';
    const CP_DECREASED_PRICE_FOR_REPEATED_IMPRESSIONS = 'CP_DECREASED_PRICE_FOR_REPEATED_IMPRESSIONS';
    const WB_DECREASED_PRICE_FOR_REPEATED_IMPRESSIONS = 'WB_DECREASED_PRICE_FOR_REPEATED_IMPRESSIONS';
    const CP_MAXIMUM_IMPRESSIONS = 'CP_MAXIMUM_IMPRESSIONS';
    const WB_MAXIMUM_IMPRESSIONS = 'WB_MAXIMUM_IMPRESSIONS';

    protected static $properties = [
        'biddingStrategyType' => 'enum:' . self::MANUAL_CPM . ',' . self::CP_DECREASED_PRICE_FOR_REPEATED_IMPRESSIONS . ',' . self::WB_DECREASED_PRICE_FOR_REPEATED_IMPRESSIONS . ',' . self::CP_MAXIMUM_IMPRESSIONS . ',' . self::WB_MAXIMUM_IMPRESSIONS,
        'wbMaximumImpressions' => 'object:' . StrategyWbMaximumImpressions::class,
        'cpMaximumImpressions' => 'object:' . StrategyCpMaximumImpressions::class,
        'wbDecreasedPriceForRepeatedImpressions' => 'object:' . StrategyWbDecreasedPriceForRepeatedImpressions::class,
        'cpDecreasedPriceForRepeatedImpressions' => 'object:' . StrategyCpDecreasedPriceForRepeatedImpressions::class
    ];
}