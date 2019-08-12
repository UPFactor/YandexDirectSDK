<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\TrackingPixels;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Components\ModelProperty;
use YandexDirectSDK\Exceptions\InvalidArgumentException;

/** 
 * Class CpmVideoAdBuilderAd 
 * 
 * @property          AdBuilderAd             $creative
 * @property          string                  $href
 * @property          integer                 $turboPageId
 * @property-read     TurboPageModeration     $turboPageModeration
 * @property          TrackingPixels          $trackingPixels
 *                                            
 * @method            $this                   setCreative(AdBuilderAd $creative)
 * @method            AdBuilderAd             getCreative()
 * @method            $this                   setHref(string $href)
 * @method            string                  getHref()
 * @method            $this                   setTurboPageId(integer $turboPageId)
 * @method            integer                 getTurboPageId()
 * @method            TurboPageModeration     getTurboPageModeration()
 * @method            $this                   setTrackingPixels(TrackingPixels $trackingPixels)
 * @method            TrackingPixels          getTrackingPixels()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class CpmVideoAdBuilderAd extends Model 
{ 
    protected static $properties = [
        'creative' => 'object:' . AdBuilderAd::class,
        'href' => 'string',
        'turboPageId' => 'integer',
        'turboPageModeration' => 'object:' . TurboPageModeration::class,
        'trackingPixels' => 'arrayOfCustom:' . TrackingPixels::class
    ];

    protected static $nonWritableProperties = [
        'turboPageModeration'
    ];

    /*
    |--------------------------------------------------------------------------
    | Handlers for property [trackingPixel]
    |--------------------------------------------------------------------------
    */

    /**
     * Setter.
     *
     * @param $sourceValue
     * @param ModelProperty $property
     * @return TrackingPixels
     */
    protected function setterTrackingPixels($sourceValue, ModelProperty $property)
    {
        if (!($sourceValue instanceof TrackingPixels)){
            throw InvalidArgumentException::modelPropertyValue(
                static::class,
                $property->name,
                'object',
                $property->permissibleValues,
                $sourceValue
            );
        }

        return $sourceValue;
    }

    /**
     * Import handler.
     *
     * @param $sourceValue
     * @param $currentValue
     * @return TrackingPixels|null
     */
    protected function importTrackingPixels($sourceValue, $currentValue)
    {
        if (is_null($sourceValue)){
            return null;
        }

        if (!is_array($sourceValue)){
            $sourceValue = [['TrackingPixel' => $sourceValue]];
        } else {
            foreach ($sourceValue as $index => $item){
                $sourceValue[$index] = is_array($item) ? $item : ['TrackingPixel' => $item];
            }
        }

        if (!is_null($currentValue) and $currentValue instanceof TrackingPixels){
            return $currentValue->insert($sourceValue);
        }

        return (new TrackingPixels())->insert($sourceValue);
    }

    /**
     * Export handler.
     *
     * @param $currentValue
     * @param $currentFilter
     * @return array|null
     */
    protected function exportTrackingPixels($currentValue, $currentFilter)
    {
        if (is_null($currentValue) or !($currentValue instanceof TrackingPixels)){
            return null;
        }

        if ($currentFilter & self::IS_ADDABLE or $currentFilter & self::IS_UPDATABLE){
            return $currentValue->extract('trackingPixel');
        }

        return $currentValue;
    }
}