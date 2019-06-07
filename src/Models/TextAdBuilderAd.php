<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class TextAdBuilderAd 
 * 
 * @property            AdBuilderAd           $creative
 * @property            string                $href
 * @property            integer               $turboPageId
 * 
 * @property-readable   TurboPageModeration   $turboPageModeration
 * 
 * @method              $this                 setCreative(AdBuilderAd $creative)
 * @method              $this                 setHref(string $href)
 * @method              $this                 setTurboPageId(integer $turboPageId)
 * 
 * @method              AdBuilderAd           getCreative()
 * @method              string                getHref()
 * @method              integer               getTurboPageId()
 * @method              TurboPageModeration   getTurboPageModeration()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class TextAdBuilderAd extends Model 
{ 
    protected $properties = [
        'creative' => 'object:' . AdBuilderAd::class,
        'href' => 'string',
        'turboPageId' => 'integer',
        'turboPageModeration' => 'object:' . TurboPageModeration::class
    ];

    protected $nonWritableProperties = [
        'turboPageModeration'
    ];
}