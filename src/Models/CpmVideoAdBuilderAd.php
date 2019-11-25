<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\TrackingPixels;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Models\Foundation\SetTrackingPixels;

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
    use SetTrackingPixels;

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
}