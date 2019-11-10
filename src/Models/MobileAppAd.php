<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\MobileAppAdFeatures;
use YandexDirectSDK\Components\Model as Model;
use YandexDirectSDK\Models\Traits\SetAdImage;

/** 
 * Class MobileAppAd 
 * 
 * @property          string                  $title
 * @property          string                  $text
 * @property          string                  $trackingUrl
 * @property          MobileAppAdFeatures     $features
 * @property          string                  $ageLabel
 * @property          string                  $action
 * @property          string                  $adImageHash
 * @property-read     ExtensionModeration     $adImageModeration
 *                                            
 * @method            $this                   setTitle(string $title)
 * @method            string                  getTitle()
 * @method            $this                   setText(string $text)
 * @method            string                  getText()
 * @method            $this                   setTrackingUrl(string $trackingUrl)
 * @method            string                  getTrackingUrl()
 * @method            $this                   setFeatures(MobileAppAdFeatures $features)
 * @method            MobileAppAdFeatures     getFeatures()
 * @method            $this                   setAgeLabel(string $ageLabel)
 * @method            string                  getAgeLabel()
 * @method            $this                   setAction(string $action)
 * @method            string                  getAction()
 * @method            $this                   setAdImageHash(string $adImageHash)
 * @method            string                  getAdImageHash()
 * @method            ExtensionModeration     getAdImageModeration()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class MobileAppAd extends Model 
{
    use SetAdImage;

    const DOWNLOAD = 'DOWNLOAD';
    const GET = 'GET';
    const INSTALL = 'INSTALL';
    const MORE = 'MORE';
    const OPEN = 'OPEN';
    const UPDATE = 'UPDATE';
    const PLAY = 'PLAY';
    const BUY_AUTODETECT = 'BUY_AUTODETECT';

    protected static $properties = [
        'title' => 'string',
        'text' => 'string',
        'trackingUrl' => 'string',
        'features' => 'object:' . MobileAppAdFeatures::class,
        'ageLabel' => 'string',
        'action' => 'enum:' . self::DOWNLOAD.','.self::GET.','.self::INSTALL.','.self::MORE.','.self::OPEN.','.self::UPDATE.','.self::PLAY.','.self::BUY_AUTODETECT,
        'adImageHash' => 'string',
        'adImageModeration' => 'object:' . ExtensionModeration::class
    ];

    protected static $nonWritableProperties = [
        'adImageModeration'
    ];
}