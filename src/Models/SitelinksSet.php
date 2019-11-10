<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\Sitelinks;
use YandexDirectSDK\Collections\SitelinksSets;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Services\SitelinksService;

/** 
 * Class SitelinksSet 
 * 
 * @property          integer                             $id
 * @property          Sitelinks                           $sitelinks
 *                                                        
 * @method static     QueryBuilder                        query()
 * @method static     SitelinksSet|SitelinksSets|null     find(integer|integer[]|string|string[] $ids, string[] $fields=null)
 * @method            Result                              add()
 * @method            Result                              delete()
 * @method            $this                               setId(integer $id)
 * @method            integer                             getId()
 * @method            $this                               setSitelinks(Sitelinks $sitelinks)
 * @method            Sitelinks                           getSitelinks()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class SitelinksSet extends Model 
{ 
    protected static $compatibleCollection = SitelinksSets::class;

    protected static $staticMethods = [
        'query' => SitelinksService::class,
        'find' => SitelinksService::class
    ];

    protected static $methods = [
        'add' => SitelinksService::class,
        'delete' => SitelinksService::class
    ];

    protected static $properties = [
        'id' => 'integer',
        'sitelinks' => 'object:' . Sitelinks::class
    ];

    protected static $nonAddableProperties = [
        'id'
    ];
}