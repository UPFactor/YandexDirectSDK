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
 * @method static     QueryBuilder              query()
 * @method static     Keyword|Keywords|null     find(integer|integer[]|Keyword|Keywords|ModelCommonInterface $ids, string[] $fields)
 * @method            Result                    add()
 * @method            Result                    delete()
 * @method            Result                    resume()
 * @method            Result                    suspend()
 * @method            Result                    update()
 * @method            Result                    setRelatedBids($bid, $contextBid=null)
 * @method            Result                    setRelatedContextBids($contextBid)
 * @method            Result                    setRelatedStrategyPriority(string $strategyPriority)
 * @method            Result                    setRelatedBidsAuto(ModelCommonInterface $bidsAuto)
 * @method            Result                    getRelatedBids(array $fields)
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
    protected static $compatibleModel = Keyword::class;

    protected static $staticMethods = [
        'query' => KeywordsService::class,
        'find' => KeywordsService::class
    ];

    protected static $methods = [
        'add' => KeywordsService::class,
        'delete' => KeywordsService::class,
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