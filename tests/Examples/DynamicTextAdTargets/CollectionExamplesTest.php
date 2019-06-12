<?php


namespace YandexDirectSDKTest\Examples\DynamicTextAdTargets;

use PHPUnit\Framework\TestCase;
use YandexDirectSDK\Collections\WebpageBids;
use YandexDirectSDK\Collections\WebpageConditions;
use YandexDirectSDK\Collections\Webpages;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\ModelCollectionException;
use YandexDirectSDK\Exceptions\ModelException;
use YandexDirectSDK\Exceptions\RequestException;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Exceptions\ServiceException;
use YandexDirectSDK\Interfaces\ModelCollection as ModelCollectionInterface;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\Webpage;
use YandexDirectSDK\Models\WebpageCondition;
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
    protected static $dynamicTextAdGroup_HighestPosition;

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
        self::$dynamicTextAdGroup_HighestPosition = $adGroupExamples->testAddDynamicTextAdGroup_HighestPosition();
        self::$dynamicTextAdGroup_WbMaximumClicks = $adGroupExamples->testAddDynamicTextAdGroup_WbMaximumClicks();
    }

    public static function tearDownAfterClass():void
    {
        AdGroupModelExamples::tearDownAfterClass();

        self::$dynamicTextAdGroup_HighestPosition = null;
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
     * @return Webpages|ModelCollectionInterface
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     */
    public function testAddWebpages_HighestPosition()
    {
        $session = self::$session;
        $adGroup = self::$dynamicTextAdGroup_HighestPosition;

        // DEMO =====================================================================

        /**
         * @var AdGroup $adGroup
         * @var Webpages $webpages
         */
        $webpages = Webpages::make(
            Webpage::make()
                ->setName('Name of the targeting condition')
                ->setAdGroupId($adGroup->id)
                ->setBid(10000000)
                ->setConditions(
                    WebpageConditions::make(
                        WebpageCondition::urlContain(['yandex.ru','direct']),
                        WebpageCondition::pageTitleContain(['API','SDK'])
                    )
                )
        );

        /**
         * @var Session $session
         */
        $webpages->setSession($session);
        $webpages->add();

        // ==========================================================================

        return self::$checklists->checkModelCollection($webpages, [
            'Id' => 'integer',
            'AdGroupId' => 'integer',
            'Name' => 'string',
            'Bid' => 'integer',
            'Conditions' => 'array',
            'Conditions.0.Operand' => 'string',
            'Conditions.0.Operator' => 'string',
            'Conditions.0.Arguments' => 'array',
            'Conditions.1.Operand' => 'string',
            'Conditions.1.Operator' => 'string',
            'Conditions.1.Arguments' => 'array'
        ]);
    }

    /**
     * @return Webpages|ModelCollectionInterface
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     */
    public function testAddWebpages_WbMaximumClicks()
    {
        $session = self::$session;
        $adGroup = self::$dynamicTextAdGroup_WbMaximumClicks;

        // DEMO =====================================================================

        /**
         * @var AdGroup $adGroup
         * @var Webpages $webpages
         */
        $webpages = Webpages::make(
            Webpage::make()
                ->setName('Name of the targeting condition')
                ->setAdGroupId($adGroup->id)
                ->setStrategyPriority('LOW')
                ->setConditions(
                    WebpageConditions::make(
                        WebpageCondition::urlContain(['yandex.ru','direct']),
                        WebpageCondition::pageTitleContain(['API','SDK'])
                    )
                )
        );

        /**
         * @var Session $session
         */
        $webpages->setSession($session);
        $webpages->add();

        // ==========================================================================

        return self::$checklists->checkModelCollection($webpages, [
            'Id' => 'integer',
            'AdGroupId' => 'integer',
            'Name' => 'string',
            'StrategyPriority' => 'string',
            'Conditions' => 'array',
            'Conditions.0.Operand' => 'string',
            'Conditions.0.Operator' => 'string',
            'Conditions.0.Arguments' => 'array',
            'Conditions.1.Operand' => 'string',
            'Conditions.1.Operator' => 'string',
            'Conditions.1.Arguments' => 'array'
        ]);
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | get
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddWebpages_HighestPosition
     * @depends testAddWebpages_WbMaximumClicks
     *
     * @param Webpages $webpages
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     * @throws RuntimeException
     */
    public function testGetWebpages(Webpages $webpages)
    {
        $session = self::$session;
        $webpageIds = $webpages->extract('id');

        // DEMO =====================================================================

        /**
         * @var Session $session
         * @var array $webpageIds
         * @var Result $result
         */
        $result = Webpages::make()->setSession($session)->query()
            ->select([
                'Id',
                'Name',
                'AdGroupId',
                'Conditions',
                'StrategyPriority'
            ])
            ->whereIn('Ids', $webpageIds)
            ->limit(10)
            ->get();

        // ==========================================================================

        self::$checklists->checkResource($result, Webpages::class, [
            'Id' => 'integer',
            'AdGroupId' => 'integer',
            'Name' => 'string',
            'StrategyPriority' => 'string',
            'Conditions' => 'array',
            'Conditions.0.Operand' => 'string',
            'Conditions.0.Operator' => 'string',
            'Conditions.0.Arguments' => 'array',
            'Conditions.1.Operand' => 'string',
            'Conditions.1.Operator' => 'string',
            'Conditions.1.Arguments' => 'array'
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
     * @depends testAddWebpages_HighestPosition
     * @depends testAddWebpages_WbMaximumClicks
     *
     * @param Webpages $webpages
     * @throws ModelException
     */
    public function testSuspend(Webpages $webpages)
    {
        // DEMO =====================================================================

        /**
         * @var Webpages $webpages
         * @var Result $result
         */
        $result = $webpages->suspend();

        // ==========================================================================

        self::$checklists->checkResource($result, null);
        sleep(10);
    }

    /**
     * @depends testAddWebpages_HighestPosition
     * @depends testAddWebpages_WbMaximumClicks
     * @depends testSuspend
     *
     * @param Webpages $webpages
     * @throws ModelException
     */
    public function testResume(Webpages $webpages)
    {
        // DEMO =====================================================================

        /**
         * @var Webpages $webpages
         * @var Result $result
         */
        $result = $webpages->resume();

        // ==========================================================================

        self::$checklists->checkResource($result, null);
        sleep(10);
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Bids
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddWebpages_HighestPosition
     *
     * @param Webpages $webpages
     * @throws ModelException
     */
    public function testSetRelatedBids(Webpages $webpages)
    {
        // DEMO =====================================================================

        /**
         * @var Webpages $webpages
         * @var Result $result
         */
        $result = $webpages->setRelatedBids(20000000);

        // ==========================================================================

        self::$checklists->checkResource($result, WebpageBids::class, [
            'Id' => 'integer',
            'Bid' => 'integer'
        ]);
    }

    /**
     * @depends testAddWebpages_WbMaximumClicks
     *
     * @param Webpages $webpages
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ServiceException
     */
    public function testSetRelatedStrategyPriority(Webpages $webpages)
    {
        // DEMO =====================================================================

        /**
         * @var Webpages $webpages
         * @var Result $result
         */
        $result = $webpages->setRelatedStrategyPriority('LOW');

        // ==========================================================================

        self::$checklists->checkResource($result, WebpageBids::class, [
            'Id' => 'integer',
            'StrategyPriority' => 'string'
        ]);
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | delete
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddWebpages_HighestPosition
     *
     * @param Webpages $webpages
     * @throws ModelException
     */
    public function testDeleteWebpages_HighestPosition(Webpages $webpages)
    {
        // DEMO =====================================================================

        /**
         * @var Webpages $webpages
         * @var Result $result
         */
        $result = $webpages->delete();

        // ==========================================================================

        self::$checklists->checkResource($result, null);
    }
}