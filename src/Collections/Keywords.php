<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder; 
use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\Keyword;
use YandexDirectSDK\Services\KeywordsService;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;

/** 
 * Class Keywords 
 * 
 * @method   Result         add()
 * @method   Result         delete()
 * @method   QueryBuilder   query()
 * @method   Result         resume()
 * @method   Result         suspend()
 * @method   Result         update()
 * @method   Result         setRelatedBids($bid, $contextBid = null)
 * @method   Result         setRelatedContextBids($contextBid)
 * @method   Result         setRelatedStrategyPriority(string $strategyPriority)
 * @method   Result         setRelatedBidsAuto(ModelCommonInterface $bidsAuto)
 * @method   Result         getRelatedBids(array $fields)
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class Keywords extends ModelCollection 
{ 
    /** 
     * @var Keyword[] 
     */ 
    protected $items = []; 

    /** 
     * @var Keyword[] 
     */ 
    protected $compatibleModel = Keyword::class;

    protected $serviceProvidersMethods = [
        'add' => KeywordsService::class,
        'delete' => KeywordsService::class,
        'query' => KeywordsService::class,
        'resume' => KeywordsService::class,
        'suspend' => KeywordsService::class,
        'update' => KeywordsService::class,
        'setRelatedBids' => KeywordsService::class,
        'setRelatedContextBids' => KeywordsService::class,
        'setRelatedStrategyPriority' => KeywordsService::class,
        'setRelatedBidsAuto' => KeywordsService::class,
        'getRelatedBids' => KeywordsService::class,
    ];
}