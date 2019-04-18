<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder; 
use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\Keyword;
use YandexDirectSDK\Services\KeywordsService;
use YandexDirectSDK\Interfaces\ModelCommon;

/** 
 * Class Keywords 
 * 
 * @method   Result         add() 
 * @method   Result         delete() 
 * @method   QueryBuilder   query() 
 * @method   Result         resume() 
 * @method   Result         suspend() 
 * @method   Result         update() 
 * @method   Result         setRelatedBids(ModelCommon $bids) 
 * @method   Result         setRelatedBidsAuto(ModelCommon $bidsAuto) 
 * @method   Result         getRelatedBids(array $fields) 
 * @method   Result         setRelatedKeywordBids(ModelCommon $keywordBids) 
 * @method   Result         setRelatedKeywordBidsAuto(ModelCommon $keywordsBidsAuto) 
 * @method   Result         getRelatedKeywordBids(array $fields) 
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
        'setRelatedBidsAuto' => KeywordsService::class,
        'getRelatedBids' => KeywordsService::class,
        'setRelatedKeywordBids' => KeywordsService::class,
        'setRelatedKeywordBidsAuto' => KeywordsService::class,
        'getRelatedKeywordBids' => KeywordsService::class
    ];
}