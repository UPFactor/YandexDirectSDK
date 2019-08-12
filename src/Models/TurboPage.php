<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\TurboPages;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Services\TurboPagesService;

/** 
 * Class TurboPage 
 * 
 * @property-read     integer                       $id
 * @property-read     string                        $name
 * @property-read     string                        $href
 * @property-read     string                        $previewHref
 *                                                  
 * @method static     QueryBuilder                  query()
 * @method static     TurboPage|TurboPages|null     find(integer|integer[]|TurboPage|TurboPages|ModelCommonInterface $ids, string[] $fields)
 * @method            integer                       getId()
 * @method            string                        getName()
 * @method            string                        getHref()
 * @method            string                        getPreviewHref()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class TurboPage extends Model 
{ 
    protected static $compatibleCollection = TurboPages::class;

    protected static $staticMethods = [
        'query' => TurboPagesService::class,
        'find' => TurboPagesService::class
    ];

    protected static $properties = [
        'id' => 'integer',
        'name' => 'string',
        'href' => 'string',
        'previewHref' => 'string'
    ];

    protected static $nonWritableProperties = [
        'id',
        'name',
        'href',
        'previewHref'
    ];

    protected static $nonReadableProperties = [];
}