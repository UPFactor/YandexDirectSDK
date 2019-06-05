<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class CpcVideoAdBuilderAd 
 * 
 * @property          AdBuilderAd   $creative
 * @property          string        $href
 * 
 * @method            $this         setCreative(AdBuilderAd $creative)
 * @method            $this         setHref(string $href)
 * 
 * @method            AdBuilderAd   getCreative()
 * @method            string        getHref()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class CpcVideoAdBuilderAd extends Model 
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