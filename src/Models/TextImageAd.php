<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class TextImageAd 
 * 
 * @property            integer               $turboPageId
 * @property            string                $href
 * @property            string                $adImageHash
 * 
 * @property-readable   TurboPageModeration   $turboPageModeration
 * 
 * @method              $this                 setTurboPageId(integer $turboPageId)
 * @method              $this                 setHref(string $href)
 * @method              $this                 setAdImageHash(string $adImageHash)
 * 
 * @method              integer               getTurboPageId()
 * @method              TurboPageModeration   getTurboPageModeration()
 * @method              string                getHref()
 * @method              string                getAdImageHash()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class TextImageAd extends Model 
{ 
    protected $properties = [
        'turboPageId' => 'integer',
        'turboPageModeration' => 'object:' . TurboPageModeration::class,
        'href' => 'string',
        'adImageHash' => 'string'
    ];

    protected $nonWritableProperties = [
        'turboPageModeration'
    ];
}