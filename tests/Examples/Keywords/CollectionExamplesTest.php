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
use YandexDirectSDK\Interfaces\ModelCollection as ModelCollectionInterface;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\BidAuto;
use YandexDirectSDK\Models\Keyword;
use YandexDirectSDK\Session;
use YandexDirectSDKTest\Examples\AdGroups\ModelExamplesTest as AdGroupModelExamples;
use YandexDirectSDKTest\Helpers\Checklists;
use YandexDirectSDKTest\Helpers\SessionTools;

class CollectionExamplesTest extends TestCase
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
         * @var Keywords $keywords
         * @var AdGroup $adGroup
         * @var Session $session
         */
        $keywords = Keywords::make(
            Keyword::make()
                ->setAdGroupId($adGroup->id)
                ->setKeyword('My keyword 1'),
            Keyword::make()
                ->setAdGroupId($adGroup->id)
                ->setKeyword('My keyword 2')
        );

        $keywords->setSession($session);
        $keywords->add();

        // ==========================================================================

        return self::$checklists->checkModelCollection($keywords, [
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
         * @var Keywords $keywords
         * @var AdGroup $adGroup
         * @var Session $session
         */
        $keywords = Keywords::make(
            Keyword::make()
                ->setAdGroupId($adGroup->id)
                ->setKeyword('My keyword 2'),
            Keyword::make()
                ->setAdGroupId($adGroup->id)
                ->setKeyword('My keyword 3')
        );

        $keywords->setSession($session);
        $keywords->add();

        // ==========================================================================

        return self::$checklists->checkModelCollection($keywords, [
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
     * @throws ModelCollectionException
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
        $result = Keywords::make()->setSession($session)->query()
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
        // DEMO =====================================================================

        /**
         * @var Keywords $keywords
         * @var Result $result
         */
        $result = $keywords->suspend();

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
        // DEMO =====================================================================

        /**
         * @var Keywords $keywords
         * @var Result $result
         */
        $result = $keywords->resume();

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
     * @throws ModelException
     */
    public function testSetRelatedBids(Keywords $keywords)
    {
        // DEMO =====================================================================

        /**
         * @var Keywords $keywords
         * @var Result $result
         */
        $result = $keywords
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
     * @param Keywords $keywords
     * @throws ModelException
     */
    public function testSetRelatedContextBids(Keywords $keywords)
    {
        // DEMO =====================================================================

        /**
         * @var Keywords $keywords
         * @var Result $result
         */
        $result = $keywords
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
     * @param Keywords $keywords
     * @throws ModelException
     */
    public function testSetRelatedStrategyPriority(Keywords $keywords)
    {
        // DEMO =====================================================================

        /**
         * @var Keywords $keywords
         * @var Result $result
         */
        $result = $keywords
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
     * @param Keywords $keywords
     * @throws ModelException
     */
    public function testSetRelatedBidsAuto(Keywords $keywords)
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
         * @var Keywords $keywords
         * @var Result $result
         */
        $result = $keywords
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
     * @param Keywords $keywords
     * @throws ModelException
     */
    public function testGetRelatedBids(Keywords $keywords)
    {
        // DEMO =====================================================================

        /**
         * @var Keywords $keywords
         * @var Result $result
         */
        $result = $keywords
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
     * @param Keywords $keywords
     * @throws ModelException
     */
    public function testUpdateKeywords_HighestPosition(Keywords $keywords)
    {
        // DEMO =====================================================================

        /**
         * @var Keywords $keywords
         */
        $keywords->each(function(Keyword $keyword, int $i){
            $keyword->setKeyword('Another keyword' . $i);
        });

        /**
         * @var Keywords $keywords
         * @var Result $result
         */
        $result = $keywords->update();

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
        // DEMO =====================================================================

        /**
         * @var Keywords $keywords
         * @var Result $result
         */
        $result = $keywords->delete();

        // ==========================================================================

        self::$checklists->checkResource($result, null);
    }
}