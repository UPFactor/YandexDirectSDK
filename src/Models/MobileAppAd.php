<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\MobileAppAdFeatures;
use YandexDirectSDK\Components\Model as Model;

/** 
 * Class MobileAppAd 
 * 
 * @property            string[]              $title 
 * @property            string                $text 
 * @property            string                $trackingUrl 
 * @property            MobileAppAdFeatures   $features 
 * @property            string                $ageLabel 
 * @property            string                $action 
 * @property            string                $adImageHash 
 * @property-readable   ExtensionModeration   $adImageModeration 
 * 
 * @method              $this                 setTitle(string[] $title) 
 * @method              $this                 setText(string $text) 
 * @method              $this                 setTrackingUrl(string $trackingUrl) 
 * @method              $this                 setFeatures(MobileAppAdFeatures $features) 
 * @method              $this                 setAgeLabel(string $ageLabel) 
 * @method              $this                 setAction(string $action) 
 * @method              $this                 setAdImageHash(string $adImageHash) 
 * 
 * @method              string[]              getTitle() 
 * @method              string                getText() 
 * @method              string                getTrackingUrl() 
 * @method              MobileAppAdFeatures   getFeatures() 
 * @method              string                getAgeLabel() 
 * @method              string                getAction() 
 * @method              string                getAdImageHash() 
 * @method              ExtensionModeration   getAdImageModeration() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class MobileAppAd extends Model 
{ 
    const DOWNLOAD = 'DOWNLOAD';
    const GET = 'GET';
    const INSTALL = 'INSTALL';
    const MORE = 'MORE';
    const OPEN = 'OPEN';
    const UPDATE = 'UPDATE';
    const PLAY = 'PLAY';
    const BUY_AUTODETECT = 'BUY_AUTODETECT';

    protected $properties = [
        'title' => 'stack:string',
        'text' => 'string',
        'trackingUrl' => 'string',
        'features' => 'object:' . MobileAppAdFeatures::class,
        'ageLabel' => 'string',
        'action' => 'enum:' . self::DOWNLOAD.','.self::GET.','.self::INSTALL.','.self::MORE.','.self::OPEN.','.self::UPDATE.','.self::PLAY.','.self::BUY_AUTODETECT,
        'adImageHash' => 'string',
        'adImageModeration' => 'object:' . ExtensionModeration::class
    ];

    protected $nonWritableProperties = [
        'adImageModeration'
    ];
}