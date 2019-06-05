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
 * @property          integer        $id
 * @property          Sitelinks      $sitelinks
 * 
 * @method            Result         add()
 * @method            Result         delete()
 * @method            QueryBuilder   query()
 * 
 * @method            $this          setId(integer $id)
 * @method            $this          setSitelinks(Sitelinks $sitelinks)
 * 
 * @method            integer        getId()
 * @method            Sitelinks      getSitelinks()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class SitelinksSet extends Model 
{ 
    protected $compatibleCollection = SitelinksSets::class;

    protected $serviceProvidersMethods = [
        'add' => SitelinksService::class,
        'delete' => SitelinksService::class,
        'query' => SitelinksService::class
    ];

    protected $properties = [
        'id' => 'integer',
        'sitelinks' => 'object:' . Sitelinks::class
    ];

    protected $nonAddableProperties = [
        'id'
    ];
}