<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\KeywordBidsAuto;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Services\KeywordBidsService;

/** 
 * Class KeywordBidAuto 
 * 
 * @property     integer         $campaignId
 * @property     integer         $adGroupId
 * @property     integer         $keywordId
 * @property     BiddingRule     $biddingRule
 *                               
 * @method       $this           setCampaignId(integer $campaignId)
 * @method       integer         getCampaignId()
 * @method       $this           setAdGroupId(integer $adGroupId)
 * @method       integer         getAdGroupId()
 * @method       $this           setKeywordId(integer $keywordId)
 * @method       integer         getKeywordId()
 * @method       $this           setBiddingRule(BiddingRule $biddingRule)
 * @method       BiddingRule     getBiddingRule()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class KeywordBidAuto extends Model 
{ 
    protected static $compatibleCollection = KeywordBidsAuto::class;

    protected static $properties = [
        'campaignId' => 'integer',
        'adGroupId' => 'integer',
        'keywordId' => 'integer',
        'biddingRule' => 'object:' . BiddingRule::class
    ];

    public function apply():Result
    {
        return KeywordBidsService::setAuto($this);
    }
}