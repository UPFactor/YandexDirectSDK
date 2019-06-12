<?php


namespace YandexDirectSDKTest\Examples\Ads;

use PHPUnit\Framework\TestCase;
use YandexDirectSDK\Collections\Ads;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\ModelCollectionException;
use YandexDirectSDK\Exceptions\ModelException;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Interfaces\ModelCollection as ModelCollectionInterface;
use YandexDirectSDK\Models\Ad;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\DynamicTextAd;
use YandexDirectSDK\Models\TextAd;
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
     * @return Ads|ModelCollectionInterface
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     */
    public function testAddTextAd_HighestPosition()
    {
        $session = self::$session;
        $adGroup = self::$textAdGroup_HighestPosition;

        // DEMO =====================================================================

        /**
         * @var Ads $ads
         * @var AdGroup $adGroup
         * @var Session $session
         */
        $ads = Ads::make(
            Ad::make()
                ->setAdGroupId($adGroup->id)
                ->setTextAd(
                    TextAd::make()
                        ->setTitle('Title of my ads 1')
                        ->setTitle2('Title of my second ads')
                        ->setText('My ads text')
                        ->setHref('https://mysite.com/page/')
                        ->setMobile('NO')
                ),
            Ad::make()
                ->setAdGroupId($adGroup->id)
                ->setTextAd(
                    TextAd::make()
                        ->setTitle('Title of my ads 2')
                        ->setTitle2('Title of my second ads')
                        ->setText('My ads text')
                        ->setHref('https://mysite.com/page/')
                        ->setMobile('NO')
                )
        );

        $ads->setSession($session);
        $ads->add();

        // ==========================================================================

        return self::$checklists->checkModelCollection($ads, ['Id' => 'integer']);
    }

    /**
     * @return Ads|ModelCollectionInterface
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     */
    public function testAddTextAd_WbMaximumClicks(){
        $session = self::$session;
        $adGroup = self::$textAdGroup_WbMaximumClicks;

        // DEMO =====================================================================

        /**
         * @var Ads $ads
         * @var AdGroup $adGroup
         * @var Session $session
         */
        $ads = Ads::make(
            Ad::make()
                ->setAdGroupId($adGroup->id)
                ->setTextAd(
                    TextAd::make()
                        ->setTitle('Title of my ads 1')
                        ->setTitle2('Title of my second ads')
                        ->setText('My ads text')
                        ->setHref('https://mysite.com/page/')
                        ->setMobile('NO')
                ),
            Ad::make()
                ->setAdGroupId($adGroup->id)
                ->setTextAd(
                    TextAd::make()
                        ->setTitle('Title of my ads 2')
                        ->setTitle2('Title of my second ads')
                        ->setText('My ads text')
                        ->setHref('https://mysite.com/page/')
                        ->setMobile('NO')
                )
        );

        $ads->setSession($session);
        $ads->add();

        // ==========================================================================

        return self::$checklists->checkModelCollection($ads, ['Id' => 'integer']);
    }

    /**
     * @return Ads|ModelCollectionInterface
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
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
        $ad = Ads::make(
            Ad::make()
                ->setAdGroupId($adGroup->id)
                ->setDynamicTextAd(
                    DynamicTextAd::make()
                        ->setText('Text of my ad')
                ),
            Ad::make()
                ->setAdGroupId($adGroup->id)
                ->setDynamicTextAd(
                    DynamicTextAd::make()
                        ->setText('Text of my ad')
                )
        );

        $ad->setSession($session);
        $ad->add();

        // ==========================================================================

        return self::$checklists->checkModelCollection($ad, ['Id' => 'integer']);
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Get
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddTextAd_HighestPosition
     *
     * @param Ads $ads
     * @throws InvalidArgumentException
     * @throws ModelException
     * @throws RuntimeException
     * @throws ModelCollectionException
     */
    public function testGetAds(Ads $ads)
    {
        $session = self::$session;
        $adsIds = $ads->extract('id');

        // DEMO =====================================================================

        /**
         * @var Session $session
         * @var array $adsIds
         * @var Result $result
         */
        $result = Ads::make()->setSession($session)->query()
            ->select([
                'Id',
                'Type',
                'TextAd.Title',
                'TextAd.Title2',
                'TextAd.Text'
            ])
            ->whereIn('Ids', $adsIds)
            ->limit(10)
            ->get();

        // ==========================================================================

        self::$checklists->checkResource($result, Ads::class, [
            'Id',
            'Type',
            'TextAd.Title',
            'TextAd.Title2',
            'TextAd.Text'
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
     * @depends testAddTextAd_HighestPosition
     *
     * @param Ads $ads
     * @throws ModelException
     */
    public function testModerate(Ads $ads)
    {
        // DEMO =====================================================================

        /**
         * @var Ads $ads
         * @var Result $result
         */
        $result = $ads->moderate();

        // ==========================================================================

        self::$checklists->checkResource($result, null);
        sleep(10);
    }

    /**
     * @depends testAddTextAd_HighestPosition
     * @depends testModerate
     *
     * @param Ads $ads
     * @throws ModelException
     */
    public function testSuspend(Ads $ads)
    {
        // DEMO =====================================================================

        /**
         * @var Ads $ads
         * @var Result $result
         */
        $result = $ads->suspend();

        // ==========================================================================

        self::$checklists->checkResource($result, null);
        sleep(10);
    }

    /**
     * @depends testAddTextAd_HighestPosition
     * @depends testSuspend
     *
     * @param Ads $ads
     * @throws ModelException
     */
    public function testArchive(Ads $ads)
    {
        // DEMO =====================================================================

        /**
         * @var Ads $ads
         * @var Result $result
         */
        $result = $ads->archive();

        // ==========================================================================

        self::$checklists->checkResource($result, null);
        sleep(10);
    }

    /**
     * @depends testAddTextAd_HighestPosition
     * @depends testArchive
     *
     * @param Ads $ads
     * @throws ModelException
     */
    public function testUnarchive(Ads $ads)
    {
        // DEMO =====================================================================

        /**
         * @var Ads $ads
         * @var Result $result
         */
        $result = $ads->unarchive();

        // ==========================================================================

        self::$checklists->checkResource($result, null);
        sleep(10);
    }

    /**
     * @depends testAddTextAd_HighestPosition
     * @depends testUnarchive
     *
     * @param Ads $ads
     * @throws ModelException
     */
    public function testResume(Ads $ads)
    {
        // DEMO =====================================================================

        /**
         * @var Ads $ads
         * @var Result $result
         */
        $result = $ads->resume();

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
     * @param Ads $ads
     * @throws ModelException
     */
    public function testUpdateTextAd_HighestPosition(Ads $ads)
    {
        // DEMO =====================================================================

        /**
         * @var Ads $ads
         */
        $ads->each(function(Ad $ad){
            $ad->setTextAd(
                TextAd::make()
                    ->setTitle('Title of my ad')
                    ->setTitle2('Title of my second ad')
                    ->setText('My ad text')
                    ->setHref('https://mysite.com/page/')
                    ->setMobile('NO')
            );
        });

        /**
         * @var Ads $ads
         * @var Result $result
         */
        $result = $ads->update();

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
     * @param Ads $ads
     * @throws ModelException
     */
    public function testDeleteTextAd_HighestPosition(Ads $ads)
    {
        // DEMO =====================================================================

        /**
         * @var Ads $ads
         * @var Result $result
         */
        $result = $ads->delete();

        // ==========================================================================

        self::$checklists->checkResource($result, null);
    }
}