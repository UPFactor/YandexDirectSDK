<?php


namespace YandexDirectSDKTest\Examples;


use PHPUnit\Framework\TestCase;
use YandexDirectSDK\Collections\AdGroups;
use YandexDirectSDK\Collections\Ads;
use YandexDirectSDK\Collections\Campaigns;
use YandexDirectSDK\Components\Data;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\ModelCollectionException;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Models\Ad;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\Campaign;
use YandexDirectSDK\Models\TextAd;
use YandexDirectSDK\Session;

/**
 * Class AdsExamplesTest
 * @package YandexDirectSDKTest\Examples
 */
class AdsExamplesTest extends TestCase
{
    /**
     * @var AdGroupsExamplesTest
     */
    protected static $adGroupsExTest;

    /**
     * @var Session
     */
    public static $session;

    /**
     * @var AdGroups
     */
    public static $textAdGroups;

    /**
     * @var AdGroup
     */
    public static $textAdGroup;

    /**
     * @var Campaigns
     */
    public static $textCampaigns;

    /**
     * @var Campaign
     */
    public static $textCampaign;

    /**
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public static function setUpBeforeClass():void
    {
        $adGroupsExTest = new AdGroupsExamplesTest();
        $adGroupsExTest::setUpBeforeClass();

        self::$adGroupsExTest = $adGroupsExTest;
        self::$session = $adGroupsExTest::$session;
        self::$textCampaigns = $adGroupsExTest::$textCampaigns;
        self::$textCampaign = $adGroupsExTest::$textCampaign;
        self::$textAdGroups = $adGroupsExTest->testAddAdGroup_byService();
        self::$textAdGroup = self::$textAdGroups->first();
    }

    public static function tearDownAfterClass():void
    {
        self::$adGroupsExTest::tearDownAfterClass();

        self::$adGroupsExTest = null;
        self::$session = null;
        self::$textCampaigns = null;
        self::$textCampaign = null;
        self::$textAdGroups = null;
        self::$textAdGroup = null;
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Add
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @return Ads
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testAddAds_byService(){
        $session = self::$session;
        $adGroup = self::$textAdGroup;

        // Demo =====================================================================

        /**
         * Add ads in Yandex.Direct.
         *
         * @var Session $session
         * @var AdGroup $adGroup
         * @var Result $result
         */
        $result = $session->getAdsService()->add(
            //Creating collection and adding ad model to it.
            Ads::make(
                //Creating ad model and setting its properties.
                //You can add more ad models to the collection.
                Ad::make()
                    ->setAdGroupId($adGroup->id)
                    ->setTextAd(
                        TextAd::make()
                            ->setTitle('My first headline')
                            ->setTitle2('Second headline')
                            ->setText('My ad text')
                            ->setMobile('NO')
                            ->setHref('https://mysite.com')
                    )
            )
        );

        /**
         * Convert result to array.
         * @var array $array
         */
        $array = $result->getData()->all();

        /**
         * Convert result to data object.
         * @var Data $data
         */
        $data = $result->getData();

        /**
         * Convert result to ad collection.
         * @var Ads $ads
         */
        $ads = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(Ads::class, $ads);

