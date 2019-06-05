<?php


namespace YandexDirectSDKTest\Examples;


use PHPUnit\Framework\TestCase;
use YandexDirectSDK\Collections\AdGroups;
use YandexDirectSDK\Collections\Campaigns;
use YandexDirectSDK\Collections\WebpageBids;
use YandexDirectSDK\Collections\WebpageConditions;
use YandexDirectSDK\Collections\Webpages;
use YandexDirectSDK\Components\Data;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\ModelCollectionException;
use YandexDirectSDK\Exceptions\ModelException;
use YandexDirectSDK\Exceptions\RequestException;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Exceptions\ServiceException;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\Campaign;
use YandexDirectSDK\Models\Webpage;
use YandexDirectSDK\Models\WebpageBid;
use YandexDirectSDK\Models\WebpageCondition;
use YandexDirectSDK\Session;

/**
 * Class BidModifiersExamplesTest
 * @package YandexDirectSDKTest\Examples
 */
class DynamicTextAdTargetsExamplesTest extends TestCase
{
    /**
     * @var AdGroupsExamplesTest
     */
    public static $adGroupsExTest;

    /**
     * @var CampaignsExamplesTest
     */
    public static $campaignsExTest;

    /**
     * @var Session
     */
    public static $session;

    /**
     * @var AdGroups
     */
    public static $dynamicAdGroups;

