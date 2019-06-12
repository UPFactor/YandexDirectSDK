<?php


namespace YandexDirectSDKTest\Examples\Keywords;


use PHPUnit\Framework\TestCase;
use YandexDirectSDK\Collections\Bids;
use YandexDirectSDK\Collections\BidsAuto;
use YandexDirectSDK\Collections\Keywords;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\ModelCollectionException;
use YandexDirectSDK\Exceptions\ModelException;
use YandexDirectSDK\Exceptions\RequestException;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Exceptions\ServiceException;
use YandexDirectSDK\Interfaces\ModelCollection as ModelCollectionInterface;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\BidAuto;
use YandexDirectSDK\Models\Keyword;
use YandexDirectSDK\Session;
use YandexDirectSDKTest\Examples\AdGroups\ModelExamplesTest as AdGroupModelExamples;
use YandexDirectSDKTest\Helpers\Checklists;
use YandexDirectSDKTest\Helpers\SessionTools;

class ServiceExamplesTest extends TestCase
{
    /**
     * @var Checklists
     */
    public static $checklists;

    /**
     * @var Session
     */
    public static $session;

    /**
     * @var AdGroup
     */
    protected static $textAdGroup_HighestPosition;

    /**
     * @var AdGroup
     */
    protected static $textAdGroup_WbMaximumClicks;

    /**
     * @var AdGroup
     */
    protected static $dynamicTextAdGroup_WbMaximumClicks;

    /*
     |-------------------------------------------------------------------------------
     |
     | Handlers
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     * @throws RuntimeException
     */
    public static function setUpBeforeClass():void
    {
        $adGroupExamples = new AdGroupModelExamples();
        $adGroupExamples::setUpBeforeClass();

        self::$checklists = new Checklists();
        self::$session = SessionTools::init();
        self::$textAdGroup_HighestPosition = $adGroupExamples->testAddTextAdGroup_HighestPosition();
        self::$textAdGroup_WbMaximumClicks = $adGroupExamples->testAddTextAdGroup_WbMaximumClicks();
        self::$dynamicTextAdGroup_WbMaximumClicks = $adGroupExamples->testAddDynamicTextAdGroup_WbMaximumClicks();
    }


