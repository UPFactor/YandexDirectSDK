<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder; 
use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\AudienceTarget;
use YandexDirectSDK\Services\AudienceTargetsService;

/** 
 * Class AudienceTargets 
 * 
 * @method   Result         add()
 * @method   Result         delete()
 * @method   QueryBuilder   query()
 * @method   Result         resume()
 * @method   Result         suspend()
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class AudienceTargets extends ModelCollection 
{ 
    /** 
     * @var AudienceTarget[] 
     */ 
    protected $items = []; 

    /** 
     * @var AudienceTarget 
     */ 
    protected $compatibleModel = AudienceTarget::class;

    protected $serviceProvidersMethods = [
        'add' => AudienceTargetsService::class,
        'delete' => AudienceTargetsService::class,
        'query' => AudienceTargetsService::class,
        'resume' => AudienceTargetsService::class,
        'suspend' => AudienceTargetsService::class
    ];
}