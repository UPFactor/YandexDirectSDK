<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\BidsAuto;
use YandexDirectSDK\Components\Model;

/** 
 * Class BidAuto 
 * 
 * @property       integer    $campaignId
 * @property       integer    $adGroupId
 * @property       integer    $keywordId
 * @property       string[]   $scope
 * @property       integer    $maxBid
 * @property       string     $position
 * @property       integer    $increasePercent
 * @property       string     $calculateBy
 * @property       integer    $contextCoverage
 * 
 * @method         $this      setCampaignId(integer $campaignId)
 * @method         $this      setAdGroupId(integer $adGroupId)
 * @method         $this      setKeywordId(integer $keywordId)
 * @method         $this      setScope(string[] $scope)
 * @method         $this      setMaxBid(integer $maxBid)
 * @method         $this      setPosition(string $position)
 * @method         $this      setIncreasePercent(integer $increasePercent)
 * @method         $this      setCalculateBy(string $calculateBy)
 * @method         $this      setContextCoverage(integer $contextCoverage)
 * 
 * @method         integer    getCampaignId()
 * @method         integer    getAdGroupId()
 * @method         integer    getKeywordId()
 * @method         string[]   getScope()
 * @method         integer    getMaxBid()
 * @method         string     getPosition()
 * @method         integer    getIncreasePercent()
 * @method         string     getCalculateBy()
 * @method         integer    getContextCoverage()
 * 
 * @package YandexDirectSDK\Models 
 */
class BidAuto extends Model 
{
    const SEARCH = 'SEARCH';
    const NETWORK = 'NETWORK';
    const VALUE = 'VALUE';
    const DIFF = 'DIFF';
    const PREMIUMFIRST = 'PREMIUMFIRST';
    const PREMIUMBLOCK = 'PREMIUMBLOCK';
    const FOOTERFIRST = 'FOOTERFIRST';
    const FOOTERBLOCK = 'FOOTERBLOCK';
    const P11 = 'P11';
    const P12 = 'P12';
    const P13 = 'P13';
    const P14 = 'P14';
    const P21 = 'P21';
    const P22 = 'P22';
    const P23 = 'P23';
    const P24 = 'P24';

    protected static $compatibleCollection = BidsAuto::class;

    protected static $properties = [
        'campaignId' => 'integer',
        'adGroupId' => 'integer',
        'keywordId' => 'integer',
        'scope' => 'set:' . self::SEARCH . ',' . self::NETWORK,
        'maxBid' => 'integer',
        'position' => 'enum:' . self::PREMIUMFIRST . ',' . self::PREMIUMBLOCK . ',' . self::FOOTERFIRST . ',' . self::FOOTERBLOCK . ',' . self::P11 . ',' . self::P12 . ',' . self::P13 . ',' . self::P14 . ',' . self::P21 . ',' . self::P22 . ',' . self::P23 . ',' . self::P24,
        'increasePercent' => 'integer',
        'calculateBy' => 'enum:' . self::VALUE . ',' . self::DIFF,
        'contextCoverage' => 'integer'
    ];
}