        return $ads;
    }

    /**
     * @depends testAddAds_byService
     *
     * @return void
     */
    public function testAddAds_byModel(){
        $session = self::$session;
        $adGroup = self::$textAdGroup;

        // Demo =====================================================================

        /**
         * Create ad model.
         * @var Ad $ad
         */
        $ad = Ad::make()
            ->setAdGroupId($adGroup->id)
            ->setTextAd(
                TextAd::make()
                    ->setTitle('My first headline')
                    ->setTitle2('Second headline')
                    ->setText('My ad text')
                    ->setMobile('NO')
                    ->setHref('https://mysite.com')
            );

        /**
         * Associate ad model with a session.
         * @var Session $session
         */
        $ad->setSession($session);

        /**
         * Add ad to Yandex.Direct.
         * @var Result $result
         */
        $result = $ad->add();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Ad::class, $ad);
        $this->assertNotNull($ad->id);
    }

    /**
     * @depends testAddAds_byService
     *
     * @return void
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testAddAds_byCollection(){
        $session = self::$session;
        $adGroup = self::$textAdGroup;

        // Demo =====================================================================

        /**
         * Create ad collection.
         * @var Ads $ads
         */
        $ads = Ads::make(
            Ad::make()
                ->setAdGroupId($adGroup->id)
                ->setTextAd(
                    TextAd::make()
                        ->setTitle('My first headline')
                        ->setTitle2('Second headline')
                        ->setText('My ad text')
                        ->setMobile('NO')
                        ->setHref('https://mysite.com')
                ),
            Ad::make()
                ->setAdGroupId($adGroup->id)
                ->setTextAd(
                    TextAd::make()
                        ->setTitle('My first headline 2')
                        ->setTitle2('Second headline 2')
                        ->setText('My ad text 2')
                        ->setMobile('NO')
                        ->setHref('https://mysite.com')
                )
        );

        /**
         * Associate ad collection with a session.
         * @var Session $session
         */
        $ads->setSession($session);

        /**
         * Add ads to Yandex.Direct.
         * @var Result $result
         */
        $result = $ads->add();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Ads::class, $ads);
        $this->assertNotNull($ads->first()->{'id'});
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Get
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddAds_byService
     *
     * @return Ads
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testGetAds_byService(){
        $session = self::$session;
        $adGroup = self::$textAdGroup;

        // Demo =====================================================================

        /**
         * Getting a list of result.
         *
         * @var AdGroup $adGroup
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
            ->whereIn('AdGroupIds', [$adGroup->id])
            ->whereIn('Types', ['TEXT_AD'])
            ->limit(10)
            ->offset(5)
            ->get();

        /**
         * Convert result to array.
         * @var array $array
         */
        $array = $result->getData()->all();

        /**
         * Convert result to data object.
         * @var Data $data
         */
        $data = $result->getData();

        /**
         * Convert result to ad collection.
         * @var Ads $ads
         */
        $ads = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(Ads::class, $ads);

        return $ads;
    }

    /**
     * @depends testAddAds_byService
     *
     * @return Ads
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testGetAds_byModel(){
        $session = self::$session;
        $adGroup = self::$textAdGroup;

        // Demo =====================================================================

        /**
         * Getting a list of result.
         * @var AdGroup $adGroup
         * @var Result $result
         */
        $result = Ad::make()->setSession($session)->query()
            ->select([
                'Id',
                'Type',
                'TextAd.Title',
                'TextAd.Title2',
                'TextAd.Text'
            ])
            ->whereIn('AdGroupIds', [$adGroup->id])
            ->whereIn('Types', ['TEXT_AD'])
            ->limit(10)
            ->offset(5)
            ->get();

        /**
         * Convert result to array.
         * @var array $array
         */
        $array = $result->getData()->all();

        /**
         * Convert result to data object.
         * @var Data $data
         */
        $data = $result->getData();

        /**
         * Convert result to ad collection.
         * @var Ads $ads
         */
        $ads = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(Ads::class, $ads);

        return $ads;
    }

    /**
     * @depends testAddAds_byService
     *
     * @return Ads
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws RuntimeException
     */
    public function testGetAds_byCollection(){
        $session = self::$session;
        $adGroup = self::$textAdGroup;

        // Demo =====================================================================

        /**
         * Getting a list of result.
         *
         * @var AdGroup $adGroup
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
            ->whereIn('AdGroupIds', [$adGroup->id])
            ->whereIn('Types', ['TEXT_AD'])
            ->limit(10)
            ->offset(5)
            ->get();

        /**
         * Convert result to array.
         * @var array $array
         */
        $array = $result->getData()->all();

        /**
         * Convert result to data object.
         * @var Data $data
         */
        $data = $result->getData();

        /**
         * Convert result to ads collection.
         * @var Ads $ads
         */
        $ads = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(Ads::class, $ads);

        return $ads;
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Actions
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddAds_byService
     *
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testModerateAds_byService(){
        $session = self::$session;
        $adGroup = self::$textAdGroup;

        // Demo =====================================================================

        /**
         * Getting list of result.
         * @var Result $result
         */
        $result = $session->getAdsService()->query()
            ->select('Id')
            ->whereIn('AdGroupIds', [$adGroup->id])
            ->get();

        /**
         * Convert result to ad collection.
         * @var Ads $ads
         */
        $ads = $result->getResource();

        /**
         * Check for a non-empty result and send
         * the received ads for moderation.
         */
        if ($ads->isNotEmpty()){
            $ads->moderate();
        }

        // End Demo =====================================================================

        sleep(10);

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Ads::class, $ads);
        $this->assertTrue($ads->isNotEmpty());
    }

    /**
     * @depends testAddAds_byService
     * @depends testModerateAds_byService
     *
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testArchiveAds_byService(){
        $session = self::$session;
        $adGroup = self::$textAdGroup;

        // Demo =====================================================================

        /**
         * Getting list of result.
         * @var Result $result
         */
        $result = $session->getAdsService()->query()
            ->select('Id')
            ->whereIn('AdGroupIds', [$adGroup->id])
            ->get();

        /**
         * Convert result to ad collection.
         * @var Ads $ads
         */
        $ads = $result->getResource();

        /**
         * Check for non-empty result and archiving received ads.
         */
        if ($ads->isNotEmpty()){
            $ads->archive();
        }

        // End Demo =====================================================================

        sleep(10);

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Ads::class, $ads);
        $this->assertTrue($ads->isNotEmpty());
    }

    /**
     * @depends testAddAds_byService
     * @depends testArchiveAds_byService
     *
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testUnarchiveAds_byService(){
        $session = self::$session;
        $adGroup = self::$textAdGroup;

        // Demo =====================================================================

        /**
         * Getting list of result.
         * @var Result $result
         */
        $result = $session->getAdsService()->query()
            ->select('Id')
            ->whereIn('AdGroupIds', [$adGroup->id])
            ->whereIn('States', ['ARCHIVED'])
            ->get();

        /**
         * Convert result to ad collection.
         * @var Ads $ads
         */
        $ads = $result->getResource();

        /**
         * Check for non-empty result and unarchiving received ads.
         */
        if ($ads->isNotEmpty()){
            $ads->unarchive();
            $ads->resume();
        }

        // End Demo =====================================================================

        sleep(10);

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Ads::class, $ads);
        $this->assertTrue($ads->isNotEmpty());
    }

    /**
     * @depends testAddAds_byService
     * @depends testModerateAds_byService
     *
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testSuspendAds_byService(){
        $session = self::$session;
        $adGroup = self::$textAdGroup;

        // Demo =====================================================================

        /**
         * Getting list of result.
         * @var Result $result
         */
        $result = $session->getAdsService()->query()
            ->select('Id')
            ->whereIn('AdGroupIds', [$adGroup->id])
            ->get();

        /**
         * Convert result to ad collection.
         * @var Ads $ads
         */
        $ads = $result->getResource();

        /**
         * Check for non-empty result and suspend received ads.
         */
        if ($ads->isNotEmpty()){
            $ads->suspend();
        }

        // End Demo =====================================================================

        sleep(10);

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Ads::class, $ads);
        $this->assertTrue($ads->isNotEmpty());
    }

    /**
     * @depends testAddAds_byService
     * @depends testSuspendAds_byService
     *
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testResumeAds_byService(){
        $session = self::$session;
        $adGroup = self::$textAdGroup;

        // Demo =====================================================================

        /**
         * Getting list of result.
         * @var Result $result
         */
        $result = $session->getAdsService()->query()
            ->select('Id')
            ->whereIn('AdGroupIds', [$adGroup->id])
            ->whereIn('States', ['SUSPENDED'])
            ->get();

        /**
         * Convert result to ad collection.
         * @var Ads $ads
         */
        $ads = $result->getResource();

        /**
         * Check for non-empty results and resume
         * advertising on received ads.
         */
        if ($ads->isNotEmpty()){
            $ads->resume();
        }

        // End Demo =====================================================================

        sleep(10);

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Ads::class, $ads);
        $this->assertTrue($ads->isNotEmpty());
    }


    /*
     |-------------------------------------------------------------------------------
     |
     | Update
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddAds_byService
     *
     * @param Ads $ads
     */
    public function testUpdateAds_byService(Ads $ads){
        $session = self::$session;

        // Demo =====================================================================

        /**
         * Get the first ad from the collection.
         * @var Ads $ads - Ad collection
         * @var Ad $ad - Ad model
         */
        $ad = $ads->first();

        /**
         * Edit ad properties.
         * @var Ad $ad
         */
        $ad ->getTextAd()
            ->setTitle('Another first headline')
            ->setTitle2(null) //Remove title2
            ->setText('Another ad text');

        /**
         * Saving changes to Yandex.Direct.
         * @var Result $result
         */
        $result = $session
            ->getAdsService()
            ->update($ad);

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
    }

    /**
     * @depends testAddAds_byService
     *
     * @param Ads $ads
     */
    public function testUpdateAds_byModel(Ads $ads){

        // Demo =====================================================================

        /**
         * Get the first ad from the collection.
         * @var Ads $ads - Ad collection
         * @var Ad $ad - Ad model
         */
        $ad = $ads->first();

        /**
         * Edit ad properties.
         * @var Ad $ad
         */
        $ad->getTextAd()
            ->setTitle('Another first headline')
            ->setTitle2(null) //Remove ad title2
            ->setText(null); //Remove ad text

        /**
         * Saving changes to Yandex.Direct
         * @var Ad $ad
         * @var Result $result
         */
        $result = $ad->update();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Delete
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddAds_byService
     *
     * @param Ads $ads
     */
    public function testDeleteAds(Ads $ads){

        // Demo =====================================================================

        /**
         * @var Ads $ads
         */
        $result = $ads->delete();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
    }

}