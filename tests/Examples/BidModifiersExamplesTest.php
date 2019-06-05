<?php


namespace YandexDirectSDKTest\Examples;


use PHPUnit\Framework\TestCase;
use ReflectionException;
use YandexDirectSDK\Collections\AdGroups;
use YandexDirectSDK\Collections\BidModifiers;
use YandexDirectSDK\Collections\BidModifierSets;
use YandexDirectSDK\Collections\BidModifierToggles;
use YandexDirectSDK\Collections\Campaigns;
use YandexDirectSDK\Components\Data;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\ModelCollectionException;
use YandexDirectSDK\Exceptions\ModelException;
use YandexDirectSDK\Exceptions\RequestException;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Exceptions\ServiceException;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\BidModifier;
use YandexDirectSDK\Models\BidModifierSet;
use YandexDirectSDK\Models\BidModifierToggle;
use YandexDirectSDK\Models\Campaign;
use YandexDirectSDK\Models\DemographicsAdjustment;
use YandexDirectSDK\Models\MobileAdjustment;
use YandexDirectSDK\Models\RegionalAdjustment;
use YandexDirectSDK\Session;

/**
 * Class BidModifiersExamplesTest
 * @package YandexDirectSDKTest\Examples
 */
class BidModifiersExamplesTest extends TestCase
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
        self::$campaignsExTest = $adGroupsExTest::$campaignsExTest;
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
     * @return BidModifiers
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ReflectionException
     */
    public function testAddBidModifiers_byService()
    {
        $session = self::$session;
        $campaign = self::$textCampaign;
        $adGroup = self::$textAdGroup;

        // Demo =====================================================================

        /**
         * Add bid modifiers to Yandex.Direct.
         * @var Session $session
         * @var Campaign $campaign — Campaign model
         * @var Result $result
         */
        $result = $session->getBidModifiersService()->add(
            //Creating BidModifiers collection and adding a BidModifier model to it.
            BidModifiers::make(
                BidModifier::make()
                    ->setCampaignId($campaign->id)
                    ->setDemographicsAdjustment(
                        DemographicsAdjustment::make()
                            ->setGender('GENDER_MALE')
                            ->setAge('AGE_25_34')
                            ->setBidModifier(101)
                    ),
                BidModifier::make()
                    ->setAdGroupId($adGroup->id)
                    ->setMobileAdjustment(
                        MobileAdjustment::make()
                            ->setBidModifier(100)
                    ),
                BidModifier::make()
                    ->setCampaignId($campaign->id)
                    ->setDemographicsAdjustment(
                        DemographicsAdjustment::make()
                            ->setAge('AGE_45_54')
                            ->setBidModifier(140)
                    ),
                BidModifier::make()
                    ->setCampaignId($campaign->id)
                    ->setRegionalAdjustment(
                        RegionalAdjustment::make()
                            ->setRegionId(225)
                            ->setBidModifier(140)
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
         * Convert result to BidModifiers collection.
         * @var BidModifiers $bidModifiers
         */
        $bidModifiers = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(BidModifiers::class, $bidModifiers);

        return $bidModifiers;
    }

    /**
     * @depends testAddBidModifiers_byService
     *
     * @return void;
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testAddBidModifiers_byModel(){
        $session = self::$session;

        /** @var Campaigns $campaigns */
        $campaigns = self::$campaignsExTest->testAddCampaigns_byService();

        /** @var Campaign $campaign */
        $campaign = $campaigns->first();

        // Demo =====================================================================

        /**
         * Create a BidModifier model.
         * @var BidModifier $bidModifier
         */
        $bidModifier = BidModifier::make()
            ->setCampaignId($campaign->id)
            ->setRegionalAdjustment(
                RegionalAdjustment::make()
                    ->setRegionId(225)
                    ->setBidModifier(50)
            );

        /**
         * Associate a BidModifier model with a session.
         * @var Session $session
         */
        $bidModifier->setSession($session);

        /**
         * Add a BidModifier to Yandex.Direct.
         * @var Result $result
         */
        $result = $bidModifier->add();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(BidModifier::class, $bidModifier);
        $this->assertNotNull($bidModifier->id);

        $campaigns->delete();
    }

    /**
     * @depends testAddBidModifiers_byService
     *
     * @return void
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     */
    public function testAddBidModifiers_byCollection()
    {
        $session = self::$session;

        /** @var Campaigns $campaigns */
        $campaigns = self::$campaignsExTest->testAddCampaigns_byService();

        /** @var Campaign $campaign */
        $campaign = $campaigns->first();

        // Demo =====================================================================

        /**
         * Create a BidModifiers collection.
         * @var BidModifiers $bidModifiers
         */
        $bidModifiers = BidModifiers::make(
            BidModifier::make()
                ->setCampaignId($campaign->id)
                ->setDemographicsAdjustment(
                    DemographicsAdjustment::make()
                        ->setGender('GENDER_MALE')
                        ->setAge('AGE_25_34')
                        ->setBidModifier(101)
                ),
            BidModifier::make()
                ->setCampaignId($campaign->id)
                ->setDemographicsAdjustment(
                    DemographicsAdjustment::make()
                        ->setAge('AGE_45_54')
                        ->setBidModifier(140)
                )
        );

        /**
         * Associate a BidModifiers collection with a session.
         * @var Session $session
         */
        $bidModifiers->setSession($session);

        /**
         * Add a BidModifiers to Yandex.Direct.
         * @var Result $result
         */
        $result = $bidModifiers->add();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(BidModifiers::class, $bidModifiers);
        $this->assertNotNull($bidModifiers->first()->getPropertyValue('id'));

        $campaigns->delete();
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | get
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddBidModifiers_byService
     *
     * @return BidModifiers
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testGetBidModifiers_byService()
    {
        $session = self::$session;
        $campaign = self::$textCampaign;

        // Demo =====================================================================

        /**
         * Getting a list of result.
         * @var Session $session
         * @var Campaign $campaign
         * @var Result $result
         */
        $result = $session->getBidModifiersService()->query()
            ->select(
                'Id',
                'CampaignId',
                'Level',
                'DemographicsAdjustment.BidModifier',
                'DemographicsAdjustment.Enabled'
            )
            ->whereIn('Levels', ['CAMPAIGN', 'AD_GROUP'])
            ->whereIn('CampaignIds', [$campaign->id])
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
         * Convert result to BidModifiers collection.
         * @var BidModifiers $bidModifiers
         */
        $bidModifiers = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(BidModifiers::class, $bidModifiers);

        return $bidModifiers;
    }

    /**
     * @depends testAddBidModifiers_byService
     *
     * @return BidModifiers
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testGetBidModifiers_byModel()
    {
        $session = self::$session;
        $campaign = self::$textCampaign;

        // Demo =====================================================================

        /**
         * Getting a list of result.
         * @var Session $session
         * @var Campaign $campaign
         * @var Result $result
         */
        $result = BidModifier::make()->setSession($session)->query()
            ->select(
                'Id',
                'CampaignId',
                'Level',
                'DemographicsAdjustment.BidModifier',
                'DemographicsAdjustment.Enabled'
            )
            ->whereIn('Levels', ['CAMPAIGN', 'AD_GROUP'])
            ->whereIn('CampaignIds', [$campaign->id])
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
         * Convert result to BidModifiers collection.
         * @var BidModifiers $bidModifiers
         */
        $bidModifiers = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(BidModifiers::class, $bidModifiers);

        return $bidModifiers;
    }

    /**
     * @depends testAddBidModifiers_byService
     *
     * @return BidModifiers
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws RuntimeException
     */
    public function testGetBidModifiers_byCollection()
    {
        $session = self::$session;
        $campaign = self::$textCampaign;

        // Demo =====================================================================

        /**
         * Getting a list of result.
         * @var Session $session
         * @var Campaign $campaign
         * @var Result $result
         */
        $result = BidModifiers::make()->setSession($session)->query()
            ->select(
                'Id',
                'CampaignId',
                'Level',
                'DemographicsAdjustment.BidModifier',
                'DemographicsAdjustment.Enabled'
            )
            ->whereIn('Levels', ['CAMPAIGN', 'AD_GROUP'])
            ->whereIn('CampaignIds', [$campaign->id])
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
         * Convert result to BidModifiers collection.
         * @var BidModifiers $bidModifiers
         */
        $bidModifiers = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(BidModifiers::class, $bidModifiers);

        return $bidModifiers;
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | set
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testGetBidModifiers_byService
     *
     * @param BidModifiers $bidModifiers
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ServiceException
     */
    public function testSetBidModifiers_byService(BidModifiers $bidModifiers)
    {
        $session = self::$session;
        $bidModifiersIds = $bidModifiers->extract('id');

        // Demo =====================================================================

        /**
         * Change the value of the bid modifier by ID [$bidModifiersIds].
         *
         * @var Session $session
         * @var array $bidModifiersIds
         * @var Result $result
         */
        $result = $session
            ->getBidModifiersService()
            ->set($bidModifiersIds, 100);

        /**
         * Convert result to BidModifierSets collection.
         *
         * @var Result $result
         * @var BidModifierSets $bidModifierSets
         */
        $bidModifierSets = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(BidModifierSets::class, $bidModifierSets);
    }

    /**
     * @depends testGetBidModifiers_byService
     *
     * @param BidModifiers $bidModifiers
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ServiceException
     */
    public function testSetBidModifiers_useBidModifierSets_byService(BidModifiers $bidModifiers)
    {
        $session = self::$session;
        $bidModifiersIds = $bidModifiers->extract('id');

        $this->assertCount(4, $bidModifiersIds);

        // Demo =====================================================================

        /**
         * Change the value of the bid modifiers by ID [$bidModifiersIds].
         * To make changes, use the collection of models - BidModifierSets.
         *
         * @var Session $session
         * @var array $bidModifiersIds
         * @var Result $result
         */
        $result = $session
            ->getBidModifiersService()
            ->set(
                BidModifierSets::make(
                    BidModifierSet::make()
                        ->setId($bidModifiersIds[0])
                        ->setBidModifier(100),
                    BidModifierSet::make()
                        ->setId($bidModifiersIds[1])
                        ->setBidModifier(150)
                )
            );

        /**
         * Convert result to BidModifierSets collection.
         *
         * @var Result $result
         * @var BidModifierSets $bidModifierSets
         */
        $bidModifierSets = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(BidModifierSets::class, $bidModifierSets);
    }

    /**
     * @depends testGetBidModifiers_byService
     *
     * @param BidModifiers $bidModifiers
     */
    public function testSetBidModifiers_byModel(BidModifiers $bidModifiers)
    {
        /** @var BidModifier $bidModifier */
        $bidModifier = $bidModifiers->first();

        // Demo =====================================================================

        /**
         * Change the value of the bid modifiers for model.
         *
         * @var BidModifier $bidModifier
         * @var Result $result
         */
        $result = $bidModifier->set(100);

        /**
         * Convert result to BidModifierSets collection.
         *
         * @var Result $result
         * @var BidModifierSets $bidModifierSets
         */
        $bidModifierSets = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(BidModifierSets::class, $bidModifierSets);
    }

    /**
     * @depends testGetBidModifiers_byService
     *
     * @param BidModifiers $bidModifiers
     */
    public function testSetBidModifiers_byCollection(BidModifiers $bidModifiers)
    {
        // Demo =====================================================================

        /**
         * Change the value of bid modifiers for each model in the collection [$bidModifiers].
         *
         * @var BidModifiers $bidModifiers
         * @var Result $result
         */
        $result = $bidModifiers->set(100);

        /**
         * Convert result to BidModifierSets collection.
         *
         * @var Result $result
         * @var BidModifierSets $bidModifierSets
         */
        $bidModifierSets = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(BidModifierSets::class, $bidModifierSets);
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | toggle
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddBidModifiers_byService
     *
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function testToggleBidModifiers_byService()
    {
        $session = self::$session;
        $campaign = self::$textCampaign;

        // Demo =====================================================================

        /**
         * Turn off the set of bid modifiers with types DEMOGRAPHICS_ADJUSTMENT
         * and  REGIONAL_ADJUSTMENT for a given campaign [$campaign].
         *
         * @var Session $session
         * @var Campaign $campaign
         * @var Result $result
         */
        $result = $session->getBidModifiersService()->toggle(
            BidModifierToggles::make(
                BidModifierToggle::make()
                    ->setCampaignId($campaign->id)
                    ->setType('DEMOGRAPHICS_ADJUSTMENT')
                    ->setEnabled('NO'),
                BidModifierToggle::make()
                    ->setCampaignId($campaign->id)
                    ->setType('REGIONAL_ADJUSTMENT')
                    ->setEnabled('NO')
            )
        );

        /**
         * Convert result to BidModifierToggles collection.
         *
         * @var Result $result
         * @var BidModifierToggles $bidModifierToggles
         */
        $bidModifierToggles = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(BidModifierToggles::class, $bidModifierToggles);
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | delete
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddBidModifiers_byService
     *
     * @return void
     */
    public function testDeleteBidModifiers(BidModifiers $bidModifiers)
    {

        // Demo =====================================================================

        /**
         * Remove bid modifiers for all models in the collection [$bidModifiers].
         *
         * @var BidModifiers $bidModifiers
         * @var Result $result
         */
        $result = $bidModifiers->delete();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
    }
}