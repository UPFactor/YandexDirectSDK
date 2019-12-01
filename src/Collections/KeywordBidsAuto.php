<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\KeywordBidAuto;
use YandexDirectSDK\Services\KeywordBidsService;

/** 
 * Class KeywordBidsAuto 
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class KeywordBidsAuto extends ModelCollection
{
    /**
     * @var KeywordBidAuto[]
     */
    protected $items = [];

    /**
     * @var KeywordBidAuto
     */
    protected static $compatibleModel = KeywordBidAuto::class;

    public function apply(): Result
    {
        return KeywordBidsService::setAuto($this);
    }
}