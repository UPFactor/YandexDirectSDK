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
use YandexDirectSDK\Interfaces\Model as ModelInterface;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\Webpage;
use YandexDirectSDK\Models\WebpageCondition;
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
     * @return Webpages|ModelInterface
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
         * @var Webpage $webpage
         */
        $webpage = Webpage::make()
            ->setName('Name of the targeting condition')
            ->setAdGroupId($adGroup->id)
            ->setBid(10000000)
            ->setConditions(
                WebpageConditions::make(
                    WebpageCondition::urlContain(['yandex.ru','direct']),
                    WebpageCondition::pageTitleContain(['API','SDK'])
                )
            );

        /**
         * @var Session $session
         */
        $webpage->setSession($session);
        $webpage->add();

        // ==========================================================================

        return self::$checklists->checkModel($webpage, [
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
     * @return Webpages|ModelInterface
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
         * @var Webpage $webpage
         */
        $webpage = Webpage::make()
            ->setName('Name of the targeting condition')
            ->setAdGroupId($adGroup->id)
            ->setStrategyPriority('LOW')
            ->setConditions(
                WebpageConditions::make(
                    WebpageCondition::urlContain(['yandex.ru','direct']),
                    WebpageCondition::pageTitleContain(['API','SDK'])
                )
            );

        /**
         * @var Session $session
         */
        $webpage->setSession($session);
        $webpage->add();

        // ==========================================================================

        return self::$checklists->checkModel($webpage, [
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
     * @param Webpage $webpage
     * @throws ModelException
     */
    public function testSuspend(Webpage $webpage)
    {
        // DEMO =====================================================================

        /**
         * @var Webpage $webpage
         * @var Result $result
         */
        $result = $webpage->suspend();

        // ==========================================================================

        self::$checklists->checkResource($result, null);
        sleep(10);
    }

    /**
     * @depends testAddWebpages_HighestPosition
     * @depends testAddWebpages_WbMaximumClicks
     * @depends testSuspend
     *
     * @param Webpage $webpage
     * @throws ModelException
     */
    public function testResume(Webpage $webpage)
    {
        // DEMO =====================================================================

        /**
         * @var Webpage $webpage
         * @var Result $result
         */
        $result = $webpage->resume();

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
     * @param Webpage $webpage
     * @throws ModelException
     */
    public function testSetRelatedBids(Webpage $webpage)
    {
        // DEMO =====================================================================

        /**
         * @var Webpage $webpage
         * @var Result $result
         */
        $result = $webpage->setRelatedBids(20000000);

        // ==========================================================================

        self::$checklists->checkResource($result, WebpageBids::class, [
            'Id' => 'integer',
            'Bid' => 'integer'
        ]);
    }

    /**
     * @depends testAddWebpages_WbMaximumClicks
     *
     * @param Webpage $webpage
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ServiceException
     */
    public function testSetRelatedStrategyPriority(Webpage $webpage)
    {
        // DEMO =====================================================================

        /**
         * @var Webpage $webpage
         * @var Result $result
         */
        $result = $webpage->setRelatedStrategyPriority('LOW');

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
     * @param Webpage $webpage
     * @throws ModelException
     */
    public function testDeleteWebpages_HighestPosition(Webpage $webpage)
    {
        // DEMO =====================================================================

        /**
         * @var Webpage $webpage
         * @var Result $result
         */
        $result = $webpage->delete();

        // ==========================================================================

        self::$checklists->checkResource($result, null);
    }
}