    /**
     * @var AdGroup
     */
    public static $dynamicAdGroup;

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
        self::$campaignsExTest = $adGroupsExTest::$campaignsExTest;
        self::$session = $adGroupsExTest::$session;
        self::$textCampaigns = $adGroupsExTest::$textCampaigns;
        self::$textCampaign = $adGroupsExTest::$textCampaign;
        self::$dynamicAdGroups = $adGroupsExTest->testAddDynamicTextAdGroup_byService();
        self::$dynamicAdGroup = self::$dynamicAdGroups->first();
    }

    public static function tearDownAfterClass():void
    {
        self::$adGroupsExTest::tearDownAfterClass();

        self::$adGroupsExTest = null;
        self::$session = null;
        self::$textCampaigns = null;
        self::$textCampaign = null;
        self::$dynamicAdGroups = null;
        self::$dynamicAdGroup = null;
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Add
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @return Webpages
     *
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     */
    public function testAddWebpages_byService()
    {
        $session = self::$session;
        $adGroup = self::$dynamicAdGroup;

        // Demo =====================================================================

        /**
         * Creates targeting conditions for dynamic ads, sets
         * priorities for created conditions.
         *
         * @var Session $session
         * @var AdGroup $adGroup — Ad group model
         * @var Result $result
         */
        $result = $session->getDynamicTextAdTargetsService()->add(
            Webpages::make(
                Webpage::make()
                    ->setName('Name of the targeting condition')
                    ->setAdGroupId($adGroup->id)
                    ->setConditions(
                        WebpageConditions::make(
                            WebpageCondition::urlContain(['yandex.ru','direct']),
                            WebpageCondition::pageTitleContain(['API','SDK'])
                        )
                    )
                    ->setStrategyPriority('LOW')
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
         * Convert result to BidModifiers collection.
         * @var Webpages $webpages
         */
        $webpages = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(Webpages::class, $webpages);
        $this->assertNotNull($webpages->first()->getPropertyValue('id'));

        return $webpages;
    }

    /**
     * @depends testAddWebpages_byService
     *
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testAddWebpages_byModel(){
        $session = self::$session;
        $adGroup = self::$dynamicAdGroup;

        // Demo =====================================================================

        /**
         * Create a Webpage model.
         * @var Webpage $webpage
         */
        $webpage = Webpage::make()
            ->setName('Name of the targeting condition')
            ->setAdGroupId($adGroup->id)
            ->setConditions(
                WebpageConditions::make(
                    WebpageCondition::domainContain(['mysite.com']),
                    WebpageCondition::pageNotContain(['home','main'])
                )
            )
            ->setStrategyPriority('LOW');

        /**
         * Associate a Webpage model with a session.
         *
         * @var Webpage $webpage
         * @var Session $session
         */
        $webpage->setSession($session);

        /**
         * Creates targeting conditions for dynamic ads.
         *
         * @var Webpage $webpage
         * @var Result $result
         */
        $result = $webpage->add();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Webpage::class, $webpage);
        $this->assertNotNull($webpage->id);

        $webpage->delete();
    }

    /**
     * @depends testAddWebpages_byService
     *
     * @return void
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     */
    public function testAddWebpages_byCollection()
    {
        $session = self::$session;
        $adGroup = self::$dynamicAdGroup;

        // Demo =====================================================================

        /**
         * Create a Webpages collection.
         *
         * @var Webpages $webpages
         */
        $webpages = Webpages::make(
            Webpage::make()
                ->setName('Name of the targeting condition')
                ->setAdGroupId($adGroup->id)
                ->setConditions(
                    WebpageConditions::make(
                        WebpageCondition::domainContain(['mysite.com']),
                        WebpageCondition::pageNotContain(['home','main'])
                    )
                )
                ->setStrategyPriority('LOW'),
            Webpage::make()
                ->setName('Other targeting condition')
                ->setAdGroupId($adGroup->id)
                ->setConditions(
                    WebpageConditions::make(
                        WebpageCondition::pageTitleContain(['Home'])
                    )
                )
                ->setStrategyPriority('NORMAL')
        );

        /**
         * Associate a Webpages collection with a session.
         *
         * @var Webpages $webpages
         * @var Session $session
         */
        $webpages->setSession($session);

        /**
         * Creates targeting conditions for dynamic ads.
         *
         * @var Webpages $webpages
         * @var Result $result
         */
        $result = $webpages->add();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Webpages::class, $webpages);
        $this->assertNotNull($webpages->first()->getPropertyValue('id'));
        $this->assertNotNull($webpages->last()->getPropertyValue('id'));

        $webpages->delete();
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | get
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddWebpages_byService
     *
     * @return Webpages
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testGetWebpages_byService()
    {
        $session = self::$session;
        $adGroup = self::$dynamicAdGroup;

        // Demo =====================================================================

        /**
         * Getting a list of result.
         *
         * @var Session $session
         * @var AdGroup $adGroup
         * @var Result $result
         */
        $result = $session->getDynamicTextAdTargetsService()->query()
            ->select([
                'Id',
                'Name',
                'Conditions',
                'StrategyPriority'
            ])
            ->whereIn('AdGroupIds', $adGroup->id)
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
         * Convert result to Webpages collection.
         * @var Webpages $webpages
         */
        $webpages = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertNotEmpty($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(Webpages::class, $webpages);

        return $webpages;
    }

    /**
     * @depends testAddWebpages_byService
     *
     * @return Webpages
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testGetWebpages_byModel()
    {
        $session = self::$session;
        $adGroup = self::$dynamicAdGroup;

        // Demo =====================================================================

        /**
         * Getting a list of result.
         *
         * @var Session $session
         * @var AdGroup $adGroup
         * @var Result $result
         */
        $result = Webpage::make()->setSession($session)->query()
            ->select([
                'Id',
                'Name',
                'Conditions',
                'StrategyPriority'
            ])
            ->whereIn('AdGroupIds', $adGroup->id)
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
         * Convert result to Webpages collection.
         * @var Webpages $webpages
         */
        $webpages = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertNotEmpty($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(Webpages::class, $webpages);

        return $webpages;
    }

    /**
     * @depends testAddWebpages_byService
     *
     * @return Webpages
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws RuntimeException
     */
    public function testGetWebpages_byCollection()
    {
        $session = self::$session;
        $adGroup = self::$dynamicAdGroup;

        // Demo =====================================================================

        /**
         * Getting a list of result.
         *
         * @var Session $session
         * @var AdGroup $adGroup
         * @var Result $result
         */
        $result = Webpages::make()->setSession($session)->query()
            ->select([
                'Id',
                'Name',
                'Conditions',
                'StrategyPriority'
            ])
            ->whereIn('AdGroupIds', $adGroup->id)
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
         * Convert result to Webpages collection.
         * @var Webpages $webpages
         */
        $webpages = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertNotEmpty($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(Webpages::class, $webpages);

        return $webpages;
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Bids
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddWebpages_byService
     *
     * @param Webpages $webpages
     * @throws InvalidArgumentException
     * @throws ModelException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ServiceException
     */
    public function testSetBids_byService(Webpages $webpages)
    {
        $session = self::$session;
        $adGroupId = $webpages->first()->getPropertyValue('adGroupId');

        // Demo =====================================================================

        /**
         * Sets a flat bid/priority to all targeting conditions for
         * dynamic ads in a group. [$adGroupId].
         *
         * @var Session $session
         * @var array $webpagesIds
         * @var Result $result
         */
        $result = $session
            ->getDynamicTextAdTargetsService()
            ->setBids(
                WebpageBid::make()
                    ->setAdGroupId($adGroupId)
                    ->setBid(100000000)
            );

        /**
         * Convert result to WebpageBids collection.
         *
         * @var Result $result
         * @var WebpageBids $webpageBids
         */
        $webpageBids = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertInstanceOf(WebpageBids::class, $webpageBids);
    }

    /**
     * @depends testAddWebpages_byService
     *
     * @param Webpages $webpages
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ServiceException
     */
    public function testSetRelatedBids_byService(Webpages $webpages)
    {
        $session = self::$session;
        $webpagesIds = $webpages->extract('id');

        // Demo =====================================================================

        /**
         * Sets bids for targeting conditions for dynamic ads with ids [$webpagesIds].
         *
         * @var Session $session
         * @var array $webpagesIds
         * @var Result $result
         */
        $result = $session
            ->getDynamicTextAdTargetsService()
            ->setRelatedBids($webpagesIds, 100000000);

        /**
         * Convert result to WebpageBids collection.
         *
         * @var Result $result
         * @var WebpageBids $webpageBids
         */
        $webpageBids = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertInstanceOf(WebpageBids::class, $webpageBids);
    }

    /**
     * @depends testAddWebpages_byService
     *
     * @param Webpages $webpages
     */
    public function testSetRelatedBids_byModel(Webpages $webpages)
    {
        $webpage = $webpages->first();

        // Demo =====================================================================

        /**
         * Sets bids for model Webpage.
         *
         * @var Session $session
         * @var Webpage $webpage
         * @var Result $result
         */
        $result = $webpage->setRelatedBids(100000000);

        /**
         * Convert result to WebpageBids collection.
         *
         * @var Result $result
         * @var WebpageBids $webpageBids
         */
        $webpageBids = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertInstanceOf(WebpageBids::class, $webpageBids);
    }

    /**
     * @depends testAddWebpages_byService
     *
     * @param Webpages $webpages
     */
    public function testSetRelatedBids_byCollection(Webpages $webpages)
    {
        // Demo =====================================================================

        /**
         * Sets bids for each model Webpage in the collection Webpages.
         *
         * @var Session $session
         * @var Webpages $webpages
         * @var Result $result
         */
        $result = $webpages->setRelatedBids(100000000);

        /**
         * Convert result to WebpageBids collection.
         *
         * @var Result $result
         * @var WebpageBids $webpageBids
         */
        $webpageBids = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertInstanceOf(WebpageBids::class, $webpageBids);
    }

    /**
     * @depends testAddWebpages_byService
     *
     * @param Webpages $webpages
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ServiceException
     */
    public function testSetRelatedStrategyPriority_byService(Webpages $webpages)
    {
        $session = self::$session;
        $webpagesIds = $webpages->extract('id');

        // Demo =====================================================================

        /**
         * Sets priority for targeting conditions for dynamic ads with ids [$webpagesIds].
         *
         * @var Session $session
         * @var array $webpagesIds
         * @var Result $result
         */
        $result = $session
            ->getDynamicTextAdTargetsService()
            ->setRelatedStrategyPriority($webpagesIds, 'LOW');

        /**
         * Convert result to WebpageBids collection.
         *
         * @var Result $result
         * @var WebpageBids $webpageBids
         */
        $webpageBids = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(WebpageBids::class, $webpageBids);
    }

    /**
     * @depends testAddWebpages_byService
     *
     * @param Webpages $webpages
     */
    public function testSetRelatedStrategyPriority_byModel(Webpages $webpages)
    {
        $webpage = $webpages->first();

        // Demo =====================================================================

        /**
         * Sets priority for model Webpage.
         *
         * @var Session $session
         * @var Webpage $webpage
         * @var Result $result
         */
        $result = $webpage->setRelatedStrategyPriority('LOW');

        /**
         * Convert result to WebpageBids collection.
         *
         * @var Result $result
         * @var WebpageBids $webpageBids
         */
        $webpageBids = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(WebpageBids::class, $webpageBids);
    }

    /**
     * @depends testAddWebpages_byService
     *
     * @param Webpages $webpages
     */
    public function testSetRelatedStrategyPriority_byCollection(Webpages $webpages)
    {
        // Demo =====================================================================

        /**
         * Sets priority for each model Webpage in the collection Webpages.
         *
         * @var Session $session
         * @var Webpages $webpages
         * @var Result $result
         */
        $result = $webpages->setRelatedStrategyPriority('LOW');

        /**
         * Convert result to WebpageBids collection.
         *
         * @var Result $result
         * @var WebpageBids $webpageBids
         */
        $webpageBids = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(WebpageBids::class, $webpageBids);
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Actions
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddWebpages_byService
     *
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testSuspend_byService(){
        $session = self::$session;
        $adGroup = self::$dynamicAdGroup;

        // Demo =====================================================================

        /**
         * Getting list of result.
         * @var Result $result
         */
        $result = $session->getDynamicTextAdTargetsService()->query()
            ->select('Id')
            ->whereIn('AdGroupIds', [$adGroup->id])
            ->get();

        /**
         * Convert result to Webpages collection.
         * @var Webpages $webpages
         */
        $webpages = $result->getResource();

        /**
         * Check for non-empty result and suspend impressions
         * on targeting conditions for dynamic ads.
         */
        if ($webpages->isNotEmpty()){
            $webpages->suspend();
        }

        // End Demo =====================================================================

        sleep(10);

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Webpages::class, $webpages);
        $this->assertTrue($webpages->isNotEmpty());
    }

    /**
     * @depends testAddWebpages_byService
     * @depends testSuspend_byService
     *
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testResumeAds_byService(){
        $session = self::$session;
        $adGroup = self::$dynamicAdGroup;

        // Demo =====================================================================

        /**
         * Getting list of result.
         * @var Result $result
         */
        $result = $session->getDynamicTextAdTargetsService()->query()
            ->select('Id')
            ->whereIn('AdGroupIds', [$adGroup->id])
            ->whereIn('States', ['SUSPENDED'])
            ->get();

        /**
         * Convert result to Webpages collection.
         * @var Webpages $webpages
         */
        $webpages = $result->getResource();

        /**
         * Check for non-empty result and resume impressions
         * on targeting conditions for dynamic ads.
         */
        if ($webpages->isNotEmpty()){
            $webpages->resume();
        }

        // End Demo =====================================================================

        sleep(10);

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(Webpages::class, $webpages);
        $this->assertTrue($webpages->isNotEmpty());
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | delete
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddWebpages_byService
     *
     * @return void
     */
    public function testDeleteWebpages(Webpages $webpages)
    {

        // Demo =====================================================================

        /**
         * Removes targeting conditions for dynamic ads.
         *
         * @var Webpages $webpages
         * @var Result $result
         */
        $result = $webpages->delete();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
    }
}