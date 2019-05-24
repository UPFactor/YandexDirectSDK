<?php


namespace YandexDirectSDKTest\Examples;


use PHPUnit\Framework\TestCase;
use YandexDirectSDK\Collections\AdGroups;
use YandexDirectSDK\Collections\Bids;
use YandexDirectSDK\Collections\BidsAuto;
use YandexDirectSDK\Collections\Campaigns;
use YandexDirectSDK\Collections\Keywords;
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
use YandexDirectSDK\Models\Keyword;
use YandexDirectSDK\Session;

class KeywordsExamplesTest extends TestCase
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
     * @return Keywords
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testAddKeywords_byService(){
        $session = self::$session;
        $adGroup = self::$textAdGroup;

        // Demo =====================================================================

        /**
         * Add keywords in Yandex.Direct.
         *
         * @var Session $session
         * @var AdGroup $adGroup
         * @var Result $result
         */
        $result = $session->getKeywordsService()->add(
            //Creating collection and adding keyword models to it.
            Keywords::make(
                //Creating keyword models and setting its properties.
                Keyword::make()
                    ->setAdGroupId($adGroup->id)
                    ->setKeyword('My keyword')
                    ->setBid(10000000)
                    ->setContextBid(3000000),
                Keyword::make()
                    ->setAdGroupId($adGroup->id)
                    ->setKeyword('My another keyword')
                    ->setBid(10000000)
                    ->setContextBid(3000000)
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
         * Convert result to keyword collection.
         * @var Keywords $keywords
         */
        $keywords = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(Keywords::class, $keywords);

        return $keywords;
    }

    /**
     * @depends testAddKeywords_byService
     *
     * @return void
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testAddKeywords_byCollection(){
        $session = self::$session;
        $adGroup = self::$textAdGroup;

        // Demo =====================================================================

        /**
         * Create keyword collection.
         * @var AdGroup $adGroup
         * @var Keywords $keywords
         */
        $keywords = Keywords::make(
            //Creating keyword models and setting its properties.
            Keyword::make()
                ->setAdGroupId($adGroup->id)
                ->setKeyword('Buy a phone')
                ->setBid(10000000)
                ->setContextBid(3000000),
            Keyword::make()
                ->setAdGroupId($adGroup->id)
                ->setKeyword('Buy iPhone')
                ->setBid(20000000)
                ->setContextBid(3000000)
            );

        /**
         * Associate ad collection with a session.
         * @var Session $session
         */
        $keywords->setSession($session);

        /**
         * Add keywords to Yandex.Direct.
         * @var Result $result
         */
        $result = $keywords->add();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Keywords::class, $keywords);
        $this->assertNotNull($keywords->first()->{'id'});
    }

    /**
     * @depends testAddKeywords_byService
     *
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws RequestException
     */
    public function testAddKeywords_byArray(){
        $session = self::$session;
        $adGroup = self::$textAdGroup;

        // Demo =====================================================================

        /**
         * Add keywords to Yandex.Direct.
         * @var Session $session
         * @var AdGroup $adGroup
         * @var Result $result
         */
        $result = $session->getKeywordsService()->call('add', [
            'Keywords' => [
                [
                    'Keyword' => 'Buy a laptop',
                    'AdGroupId' => $adGroup->id, //Specify ad group for keyword
                    'Bid' => 50000000,
                    'ContextBid' => 10000000
                ],
                [
                    'Keyword' => 'Buy MacBook',
                    'AdGroupId' => $adGroup->id, //Specify ad group for keyword
                    'Bid' => 20000000,
                    'ContextBid' => 30000000
                ]
            ]
        ]);

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

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Get
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddKeywords_byService
     *
     * @return Keywords
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testGetKeywords_byService(){
        $session = self::$session;
        $adGroup = self::$textAdGroup;

        // Demo =====================================================================

        /**
         * Getting a list of result.
         *
         * @var AdGroup $adGroup
         * @var Result $result
         */
        $result = $session->getKeywordsService()->query()
            ->select('Id','Keyword','Bid')
            ->whereIn('AdGroupIds', [$adGroup->id])
            ->limit(10)
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
         * Convert result to keyword collection.
         * @var Keywords $keywords
         */
        $keywords = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(Keywords::class, $keywords);

        return $keywords;
    }

    /**
     * @depends testAddKeywords_byService
     *
     * @return Keywords
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws RuntimeException
     */
    public function testGetKeywords_byCollection(){
        $session = self::$session;
        $adGroup = self::$textAdGroup;

        // Demo =====================================================================

        /**
         * Getting a list of result.
         *
         * @var AdGroup $adGroup
         * @var Result $result
         */
        $result = Keywords::make()->setSession($session)->query()
            ->select('Id','Keyword','Bid')
            ->whereIn('AdGroupIds', [$adGroup->id])
            ->limit(10)
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
         * Convert result to keyword collection.
         * @var Keywords $keywords
         */
        $keywords = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(Keywords::class, $keywords);

        return $keywords;
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Actions
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddKeywords_byService
     *
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testSuspendKeywords_byService(){
        $session = self::$session;
        $adGroup = self::$textAdGroup;

        // Demo =====================================================================

        /**
         * Getting list of result.
         * @var Result $result
         */
        $result = $session->getKeywordsService()->query()
            ->select('Id')
            ->whereIn('AdGroupIds', [$adGroup->id])
            ->get();

        /**
         * Convert result to keyword collection.
         * @var Keywords $keywords
         */
        $keywords = $result->getResource();

        /**
         * Check for non-empty result and suspend received keywords.
         */
        if ($keywords->isNotEmpty()){
            $keywords->suspend();
        }

        // End Demo =====================================================================

        sleep(10);

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Keywords::class, $keywords);
        $this->assertTrue($keywords->isNotEmpty());
    }

    /**
     * @depends testAddKeywords_byService
     * @depends testSuspendKeywords_byService
     *
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testResumeKeywords_byService(){
        $session = self::$session;
        $adGroup = self::$textAdGroup;

        // Demo =====================================================================

        /**
         * Getting list of result.
         * @var Result $result
         */
        $result = $session->getKeywordsService()->query()
            ->select('Id')
            ->whereIn('AdGroupIds', [$adGroup->id])
            ->whereIn('States', ['SUSPENDED'])
            ->get();

        /**
         * Convert result to ad collection.
         * @var Keywords $keywords
         */
        $keywords = $result->getResource();

        /**
         * Check for non-empty results and resume
         * advertising on received keywords.
         */
        if ($keywords->isNotEmpty()){
            $keywords->resume();
        }

        // End Demo =====================================================================

        sleep(10);

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Keywords::class, $keywords);
        $this->assertTrue($keywords->isNotEmpty());
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Related objects
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddKeywords_byService
     *
     * @param Keywords $keywords
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ServiceException
     */
    public function testSetRelatedBids_byService(Keywords $keywords){
        $session = self::$session;
        $keywordsIds = $keywords->extract('id');

        // Demo =====================================================================

        /**
         * Create Bid model
         * @var Bid $bid
         */
        $bid = Bid::make()
            ->setBid(30000000)
            ->setContextBid(10000000);


        /**
         * Set bid for each keyword with ids [$keywordsIds].
         *
         * @var Result $result
         * @var array $keywordsIds
         */
        $result = $session
            ->getKeywordsService()
            ->setRelatedBids($keywordsIds, $bid);

        /**
         * Convert result to Bids collection.
         * @var Bids $bids
         */
        $bids = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Bids::class, $bids);
    }

    /**
     * @depends testAddKeywords_byService
     *
     * @param Keywords $keywords
     */
    public function testSetRelatedBids_byModel(Keywords $keywords){
        $keyword = $keywords->first();

        // Demo =====================================================================

        /**
         * Sets bid for the keyword model [$keyword].
         * @var Result $result
         * @var Keyword $keyword
         */
        $result = $keyword->setRelatedBids(
            Bid::make()
                ->setBid(30000000)
                ->setContextBid(10000000)
        );

        /**
         * Convert result to Bids collection.
         * @var Bids $bids
         */
        $bids = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Bids::class, $bids);
    }

    /**
     * @depends testAddKeywords_byService
     *
     * @param Keywords $keywords
     */
    public function testSetRelatedBids_byCollection(Keywords $keywords){

        // Demo =====================================================================

        /**
         * Set a bid for each keyword in the collection [$keywords].
         *
         * @var Result $result
         * @var Keywords $keywords
         */
        $result = $keywords->setRelatedBids(
            Bid::make()
                ->setBid(30000000)
                ->setContextBid(10000000)
        );

        /**
         * Convert result to Bids collection.
         * @var Bids $bids
         */
        $bids = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Bids::class, $bids);
    }

    /**
     * @depends testAddKeywords_byService
     *
     * @param Keywords $keywords
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ServiceException
     */
    public function testSetRelatedBidsAuto_byService(Keywords $keywords){
        $session = self::$session;
        $keywordsIds = $keywords->extract('id');

        // Demo =====================================================================

        /**
         * Create the bid constructor options model.
         * @var BidAuto $bidAuto
         */
        $bidAuto = BidAuto::make()
            ->setScope(['SEARCH'])
            ->setPosition('PREMIUMBLOCK');

        /**
         * Sets the bid constructor options for for each
         * keyword with ids [$keywordsIds].
         *
         * @var Result $result
         * @var array $keywordsIds
         */
        $result = $session
            ->getKeywordsService()
            ->setRelatedBidsAuto($keywordsIds, $bidAuto);

        /**
         * Convert result to Bids collection.
         * @var BidsAuto $bids
         */
        $bids = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(BidsAuto::class, $bids);
    }

    /**
     * @depends testAddKeywords_byService
     *
     * @param Keywords $keywords
     */
    public function testSetRelatedBidsAuto_byModel(Keywords $keywords){
        $keyword = $keywords->first();

        // Demo =====================================================================

        /**
         * Sets the bid constructor options for keyword model [$keyword].
         *
         * @var Result $result
         * @var Keyword $keyword
         */
        $result = $keyword->setRelatedBidsAuto(
            BidAuto::make()
                ->setScope(['SEARCH'])
                ->setPosition('PREMIUMBLOCK')
        );

        /**
         * Convert result to Bids collection.
         * @var BidsAuto $bids
         */
        $bids = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(BidsAuto::class, $bids);
    }

    /**
     * @depends testAddKeywords_byService
     *
     * @param Keywords $keywords
     */
    public function testSetRelatedBidsAuto_byCollection(Keywords $keywords){

        // Demo =====================================================================

        /**
         * Sets the bid constructor options for each keyword in
         * the collection [$keywords].
         *
         * @var Result $result
         * @var Keywords $keywords
         */
        $result = $keywords->setRelatedBidsAuto(
            BidAuto::make()
                ->setScope(['SEARCH'])
                ->setPosition('PREMIUMBLOCK')
        );

        /**
         * Convert result to Bids collection.
         * @var BidsAuto $bids
         */
        $bids = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(BidsAuto::class, $bids);
    }

    /**
     * @depends testAddKeywords_byService
     *
     * @param Keywords $keywords
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testGetRelatedBids_byService(Keywords $keywords){
        $session = self::$session;
        $keywordsIds = $keywords->extract('id');

        // Demo =====================================================================

        /**
         * Get Bids by keyword ids [$keywordsIds]
         * @var Result $result
         * @var array $keywordsIds
         */
        $result = $session
            ->getKeywordsService()
            ->getRelatedBids($keywordsIds, ['Bid','AdGroupId','CampaignId']);

        /**
         * Convert result to Bids collection.
         * @var Bids $bids
         */
        $bids = $result->getResource();

        // End Demo =====================================================================

        $this->assertIsArray($keywordsIds);
        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Bids::class, $bids);
    }

    /**
     * @depends testAddKeywords_byService
     *
     * @param Keywords $keywords
     */
    public function testGetRelatedBids_byModel(Keywords $keywords){
        $keyword = $keywords->first();

        // Demo =====================================================================

        /**
         * Get Bids by keyword model [$keyword]
         * @var Result $result
         * @var Keyword $keyword
         */
        $result = $keyword->getRelatedBids(['Bid','AdGroupId','CampaignId']);

        /**
         * Convert result to Bids collection.
         * @var Bids $bids
         */
        $bids = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Bids::class, $bids);
    }

    /**
     * @depends testAddKeywords_byService
     *
     * @param Keywords $keywords
     */
    public function testGetRelatedBids_byCollection(Keywords $keywords){

        // Demo =====================================================================

        /**
         * Get Bids for all keywords in the collection [$keywords].
         *
         * @var Result $result
         * @var Keywords $keywords
         */
        $result = $keywords->getRelatedBids(['Bid','AdGroupId','CampaignId']);

        /**
         * Convert result to Bids collection.
         * @var Bids $bids
         */
        $bids = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Bids::class, $bids);
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Update
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddKeywords_byService
     *
     * @param Keywords $keywords
     */
    public function testUpdateKeywords_byService(Keywords $keywords){
        $session = self::$session;

        // Demo =====================================================================

        /**
         * Get the first keyword from the collection.
         * @var Keywords $keywords - keyword collection
         * @var Keyword $keyword - keyword model
         */
        $keyword = $keywords->first();

        /**
         * Edit keyword properties.
         * @var Keyword $keyword
         */
        $keyword->keyword = 'another keyword';

        /**
         * Saving changes to Yandex.Direct.
         * @var Result $result
         */
        $result = $session
            ->getKeywordsService()
            ->update($keyword);

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
    }

    /**
     * @depends testAddKeywords_byService
     *
     * @param Keywords $keywords
     */
    public function testUpdateKeywords_byModel(Keywords $keywords){

        // Demo =====================================================================

        /**
         * Get the first keyword from the collection.
         * @var Keywords $keywords - keyword collection
         * @var Keyword $keyword - keyword model
         */
        $keyword = $keywords->first();

        /**
         * Edit keyword properties and saving changes to Yandex.Direct.
         * @var Keyword $keyword
         * @var Result $result
         */
        $result = $keyword
            ->setKeyword('another keyword')
            ->update();

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
     * @depends testAddKeywords_byService
     *
     * @param Keywords $keywords
     */
    public function testDeleteKeywords(Keywords $keywords){

        // Demo =====================================================================

        /**
         * @var Keywords $keywords
         */
        $result = $keywords->delete();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
    }
}