<?php 
namespace YandexDirectSDK\Collections; 

use UPTools\Arr;
use YandexDirectSDK\Collections\Foundation\On;
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
 * @method static     Keyword|Keywords|null     find(integer|integer[]|string|string[] $ids, string[] $fields=null)
 * @method            Result                    add()
 * @method            Result                    delete()
 * @method            Result                    resume()
 * @method            Result                    suspend()
 * @method            Result                    update()
 * @method            Result                    setRelatedBids($bid, $contextBid=null)
 * @method            Result                    setRelatedContextBids($contextBid)
 * @method            Result                    setRelatedStrategyPriority(string $strategyPriority)
 * @method            Result                    setRelatedBidsAuto(ModelCommonInterface $bidsAuto)
 * @method            Bids                      getRelatedBids(array $fields=[])
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class Keywords extends ModelCollection 
{ 
    use On;

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

    /**
     * @param array $keywords
     * @return Keywords
     */
    public static function makeByList(array $keywords)
    {
        return static::make()->insert(Arr::map($keywords, function(string $keyword){
            return [
                'Keyword' => $keyword
            ];
        }));
    }
}