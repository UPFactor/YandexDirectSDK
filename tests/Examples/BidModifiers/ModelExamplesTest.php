<?php


namespace YandexDirectSDKTest\Examples\BidModifiers;

use PHPUnit\Framework\TestCase;
use YandexDirectSDK\Collections\BidModifierSets;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\ModelCollectionException;
use YandexDirectSDK\Exceptions\ModelException;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Interfaces\Model as ModelInterface;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\BidModifier;
use YandexDirectSDK\Models\MobileAdjustment;
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
    }


    public static function tearDownAfterClass():void
    {
        AdGroupModelExamples::tearDownAfterClass();

        self::$textAdGroup_HighestPosition = null;
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
     * @return BidModifier|ModelInterface
     * @throws ModelException
     */
    public function testAddBidModifiers()
    {
        $session = self::$session;
        $adGroup = self::$textAdGroup_HighestPosition;

        // DEMO =====================================================================

        /**
         * @var AdGroup $adGroup
         * @var Session $session
         * @var BidModifier $bidModifier
         */
        $bidModifier = BidModifier::make()
            ->setAdGroupId($adGroup->id)
            ->setMobileAdjustment(
                MobileAdjustment::make()
                    ->setBidModifier(100)
            );

        $bidModifier->setSession($session);
        $bidModifier->add();

        // ==========================================================================

        return self::$checklists->checkModel($bidModifier, ['Id' => 'integer']);
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | set
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddBidModifiers
     *
     * @param BidModifier $bidModifier
     * @throws ModelException
     */
    public function testSetBidModifiers(BidModifier $bidModifier)
    {
        // DEMO =====================================================================

        /**
         * @var BidModifier $bidModifier
         * @var Result $result
         */
        $result = $bidModifier->set(100);

        // ==========================================================================

        self::$checklists->checkResource($result, BidModifierSets::class);
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | delete
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddBidModifiers
     *
     * @param BidModifier $bidModifier
     * @throws ModelException
     */
    public function testDeleteBidModifiers(BidModifier $bidModifier)
    {
        // DEMO =====================================================================

        /**
         * @var BidModifier $bidModifier
         * @var Result $result
         */
        $result = $bidModifier->delete();

        // ==========================================================================

        self::$checklists->checkResource($result, null);
    }
}