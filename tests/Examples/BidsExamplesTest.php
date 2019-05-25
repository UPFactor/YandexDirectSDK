<?php


namespace YandexDirectSDKTest\Examples;


use PHPUnit\Framework\TestCase;
use YandexDirectSDK\Collections\AdGroups;
use YandexDirectSDK\Collections\Bids;
use YandexDirectSDK\Collections\BidsAuto;
use YandexDirectSDK\Collections\Campaigns;
use YandexDirectSDK\Components\Data;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\ModelCollectionException;
use YandexDirectSDK\Exceptions\RequestException;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Exceptions\ServiceException;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\Bid;
use YandexDirectSDK\Models\BidAuto;
use YandexDirectSDK\Models\Campaign;
use YandexDirectSDK\Session;

class BidsExamplesTest extends TestCase
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
     * @var AdGroup
     */
    public static $textAdGroupAlt;

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
        self::$textAdGroupAlt = self::$textAdGroup->copy();
        self::$textAdGroupAlt->add();
        self::$textAdGroupAlt->addRelatedKeywords(self::$textAdGroups->getRelatedKeywords(['Keyword'])->getResource());
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
     | Set
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @return Bids
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws RequestException
     */
    public function testSetBids_byService(){
        $session = self::$session;
        $adGroup = self::$textAdGroup;

        // Demo =====================================================================

        /**
         * Create bid model for group [$adGroup]
         * @var Bid $bid
         */
        $bid = Bid::make()
            ->setAdGroupId($adGroup->id)
            ->setBid(3000000)
            ->setContextBid(2000000);

        /**
         * Set bid [$bid] for group in Yandex.Direct
         * @var Session $session
         * @var Bid $bid
         * @var Result $result
         */
        $result = $session->getBidsService()->set($bid);

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
         * Convert result to bid collection.
         * @var Bids $bids
         */
        $bids = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(Bids::class, $bids);

        return $bids;
    }

    /**
     * @depends testSetBids_byService
     *
     * @return void
     */
    public function testSetBids_byModel(){
        $session = self::$session;
        $adGroup = self::$textAdGroup;

        // Demo =====================================================================

        /**
         * Create bid model for group [$adGroup]
         * @var Bid $bid
         */
        $bid = Bid::make()
            ->setAdGroupId($adGroup->id)
            ->setBid(3000000)
            ->setContextBid(2000000);

        /**
         * Associate a bid model with a session.
         * @var Bid $bid
         * @var Session $session
         */
        $bid->setSession($session);

        /**
         * Set bid [$bid] for group in Yandex.Direct
         * @var Result $result
         */
        $result = $bid->set();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Bid::class, $bid);
    }

    /**
     * @depends testSetBids_byService
     *
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testSetBids_byCollection(){
        $session = self::$session;
        $firstAdGroup = self::$textAdGroup;
        $secondAdGroup = self::$textAdGroupAlt;

        // Demo =====================================================================

        /**
         * Create a collection of bid models for
         * different groups: [$firstAdGroup] and [$secondAdGroup].
         * @var Bids $bids
         */
        $bids = Bids::make(
            Bid::make()
                ->setAdGroupId($firstAdGroup->id)
                ->setBid(3000000)
                ->setContextBid(2000000),
            Bid::make()
                ->setAdGroupId($secondAdGroup->id)
                ->setBid(3000000)
                ->setContextBid(2000000)
        );

        /**
         * Associate a collection of bids with a session.
         * @var Bids $bids
         * @var Session $session
         */
        $bids->setSession($session);

        /**
         * Set bids in Yandex.Direct
         * @var Bids $bids
         * @var Result $result
         */
        $result = $bids->set();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Bids::class, $bids);
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Set Auto
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @return BidsAuto
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ServiceException
     */
    public function testSetAutoBids_byService(){
        $session = self::$session;
        $adGroup = self::$textAdGroup;

        // Demo =====================================================================

        /**
         * Create a bid constructor model for ad group [$adGroup].
         * @var BidAuto $bidAuto
         */
        $bidAuto = BidAuto::make()
            ->setAdGroupId($adGroup->id)
            ->setMaxBid(3000000)
            ->setScope(['SEARCH'])
            ->setPosition('PREMIUMBLOCK');

        /**
         * Starting the process of automatically setting bids
         * for the group in Yandex.Direct.
         * @var Session $session
         * @var BidAuto $bidAuto
         * @var Result $result
         */
        $result = $session->getBidsService()->setAuto($bidAuto);

        /**
         * Convert result to bidsAuto collection.
         * @var BidsAuto $bidsAuto
         */
        $bidsAuto = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(BidsAuto::class, $bidsAuto);

        return $bidsAuto;
    }

    /**
     * @depends testSetBids_byService
     *
     * @return void
     */
    public function testSetAutoBids_byModel(){
        $session = self::$session;
        $adGroup = self::$textAdGroup;

        // Demo =====================================================================

        /**
         * Create a bid constructor model for ad group [$adGroup].
         * @var BidAuto $bidAuto
         */
        $bidAuto = BidAuto::make()
            ->setAdGroupId($adGroup->id)
            ->setMaxBid(3000000)
            ->setScope(['SEARCH'])
            ->setPosition('PREMIUMBLOCK');

        /**
         * Associate a bidAuto model with a session.
         * @var BidAuto $bidAuto
         * @var Session $session
         */
        $bidAuto->setSession($session);

        /**
         * Starting the process of automatically setting bids
         * for the group in Yandex.Direct.
         * @var BidAuto $bidAuto
         * @var Result $result
         */
        $result = $bidAuto->setAuto();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(BidAuto::class, $bidAuto);
    }

    /**
     * @depends testSetBids_byService
     *
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testSetAutoBids_byCollection(){
        $session = self::$session;
        $firstAdGroup = self::$textAdGroup;
        $secondAdGroup = self::$textAdGroupAlt;

        // Demo =====================================================================

        /**
         * Create a bid constructor models for
         * different groups: [$firstAdGroup] and [$secondAdGroup].
         * @var BidsAuto $bidsAuto
         */
        $bidsAuto = BidsAuto::make(
            BidAuto::make()
                ->setAdGroupId($firstAdGroup->id)
                ->setMaxBid(3000000)
                ->setScope(['SEARCH'])
                ->setPosition('PREMIUMBLOCK'),
            BidAuto::make()
                ->setAdGroupId($secondAdGroup->id)
                ->setMaxBid(5000000)
                ->setScope(['SEARCH'])
                ->setPosition('PREMIUMBLOCK')
        );

        /**
         * Starting the process of automatically setting bids
         * for the groups in Yandex.Direct.
         * @var BidsAuto $bidsAuto
         * @var Session $session
         */
        $bidsAuto->setSession($session);

        /**
         * Set bidsAuto collection in Yandex.Direct
         * @var BidsAuto $bidsAuto
         * @var Result $result
         */
        $result = $bidsAuto->setAuto();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(BidsAuto::class, $bidsAuto);
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Get
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testSetBids_byService
     *
     * @return Bids
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testGetBids_byService(){
        $session = self::$session;
        $campaignIds = self::$textCampaigns->extract('id');

        // Demo =====================================================================

        /**
         * Getting a list of result.
         * @var array $campaignIds
         * @var Result $result
         */
        $result = $session->getBidsService()->query()
            ->select(['KeywordId','AdGroupId','Bid','ContextBid'])
            ->whereIn('CampaignIds', $campaignIds)
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
         * Convert result to bids collection.
         * @var Bids $bids
         */
        $bids = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(Bids::class, $bids);

        return $bids;
    }

    /**
     * @depends testSetBids_byService
     *
     * @return Bids
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testGetBids_byModel(){
        $session = self::$session;
        $campaignIds = self::$textCampaigns->extract('id');

        // Demo =====================================================================

        /**
         * Getting a list of result.
         * @var array $campaignIds
         * @var Result $result
         */
        $result = Bid::make()->setSession($session)->query()
            ->select(['KeywordId','AdGroupId','Bid','ContextBid'])
            ->whereIn('CampaignIds', $campaignIds)
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
         * Convert result to bids collection.
         * @var Bids $bids
         */
        $bids = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(Bids::class, $bids);

        return $bids;
    }

    /**
     * @depends testSetBids_byService
     *
     * @return Bids
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws RuntimeException
     */
    public function testGetBids_byCollection(){
        $session = self::$session;
        $campaignIds = self::$textCampaigns->extract('id');

        // Demo =====================================================================

        /**
         * Getting a list of result.
         * @var array $campaignIds
         * @var Result $result
         */
        $result = Bids::make()->setSession($session)->query()
            ->select(['KeywordId','AdGroupId','Bid','ContextBid'])
            ->whereIn('CampaignIds', $campaignIds)
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
         * Convert result to bids collection.
         * @var Bids $bids
         */
        $bids = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(Bids::class, $bids);

        return $bids;
    }
}