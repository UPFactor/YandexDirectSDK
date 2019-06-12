<?php


namespace YandexDirectSDKTest\Examples\BidModifiers;

use PHPUnit\Framework\TestCase;
use ReflectionException;
use YandexDirectSDK\Collections\BidModifiers;
use YandexDirectSDK\Collections\BidModifierSets;
use YandexDirectSDK\Collections\BidModifierToggles;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\ModelCollectionException;
use YandexDirectSDK\Exceptions\ModelException;
use YandexDirectSDK\Exceptions\RequestException;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Exceptions\ServiceException;
use YandexDirectSDK\Interfaces\ModelCollection as ModelCollectionInterface;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\BidModifier;
use YandexDirectSDK\Models\BidModifierSet;
use YandexDirectSDK\Models\BidModifierToggle;
use YandexDirectSDK\Models\Campaign;
use YandexDirectSDK\Models\DemographicsAdjustment;
use YandexDirectSDK\Models\MobileAdjustment;
use YandexDirectSDK\Models\RegionalAdjustment;
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
     * @return BidModifiers|ModelCollectionInterface
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     * @throws RuntimeException
     * @throws ReflectionException
     * @throws RequestException
     */
    public function testAddBidModifiers()
    {
        $session = self::$session;
        $adGroup = self::$textAdGroup_HighestPosition;
        $campaign = $session->getCampaignsService()->find($adGroup->campaignId, ['Id', 'Name']);

        // DEMO =====================================================================

        /**
         * @var Campaign $campaign
         * @var AdGroup $adGroup
         * @var Session $session
         * @var Result $result
         */
        $result = $session->getBidModifiersService()->add(
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

        // ==========================================================================

        return self::$checklists->checkResource($result, BidModifiers::class, ['Id' => 'integer']);
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | get
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddBidModifiers
     *
     * @throws InvalidArgumentException
     * @throws ModelException
     * @throws RuntimeException
     */
    public function testGetBidModifiers()
    {
        $session = self::$session;
        $adGroup = self::$textAdGroup_HighestPosition;

        // DEMO =====================================================================

        /**
         * @var Result $result
         * @var Session $session
         * @var AdGroup $adGroup
         */
        $result = $session->getBidModifiersService()->query()
            ->select(
                'Id',
                'AdGroupId',
                'Level',
                'MobileAdjustment.BidModifier',
                'MobileAdjustment.OperatingSystemType'
            )
            ->whereIn('Levels', ['CAMPAIGN', 'AD_GROUP'])
            ->whereIn('AdGroupIds', $adGroup->id)
            ->get();

        // ==========================================================================

        self::$checklists->checkResource($result, BidModifiers::class, [
            'Id' => 'integer',
            'AdGroupId' => 'integer',
            'Level' => 'string',
            'MobileAdjustment' => 'array',
            'MobileAdjustment.BidModifier' => 'integer',
        ]);
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
     * @param BidModifiers $bidModifiers
     * @throws InvalidArgumentException
     * @throws ModelException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ServiceException
     */
    public function testSetBidModifiers(BidModifiers $bidModifiers)
    {
        $session = self::$session;
        $bidModifierIds = $bidModifiers->extract('id');

        // DEMO =====================================================================

        /**
         * @var array $bidModifierIds
         * @var Session $session
         * @var Result $result
         */
        $result = $session
            ->getBidModifiersService()
            ->set($bidModifierIds, 100);

        // ==========================================================================

        self::$checklists->checkResource($result, BidModifierSets::class);
    }

    /**
     * @depends testAddBidModifiers
     *
     * @param BidModifiers $bidModifiers
     * @throws InvalidArgumentException
     * @throws ModelException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ServiceException
     * @throws ModelCollectionException
     */
    public function testSetBidModifiers_BidModifierSets(BidModifiers $bidModifiers)
    {
        $session = self::$session;
        $bidModifierIds = $bidModifiers->extract('id');

        // DEMO =====================================================================

        /**
         * @var array $bidModifierIds
         * @var Session $session
         * @var Result $result
         */
        $result = $session
            ->getBidModifiersService()
            ->set(
                BidModifierSets::make(
                    BidModifierSet::make()
                        ->setId($bidModifierIds[0])
                        ->setBidModifier(100),
                    BidModifierSet::make()
                        ->setId($bidModifierIds[1])
                        ->setBidModifier(150)
                )
            );

        // ==========================================================================

        self::$checklists->checkResource($result, BidModifierSets::class);
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | toggle
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddBidModifiers
     *
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function testToggleBidModifiers()
    {
        $session = self::$session;
        $adGroup = self::$textAdGroup_HighestPosition;
        $campaign = $session->getCampaignsService()->find($adGroup->campaignId, ['Id', 'Name']);

        // DEMO =====================================================================

        /**
         * @var Result $result
         * @var Campaign $campaign
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

        // ==========================================================================

        self::$checklists->checkResource($result, BidModifierToggles::class);
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
     * @param BidModifiers $bidModifiers
     * @throws ModelException
     */
    public function testDeleteBidModifiers(BidModifiers $bidModifiers)
    {
        $session = self::$session;
        $bidModifierIds = $bidModifiers->extract('id');

        // DEMO =====================================================================

        /**
         * @var array $bidModifierIds
         * @var Session $session
         * @var Result $result
         */
        $result = $session
            ->getBidModifiersService()
            ->delete($bidModifierIds);

        // ==========================================================================

        self::$checklists->checkResource($result, null);
    }
}