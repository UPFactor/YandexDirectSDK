<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\KeywordBidsAuto;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Services\KeywordBidsService;

/** 
 * Class KeywordBidAuto 
 * 
 * @property          integer       $campaignId
 * @property          integer       $adGroupId
 * @property          integer       $keywordId
 * @property          BiddingRule   $biddingRule
 * 
 * @method            Result        setAuto()
 * 
 * @method            $this         setCampaignId(integer $campaignId)
 * @method            $this         setAdGroupId(integer $adGroupId)
 * @method            $this         setKeywordId(integer $keywordId)
 * @method            $this         setBiddingRule(BiddingRule $biddingRule)
 * 
 * @method            integer       getCampaignId()
 * @method            integer       getAdGroupId()
 * @method            integer       getKeywordId()
 * @method            BiddingRule   getBiddingRule()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class KeywordBidAuto extends Model 
{ 
    protected static $compatibleCollection = KeywordBidsAuto::class;

    protected static $serviceMethods = [
        'setAuto' => KeywordBidsService::class
    ];

    protected static $properties = [
        'campaignId' => 'integer',
        'adGroupId' => 'integer',
        'keywordId' => 'integer',
        'biddingRule' => 'object:' . BiddingRule::class
    ];
}