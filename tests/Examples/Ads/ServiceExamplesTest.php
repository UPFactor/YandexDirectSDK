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
     * @return Ads|ModelInterface
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
         * @var AdGroup $adGroup
         * @var Session $session
         * @var Result $result
         */
        $result = $session->getAdsService()->add(
            Ads::make(
                Ad::make()
                    ->setAdGroupId($adGroup->id)
                    ->setTextAd(
                        TextAd::make()
                            ->setTitle('Title of my ad')
                            ->setTitle2('Title of my second ad')
                            ->setText('My ad text')
                            ->setHref('https://mysite.com/page/')
                            ->setMobile('NO')
                    )
            )
        );

        // ==========================================================================

        return self::$checklists->checkResource($result, Ads::class, [
            'Id' => 'integer',
            'TextAd.Title' => 'string',
            'TextAd.Title2' => 'string',
            'TextAd.Text' => 'string',
            'TextAd.Href' => 'string',
            'TextAd.Mobile' => 'string'
        ]);
    }

    /**
     * @return Ads|ModelInterface
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     */
    public function testAddTextAd_WbMaximumClicks(){
        $session = self::$session;
        $adGroup = self::$textAdGroup_WbMaximumClicks;

        // DEMO =====================================================================

        /**
         * @var AdGroup $adGroup
         * @var Session $session
         * @var Result $result
         */
        $result = $session->getAdsService()->add(
            Ads::make(
                Ad::make()
                    ->setAdGroupId($adGroup->id)
                    ->setTextAd(
                        TextAd::make()
                            ->setTitle('Title of my ad')
                            ->setTitle2('Title of my second ad')
                            ->setText('My ad text')
                            ->setHref('https://mysite.com/page/')
                            ->setMobile('NO')
                    )
            )
        );

        // ==========================================================================

        return self::$checklists->checkResource($result, Ads::class, [
            'Id' => 'integer',
            'TextAd.Title' => 'string',
            'TextAd.Title2' => 'string',
            'TextAd.Text' => 'string',
            'TextAd.Href' => 'string',
            'TextAd.Mobile' => 'string'
        ]);
    }

    /**
     * @return Ads|ModelInterface
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
         * @var AdGroup $adGroup
         * @var Session $session
         * @var Result $result
         */
        $result = $session->getAdsService()->add(
            Ads::make(
                Ad::make()
                    ->setAdGroupId($adGroup->id)
                    ->setDynamicTextAd(
                        DynamicTextAd::make()
                            ->setText('Text of my ad')
                    )
            )
        );

        // ==========================================================================

        return self::$checklists->checkResource($result, Ads::class, [
            'Id' => 'integer',
            'DynamicTextAd.Text' => 'string'
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
     * @depends testAddTextAd_HighestPosition
     *
     * @param Ads $ads
     * @throws InvalidArgumentException
     * @throws ModelException
     * @throws RuntimeException
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
        $result = $session->getAdsService()->query()
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
        $session = self::$session;
        $adsIds = $ads->extract('id');

        // DEMO =====================================================================

        /**
         * @var Session $session
         * @var array $adsIds
         * @var Result $result
         */
        $result = $session->getAdsService()->moderate($adsIds);

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
        $session = self::$session;
        $adsIds = $ads->extract('id');

        // DEMO =====================================================================

        /**
         * @var Session $session
         * @var array $adsIds
         * @var Result $result
         */
        $result = $session->getAdsService()->suspend($adsIds);

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
        $session = self::$session;
        $adsIds = $ads->extract('id');

        // DEMO =====================================================================

        /**
         * @var Session $session
         * @var array $adsIds
         * @var Result $result
         */
        $result = $session->getAdsService()->archive($adsIds);

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
        $session = self::$session;
        $adsIds = $ads->extract('id');

        // DEMO =====================================================================

        /**
         * @var Session $session
         * @var array $adsIds
         * @var Result $result
         */
        $result = $session->getAdsService()->unarchive($adsIds);

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
        $session = self::$session;
        $adsIds = $ads->extract('id');

        // DEMO =====================================================================

        /**
         * @var Session $session
         * @var array $adsIds
         * @var Result $result
         */
        $result = $session->getAdsService()->resume($adsIds);

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
        $session = self::$session;

        // DEMO =====================================================================

        /**
         * @var Ads $ads
         * @var Ad $ad
         */
        $ad = $ads->first();

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
         * @var Result $result
         */
        $result = $session
            ->getAdsService()
            ->update($ad);

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
        $session = self::$session;
        $adsIds = $ads->extract('id');

        // DEMO =====================================================================

        /**
         * @var Session $session
         * @var array $adsIds
         * @var Result $result
         */
        $result = $session
            ->getAdsService()
            ->delete($adsIds);

        // ==========================================================================

        self::$checklists->checkResource($result, null);
    }
}