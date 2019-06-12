<?php


namespace YandexDirectSDKTest\Examples\Ads;

use PHPUnit\Framework\TestCase;
use YandexDirectSDK\Collections\Ads;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\ModelCollectionException;
use YandexDirectSDK\Exceptions\ModelException;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Interfaces\Model as ModelInterface;
use YandexDirectSDK\Models\Ad;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\DynamicTextAd;
use YandexDirectSDK\Models\TextAd;
use YandexDirectSDK\Session;
use YandexDirectSDKTest\Examples\AdGroups\ModelExamplesTest as AdGroupModelExamples;
use YandexDirectSDKTest\Helpers\Checklists;
use YandexDirectSDKTest\Helpers\SessionTools;

class ModeExamplesTest extends TestCase
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
     * @return Ad|ModelInterface
     * @throws ModelException
     */
    public function testAddTextAd_HighestPosition()
    {
        $session = self::$session;
        $adGroup = self::$textAdGroup_HighestPosition;

        // DEMO =====================================================================

        /**
         * @var Ad $ad
         * @var AdGroup $adGroup
         * @var Session $session
         */
        $ad = Ad::make()
            ->setAdGroupId($adGroup->id)
            ->setTextAd(
                TextAd::make()
                    ->setTitle('Title of my ad')
                    ->setTitle2('Title of my second ad')
                    ->setText('My ad text')
                    ->setHref('https://mysite.com/page/')
                    ->setMobile('NO')
            );

        $ad->setSession($session);
        $ad->add();

        // ==========================================================================

        return self::$checklists->checkModel($ad, ['Id' => 'integer']);
    }

    /**
     * @return Ad|ModelInterface
     * @throws ModelException
     */
    public function testAddTextAd_WbMaximumClicks(){
        $session = self::$session;
        $adGroup = self::$textAdGroup_WbMaximumClicks;

        // DEMO =====================================================================

        /**
         * @var Ad $ad
         * @var AdGroup $adGroup
         * @var Session $session
         */
        $ad = Ad::make()
            ->setAdGroupId($adGroup->id)
            ->setTextAd(
                TextAd::make()
                    ->setTitle('Title of my ad')
                    ->setTitle2('Title of my second ad')
                    ->setText('My ad text')
                    ->setHref('https://mysite.com/page/')
                    ->setMobile('NO')
            );

        $ad->setSession($session);
        $ad->add();

        // ==========================================================================

        return self::$checklists->checkModel($ad, ['Id' => 'integer']);
    }

    /**
     * @return Ad|ModelInterface
     * @throws ModelException
     */
    public function testAddDynamicTextAd_WbMaximumClicks()
    {
        $session = self::$session;
        $adGroup = self::$dynamicTextAdGroup_WbMaximumClicks;

        // DEMO =====================================================================

        /**
         * @var Ad $ad
         * @var AdGroup $adGroup
         * @var Session $session
         */
        $ad = Ad::make()
            ->setAdGroupId($adGroup->id)
            ->setDynamicTextAd(
                DynamicTextAd::make()
                    ->setText('Text of my ad')
            );

        $ad->setSession($session);
        $ad->add();

        // ==========================================================================

        return self::$checklists->checkModel($ad, ['Id' => 'integer']);
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Actions
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddTextAd_HighestPosition
     *
     * @param Ad $ad
     * @throws ModelException
     */
    public function testModerate(Ad $ad)
    {
        // DEMO =====================================================================

        /**
         * @var Ad $ad
         * @var Result $result
         */
        $result = $ad->moderate();

        // ==========================================================================

        self::$checklists->checkResource($result, null);
        sleep(10);
    }

    /**
     * @depends testAddTextAd_HighestPosition
     * @depends testModerate
     *
     * @param Ad $ad
     * @throws ModelException
     */
    public function testSuspend(Ad $ad)
    {
        // DEMO =====================================================================

        /**
         * @var Ad $ad
         * @var Result $result
         */
        $result = $ad->suspend();

        // ==========================================================================

        self::$checklists->checkResource($result, null);
        sleep(10);
    }

    /**
     * @depends testAddTextAd_HighestPosition
     * @depends testSuspend
     *
     * @param Ad $ad
     * @throws ModelException
     */
    public function testArchive(Ad $ad)
    {
        // DEMO =====================================================================

        /**
         * @var Ad $ad
         * @var Result $result
         */
        $result = $ad->archive();

        // ==========================================================================

        self::$checklists->checkResource($result, null);
        sleep(10);
    }

    /**
     * @depends testAddTextAd_HighestPosition
     * @depends testArchive
     *
     * @param Ad $ad
     * @throws ModelException
     */
    public function testUnarchive(Ad $ad)
    {
        // DEMO =====================================================================

        /**
         * @var Ad $ad
         * @var Result $result
         */
        $result = $ad->unarchive();

        // ==========================================================================

        self::$checklists->checkResource($result, null);
        sleep(10);
    }

    /**
     * @depends testAddTextAd_HighestPosition
     * @depends testUnarchive
     *
     * @param Ad $ad
     * @throws ModelException
     */
    public function testResume(Ad $ad)
    {
        // DEMO =====================================================================

        /**
         * @var Ad $ad
         * @var Result $result
         */
        $result = $ad->resume();

        // ==========================================================================

        self::$checklists->checkResource($result, null, []);
        sleep(10);
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Update
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddTextAd_HighestPosition
     *
     * @param Ad $ad
     * @throws ModelException
     */
    public function testUpdateTextAd_HighestPosition(Ad $ad)
    {
        // DEMO =====================================================================

        /**
         * @var Ad $ad
         */
        $ad->setTextAd(
            TextAd::make()
                ->setTitle('Title of my ad')
                ->setTitle2('Title of my second ad')
                ->setText('My ad text')
                ->setHref('https://mysite.com/page/')
                ->setMobile('NO')
        );

        /**
         * @var Ad $ad
         * @var Result $result
         */
        $result = $ad->update();

        // ==========================================================================

        self::$checklists->checkResource($result, Ads::class);
    }


    /*
     |-------------------------------------------------------------------------------
     |
     | Delete
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddTextAd_HighestPosition
     *
     * @param Ad $ad
     * @throws ModelException
     */
    public function testDeleteTextAd_HighestPosition(Ad $ad)
    {
        // DEMO =====================================================================

        /**
         * @var Ad $ad
         * @var Result $result
         */
        $result = $ad->delete();

        // ==========================================================================

        self::$checklists->checkResource($result, null);
    }
}