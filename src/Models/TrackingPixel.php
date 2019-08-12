<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\TrackingPixels;
use YandexDirectSDK\Components\Model;

/** 
 * Class TrackingPixel 
 * 
 * @property          string     $trackingPixel
 * @property-read     string     $provider
 *                               
 * @method            $this      setTrackingPixel(string $trackingPixel)
 * @method            string     getTrackingPixel()
 * @method            string     getProvider()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class TrackingPixel extends Model 
{ 
    protected static $compatibleCollection = TrackingPixels::class;

    protected static $properties = [
        'trackingPixel' => 'string',
        'provider' => 'string'
    ];

    protected static $nonWritableProperties = [
        'provider'
    ];
}