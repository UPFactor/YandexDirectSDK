<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model;
use YandexDirectSDK\Models\Foundation\SetAdImage;

/** 
 * Class TextImageAd 
 * 
 * @property          integer                 $turboPageId
 * @property-read     TurboPageModeration     $turboPageModeration
 * @property          string                  $href
 * @property          string                  $adImageHash
 *                                            
 * @method            $this                   setTurboPageId(integer $turboPageId)
 * @method            integer                 getTurboPageId()
 * @method            TurboPageModeration     getTurboPageModeration()
 * @method            $this                   setHref(string $href)
 * @method            string                  getHref()
 * @method            $this                   setAdImageHash(string $adImageHash)
 * @method            string                  getAdImageHash()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class TextImageAd extends Model 
{
    use SetAdImage;

    protected static $properties = [
        'turboPageId' => 'integer',
        'turboPageModeration' => 'object:' . TurboPageModeration::class,
        'href' => 'string',
        'adImageHash' => 'string'
    ];

    protected static $nonWritableProperties = [
        'turboPageModeration'
    ];
}