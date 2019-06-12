<?php


namespace YandexDirectSDKTest\Examples\Bids;

use PHPUnit\Framework\TestCase;
use YandexDirectSDK\Collections\Bids;
use YandexDirectSDK\Collections\BidsAuto;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\ModelCollectionException;
use YandexDirectSDK\Exceptions\ModelException;
use YandexDirectSDK\Exceptions\RequestException;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Exceptions\ServiceException;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\Bid;
use YandexDirectSDK\Models\BidAuto;
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
    }


    public static function tearDownAfterClass():void
    {
        AdGroupModelExamples::tearDownAfterClass();

        self::$textAdGroup_HighestPosition = null;
        self::$textAdGroup_WbMaximumClicks = null;
        self::$checklists = null;
        self::$session = null;
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Set
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     * @throws RuntimeException
     * @throws RequestException
     */
    public function testSetBids()
    {
        $session = self::$session;
        $adGroup1 = self::$textAdGroup_HighestPosition;
        $adGroup2 = self::$textAdGroup_WbMaximumClicks;

        // DEMO =====================================================================

        /**
         * @var AdGroup $adGroup1
         * @var AdGroup $adGroup2
         * @var Session $session
         * @var Result $result
         */
        $result = $session->getBidsService()->set(
            Bids::make(
                Bid::make()
                    ->setAdGroupId($adGroup1->id)
                    ->setBid(3000000)
                    ->setContextBid(2000000),
                Bid::make()
                    ->setAdGroupId($adGroup2->id)
                    ->setStrategyPriority('LOW')
            )
        );

        // ==========================================================================

        self::$checklists->checkResource($result, Bids::class);
    }

    /**
     * @throws InvalidArgumentException
     * @throws ModelException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ServiceException
     */
    public function testSetBidsAuto()
    {
        $session = self::$session;
        $adGroup = self::$textAdGroup_HighestPosition;

        // DEMO =====================================================================

        /**
         * @var AdGroup $adGroup
         * @var Session $session
         * @var Result $result
         */
        $result = $session->getBidsService()->setAuto(
            BidAuto::make()
                ->setAdGroupId($adGroup->id)
                ->setMaxBid(3000000)
                ->setScope(['SEARCH'])
                ->setPosition('PREMIUMBLOCK')
        );

        // ==========================================================================

        self::$checklists->checkResource($result, BidsAuto::class);
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Get
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testSetBids
     *
     * @throws InvalidArgumentException
     * @throws ModelException
     * @throws RuntimeException
     */
    public function testGetBids()
    {
        $session = self::$session;
        $adGroup = self::$textAdGroup_HighestPosition;

        // DEMO =====================================================================

        /**
         * @var AdGroup $adGroup
         * @var Session $session
         * @var Result $result
         */
        $result = $session->getBidsService()->query()
            ->select('KeywordId','AdGroupId','Bid','ContextBid')
            ->whereIn('AdGroupIds', $adGroup->id)
            ->get();

        // ==========================================================================

        self::$checklists->checkResource($result, Bids::class, [
            'KeywordId' => 'integer',
            'AdGroupId' => 'integer',
            'ContextBid' => 'integer'
        ]);

    }
}