    public static function tearDownAfterClass():void
    {
        AdGroupModelExamples::tearDownAfterClass();

        self::$textAdGroup_HighestPosition = null;
        self::$textAdGroup_WbMaximumClicks = null;
        self::$dynamicTextAdGroup_WbMaximumClicks = null;
        self::$checklists = null;
        self::$session = null;
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Add
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @return Keywords|ModelCollectionInterface
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     */
    public function testAddKeywords_HighestPosition()
    {
        $session = self::$session;
        $adGroup = self::$textAdGroup_HighestPosition;

        // DEMO =====================================================================

        /**
         * @var AdGroup $adGroup
         * @var Session $session
         */
        $result = $session->getKeywordsService()->add(
            Keywords::make(
                Keyword::make()
                    ->setAdGroupId($adGroup->id)
                    ->setKeyword('My keyword 1'),
                Keyword::make()
                    ->setAdGroupId($adGroup->id)
                    ->setKeyword('My keyword 2')
            )
        );

        // ==========================================================================

        return self::$checklists->checkResource($result, Keywords::class, [
            'Id' => 'integer',
            'Keyword' => 'string',
            'AdGroupId' => 'integer'
        ]);
    }

    /**
     * @return Keywords|ModelCollectionInterface
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     */
    public function testAddKeywords_WbMaximumClicks()
    {
        $session = self::$session;
        $adGroup = self::$textAdGroup_WbMaximumClicks;

        // DEMO =====================================================================

        /**
         * @var AdGroup $adGroup
         * @var Session $session
         */
        $result = $session->getKeywordsService()->add(
            Keywords::make(
                Keyword::make()
                    ->setAdGroupId($adGroup->id)
                    ->setKeyword('My keyword 3'),
                Keyword::make()
                    ->setAdGroupId($adGroup->id)
                    ->setKeyword('My keyword 4')
            )
        );

        // ==========================================================================

        return self::$checklists->checkResource($result, Keywords::class, [
            'Id' => 'integer',
            'Keyword' => 'string',
            'AdGroupId' => 'integer'
        ]);

    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Get
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddKeywords_HighestPosition
     *
     * @param Keywords $keywords
     * @throws InvalidArgumentException
     * @throws ModelException
     * @throws RuntimeException
     */
    public function testGetKeywords(Keywords $keywords)
    {
        $session = self::$session;
        $keywordIds = $keywords->extract('id');

        // DEMO =====================================================================

        /**
         * @var Session $session
         * @var array $keywordIds
         * @var Result $result
         */
        $result = $session->getKeywordsService()->query()
            ->select('Id','Keyword','Bid')
            ->whereIn('Ids', $keywordIds)
            ->limit(10)
            ->get();

        // ==========================================================================

        self::$checklists->checkResource($result, Keywords::class, [
            'Id' => 'integer',
            'Keyword' => 'string',
            'Bid' => 'integer'
        ]);
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Actions
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddKeywords_HighestPosition
     *
     * @param Keywords $keywords
     * @throws ModelException
     */
    public function testSuspend(Keywords $keywords)
    {
        $session = self::$session;
        $keywordIds = $keywords->extract('id');

        // DEMO =====================================================================

        /**
         * @var Session $session
         * @var array $keywordIds
         * @var Result $result
         */
        $result = $session->getKeywordsService()->suspend($keywordIds);

        // ==========================================================================

        self::$checklists->checkResource($result, null, []);
        sleep(10);
    }

    /**
     * @depends testAddKeywords_HighestPosition
     * @depends testSuspend
     *
     * @param Keywords $keywords
     * @throws ModelException
     */
    public function testResume(Keywords $keywords)
    {
        $session = self::$session;
        $keywordIds = $keywords->extract('id');

        // DEMO =====================================================================

        /**
         * @var Session $session
         * @var array $keywordIds
         * @var Result $result
         */
        $result = $session->getKeywordsService()->resume($keywordIds);

        // ==========================================================================

        self::$checklists->checkResource($result, null, []);
        sleep(10);
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Related objects
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddKeywords_HighestPosition
     *
     * @param Keywords $keywords
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     * @throws RuntimeException
     * @throws RequestException
     */
    public function testSetRelatedBids(Keywords $keywords)
    {
        $session = self::$session;
        $keywordIds = $keywords->extract('id');

        // DEMO =====================================================================

        /**
         * @var Session $session
         * @var array $keywordIds
         * @var Result $result
         */
        $result = $session
            ->getKeywordsService()
            ->setRelatedBids($keywordIds, 30000000, 10000000);

        // ==========================================================================

        self::$checklists->checkResource($result, Bids::class, [
            'KeywordId' => 'integer',
            'Bid' => 'integer',
            'ContextBid' => 'integer'
        ]);
    }

    /**
     * @depends testAddKeywords_HighestPosition
     *
     * @param Keywords $keywords
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function testSetRelatedContextBids(Keywords $keywords)
    {
        $session = self::$session;
        $keywordIds = $keywords->extract('id');

        // DEMO =====================================================================

        /**
         * @var Session $session
         * @var array $keywordIds
         * @var Result $result
         */
        $result = $session
            ->getKeywordsService()
            ->setRelatedContextBids($keywordIds,10000000);

        // ==========================================================================

        self::$checklists->checkResource($result, Bids::class, [
            'KeywordId' => 'integer',
            'ContextBid' => 'integer'
        ]);
    }

    /**
     * @depends testAddKeywords_WbMaximumClicks
     *
     * @param Keywords $keywords
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function testSetRelatedStrategyPriority(Keywords $keywords)
    {
        $session = self::$session;
        $keywordIds = $keywords->extract('id');

        // DEMO =====================================================================

        /**
         * @var Session $session
         * @var array $keywordIds
         * @var Result $result
         */
        $result = $session
            ->getKeywordsService()
            ->setRelatedStrategyPriority($keywordIds,'LOW');

        // ==========================================================================

        self::$checklists->checkResource($result, Bids::class, [
            'KeywordId' => 'integer',
            'StrategyPriority' => 'string'
        ]);
    }

    /**
     * @depends testAddKeywords_HighestPosition
     *
     * @param Keywords $keywords
     * @throws InvalidArgumentException
     * @throws ModelException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ServiceException
     */
    public function testSetRelatedBidsAuto(Keywords $keywords)
    {
        $session = self::$session;
        $keywordIds = $keywords->extract('id');

        // DEMO =====================================================================

        /**
         * @var BidAuto $bidAuto
         */
        $bidAuto = BidAuto::make()
            ->setScope(['SEARCH'])
            ->setPosition('PREMIUMBLOCK');

        /**
         * @var BidAuto $bidAuto
         * @var array $keywordIds
         * @var Session $session
         * @var Result $result
         */
        $result = $session
            ->getKeywordsService()
            ->setRelatedBidsAuto($keywordIds, $bidAuto);

        // ==========================================================================

        self::$checklists->checkResource($result, BidsAuto::class, [
            'KeywordId' => 'integer',
            'Scope' => 'array',
            'Position' => 'string'
        ]);
    }

    /**
     * @depends testAddKeywords_HighestPosition
     * @depends testSetRelatedBids
     * @depends testSetRelatedContextBids
     * @depends testSetRelatedStrategyPriority
     * @depends testSetRelatedBidsAuto
     *
     * @param Keywords $keywords
     * @throws InvalidArgumentException
     * @throws ModelException
     * @throws RuntimeException
     */
    public function testGetRelatedBids(Keywords $keywords)
    {
        $session = self::$session;
        $keywordIds = $keywords->extract('id');

        // DEMO =====================================================================

        /**
         * @var Session $session
         * @var array $keywordIds
         * @var Result $result
         */
        $result = $session
            ->getKeywordsService()
            ->getRelatedBids($keywordIds, ['Bid','AdGroupId','CampaignId']);

        // ==========================================================================

        self::$checklists->checkResource($result, Bids::class, [
            'Bid' => 'integer',
            'AdGroupId' => 'integer',
            'CampaignId' => 'integer'
        ]);
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Update
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddKeywords_HighestPosition
     *
     * @param Keywords $keywords
     * @throws ModelException
     */
    public function testUpdateKeywords_HighestPosition(Keywords $keywords)
    {
        $session = self::$session;

        // DEMO =====================================================================

        /**
         * @var Keywords $keywords
         * @var Keyword $keyword
         */
        $keyword = $keywords->first();

        /**
         * @var Keyword $keyword
         */
        $keyword->setKeyword('Another keyword');

        /**
         * @var Session $session
         * @var Result $result
         */
        $result = $session
            ->getKeywordsService()
            ->update($keyword);

        // ==========================================================================

        self::$checklists->checkResource($result, Keywords::class);
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Delete
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddKeywords_HighestPosition
     *
     * @param Keywords $keywords
     * @throws ModelException
     */
    public function testDeleteKeywords_HighestPosition(Keywords $keywords)
    {
        $session = self::$session;
        $keywordIds = $keywords->extract('id');

        // DEMO =====================================================================

        /**
         * @var Session $session
         * @var array $keywordIds
         * @var Result $result
         */
        $result = $session
            ->getKeywordsService()
            ->delete($keywordIds);

        // ==========================================================================

        self::$checklists->checkResource($result, null);
    }
}