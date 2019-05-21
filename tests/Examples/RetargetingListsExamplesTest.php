<?php


namespace YandexDirectSDKTest\Examples;


use PHPUnit\Framework\TestCase;
use YandexDirectSDK\Collections\RetargetingListRuleArguments;
use YandexDirectSDK\Collections\RetargetingListRules;
use YandexDirectSDK\Collections\RetargetingLists;
use YandexDirectSDK\Components\Data;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\ModelCollectionException;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Models\RetargetingList;
use YandexDirectSDK\Models\RetargetingListRule;
use YandexDirectSDK\Models\RetargetingListRuleArgument;
use YandexDirectSDK\Session;
use YandexDirectSDKTest\Helpers\SessionTools;

class RetargetingListsExamplesTest extends TestCase
{
    /**
     * @var Session
     */
    protected static $session;

    public static function setUpBeforeClass():void
    {
        self::$session = SessionTools::init();
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Add
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @return RetargetingLists
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testAddRetargetingLists_byService(){
        $session = self::$session;

        // Demo =====================================================================

        /**
         * Add a retargeting list to Yandex.Direct.
         * @var Session $session
         * @var Result $result
         */
        $result = $session->getRetargetingListsService()->add(
            //Creating collection and adding a RetargetingList model to it.
            RetargetingLists::make(
                //Creating RetargetingList model and setting its properties.
                //You can add more RetargetingList model to the collection.
                RetargetingList::make()
                    ->setName('MyRetargetingList')
                    ->setType('RETARGETING')
                    ->setRules(
                        RetargetingListRules::make(
                            RetargetingListRule::make()
                                ->setArguments(
                                    RetargetingListRuleArguments::make(
                                        RetargetingListRuleArgument::make()
                                            ->setExternalId(738527)
                                            ->setMembershipLifeSpan(30),
                                        RetargetingListRuleArgument::make()
                                            ->setExternalId(836452)
                                            ->setMembershipLifeSpan(10)
                                    )
                                )
                                ->setOperator('ALL')
                        )
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
         * Convert result to retargeting list collection.
         * @var RetargetingLists $retargetingLists
         */
        $retargetingLists = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(RetargetingLists::class, $retargetingLists);

        return $retargetingLists;
    }

    /**
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testAddRetargetingLists_byModel(){
        $session = self::$session;

        // Demo =====================================================================

        /**
         * Create a RetargetingList model.
         * @var RetargetingList $retargetingList
         */
        $retargetingList = RetargetingList::make()
            ->setName('MyRetargetingList')
            ->setType('RETARGETING')
            ->setRules(
                RetargetingListRules::make(
                    RetargetingListRule::make()
                        ->setArguments(
                            RetargetingListRuleArguments::make(
                                RetargetingListRuleArgument::make()
                                    ->setExternalId(738527)
                                    ->setMembershipLifeSpan(30),
                                RetargetingListRuleArgument::make()
                                    ->setExternalId(836452)
                                    ->setMembershipLifeSpan(10)
                            )
                        )
                        ->setOperator('ALL')
                )
            );

        /**
         * Associate a RetargetingList model with a session.
         * @var Session $session
         */
        $retargetingList->setSession($session);

        /**
         * Add RetargetingList to Yandex.Direct.
         * @var Result $result
         */
        $result = $retargetingList->add();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(RetargetingList::class, $retargetingList);
        $this->assertNotNull($retargetingList->id);
    }

    /**
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testAddRetargetingLists_byCollection(){
        $session = self::$session;

        // Demo =====================================================================

        /**
         * Create a RetargetingLists collection.
         * @var RetargetingLists $retargetingLists
         */
        $retargetingLists = RetargetingLists::make(
            //Creating RetargetingList model and setting its properties.
            //You can add more RetargetingList model to the collection.
            RetargetingList::make()
                ->setName('MyRetargetingList')
                ->setType('RETARGETING')
                ->setRules(
                    RetargetingListRules::make(
                        RetargetingListRule::make()
                            ->setArguments(
                                RetargetingListRuleArguments::make(
                                    RetargetingListRuleArgument::make()
                                        ->setExternalId(738527)
                                        ->setMembershipLifeSpan(30),
                                    RetargetingListRuleArgument::make()
                                        ->setExternalId(836452)
                                        ->setMembershipLifeSpan(10)
                                )
                            )
                            ->setOperator('ALL')
                    )
                )
        );

        /**
         * Associate a RetargetingLists collection with a session.
         * @var Session $session
         */
        $retargetingLists->setSession($session);

        /**
         * Add RetargetingLists to Yandex.Direct.
         * @var Result $result
         */
        $result = $retargetingLists->add();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(RetargetingLists::class, $retargetingLists);
        $this->assertNotNull($retargetingLists->first()->{'id'});
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Get
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddRetargetingLists_byService
     *
     * @return RetargetingLists
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testGetRetargetingLists_byService(){
        $session = self::$session;

        // Demo =====================================================================

        /**
         * Getting a list of result.
         * @var Result $result
         */
        $result = $session->getRetargetingListsService()->query()
            ->select(['Id','Name','Type','Rules'])
            ->whereIn('Types', ['RETARGETING'])
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
         * Convert result to retargeting list collection.
         * @var RetargetingLists $retargetingLists
         */
        $retargetingLists = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(RetargetingLists::class, $retargetingLists);

        return $retargetingLists;
    }

    /**
     * @depends testAddRetargetingLists_byService
     *
     * @return RetargetingLists
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testGetRetargetingLists_byModel(){
        $session = self::$session;

        // Demo =====================================================================

        /**
         * Getting a list of result.
         * @var Result $result
         */
        $result = RetargetingList::make()->setSession($session)->query()
            ->select(['Id','Name','Type','Rules'])
            ->whereIn('Types', ['RETARGETING'])
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
         * Convert result to retargeting lists collection.
         * @var RetargetingLists $retargetingLists
         */
        $retargetingLists = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(RetargetingLists::class, $retargetingLists);

        return $retargetingLists;
    }

    /**
     * @depends testAddRetargetingLists_byService
     *
     * @return RetargetingLists
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws RuntimeException
     */
    public function testGetRetargetingLists_byCollection(){
        $session = self::$session;

        // Demo =====================================================================

        /**
         * Getting a list of result.
         * @var Result $result
         */
        $result = RetargetingLists::make()->setSession($session)->query()
            ->select(['Id','Name','Type','Rules'])
            ->whereIn('Types', ['RETARGETING'])
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
         * Convert result to retargeting lists collection.
         * @var RetargetingLists $retargetingLists
         */
        $retargetingLists = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(RetargetingLists::class, $retargetingLists);

        return $retargetingLists;
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Update
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddRetargetingLists_byService
     *
     * @param RetargetingLists $retargetingLists
     */
    public function testUpdateRetargetingLists_byService(RetargetingLists $retargetingLists){
        $this->markTestIncomplete('Not implemented');
    }

    /**
     * @depends testAddRetargetingLists_byService
     *
     * @param RetargetingLists $retargetingLists
     */
    public function testUpdateRetargetingLists_byModel(RetargetingLists $retargetingLists){
        $this->markTestIncomplete('Not implemented');
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Delete
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddRetargetingLists_byService
     *
     * @param RetargetingLists $retargetingLists
     */
    public function testDeleteRetargetingLists(RetargetingLists $retargetingLists){
        $this->markTestIncomplete('Not implemented');
    }

}