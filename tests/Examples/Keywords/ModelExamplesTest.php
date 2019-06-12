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
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Interfaces\Model as ModelInterface;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\BidAuto;
use YandexDirectSDK\Models\Keyword;
use YandexDirectSDK\Session;
use YandexDirectSDKTest\Examples\AdGroups\ModelExamplesTest as AdGroupModelExamples;
use YandexDirectSDKTest\Helpers\Checklists;
use YandexDirectSDKTest\Helpers\SessionTools;

class ModelExamplesTest extends TestCase
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
     * @return Keyword|ModelInterface
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
         * @var Keyword $keyword
         * @var AdGroup $adGroup
         * @var Session $session
         */
        $keyword = Keyword::make()
            ->setAdGroupId($adGroup->id)
            ->setKeyword('My keyword 1');

        $keyword->setSession($session);
        $keyword->add();

        // ==========================================================================

        return self::$checklists->checkModel($keyword, [
            'Id' => 'integer',
            'Keyword' => 'string',
            'AdGroupId' => 'integer'
        ]);
    }

    /**
     * @return Keyword|ModelInterface
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
         * @var Keyword $keyword
         * @var AdGroup $adGroup
         * @var Session $session
         */
        $keyword = Keyword::make()
            ->setAdGroupId($adGroup->id)
            ->setKeyword('My keyword 1');

        $keyword->setSession($session);
        $keyword->add();

        // ==========================================================================

        return self::$checklists->checkModel($keyword, [
            'Id' => 'integer',
            'Keyword' => 'string',
            'AdGroupId' => 'integer'
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
     * @param Keyword $keyword
     * @throws ModelException
     */
    public function testSuspend(Keyword $keyword)
    {
        // DEMO =====================================================================

        /**
         * @var Keyword $keyword
         * @var Result $result
         */
        $result = $keyword->suspend();

        // ==========================================================================

        self::$checklists->checkResource($result, null, []);
        sleep(10);
    }

    /**
     * @depends testAddKeywords_HighestPosition
     * @depends testSuspend
     *
     * @param Keyword $keyword
     * @throws ModelException
     */
    public function testResume(Keyword $keyword)
    {
        // DEMO =====================================================================

        /**
         * @var Keyword $keyword
         * @var Result $result
         */
        $result = $keyword->resume();

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
     * @param Keyword $keyword
     * @throws ModelException
     */
    public function testSetRelatedBids(Keyword $keyword)
    {
        // DEMO =====================================================================

        /**
         * @var Keyword $keyword
         * @var Result $result
         */
        $result = $keyword
            ->setRelatedBids(30000000, 10000000);

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
     * @param Keyword $keyword
     * @throws ModelException
     */
    public function testSetRelatedContextBids(Keyword $keyword)
    {
        // DEMO =====================================================================

        /**
         * @var Keyword $keyword
         * @var Result $result
         */
        $result = $keyword
            ->setRelatedContextBids(10000000);

        // ==========================================================================

        self::$checklists->checkResource($result, Bids::class, [
            'KeywordId' => 'integer',
            'ContextBid' => 'integer'
        ]);
    }

    /**
     * @depends testAddKeywords_WbMaximumClicks
     *
     * @param Keyword $keyword
     * @throws ModelException
     */
    public function testSetRelatedStrategyPriority(Keyword $keyword)
    {
        // DEMO =====================================================================

        /**
         * @var Keyword $keyword
         * @var Result $result
         */
        $result = $keyword
            ->setRelatedStrategyPriority('LOW');

        // ==========================================================================

        self::$checklists->checkResource($result, Bids::class, [
            'KeywordId' => 'integer',
            'StrategyPriority' => 'string'
        ]);
    }

    /**
     * @depends testAddKeywords_HighestPosition
     *
     * @param Keyword $keyword
     * @throws ModelException
     */
    public function testSetRelatedBidsAuto(Keyword $keyword)
    {
        // DEMO =====================================================================

        /**
         * @var BidAuto $bidAuto
         */
        $bidAuto = BidAuto::make()
            ->setScope(['SEARCH'])
            ->setPosition('PREMIUMBLOCK');

        /**
         * @var BidAuto $bidAuto
         * @var Keyword $keyword
         * @var Result $result
         */
        $result = $keyword
            ->setRelatedBidsAuto($bidAuto);

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
     * @param Keyword $keyword
     * @throws ModelException
     */
    public function testGetRelatedBids(Keyword $keyword)
    {
        // DEMO =====================================================================

        /**
         * @var Keyword $keyword
         * @var Result $result
         */
        $result = $keyword
            ->getRelatedBids(['Bid','AdGroupId','CampaignId']);

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
     * @param Keyword $keyword
     * @throws ModelException
     */
    public function testUpdateKeywords_HighestPosition(Keyword $keyword)
    {
        // DEMO =====================================================================

        /**
         * @var Keyword $keyword
         * @var Result $result
         */
        $result = $keyword
            ->setKeyword('Another keyword')
            ->update();

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
     * @param Keyword $keyword
     * @throws ModelException
     */
    public function testDeleteKeywords_HighestPosition(Keyword $keyword)
    {
        // DEMO =====================================================================

        /**
         * @var Keyword $keyword
         * @var Result $result
         */
        $result = $keyword->delete();

        // ==========================================================================

        self::$checklists->checkResource($result, null);
    }
}