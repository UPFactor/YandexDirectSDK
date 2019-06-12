<?php


namespace YandexDirectSDKTest\Examples\Leads;

use PHPUnit\Framework\TestCase;
use YandexDirectSDK\Collections\Leads;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\ModelCollectionException;
use YandexDirectSDK\Exceptions\ModelException;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Session;
use YandexDirectSDKTest\Helpers\Checklists;
use YandexDirectSDKTest\Helpers\FakeSession;
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
     * @var FakeSession
     */
    public static $fakeSession;

    /*
     |-------------------------------------------------------------------------------
     |
     | Handlers
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @throws RuntimeException
     */
    public static function setUpBeforeClass():void
    {
        self::$checklists = new Checklists();
        self::$session = SessionTools::init();
        self::$fakeSession = SessionTools::fake(__DIR__.'/../../Data/Base');
    }

    public static function tearDownAfterClass():void
    {
        self::$checklists = null;
        self::$session = null;
        self::$fakeSession = null;
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Get
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     * @throws RuntimeException
     */
    public function testGetLeads()
    {
        $session = self::$session;

        // DEMO =====================================================================

        /**
         * @var Session $session
         * @var Result $result
         */
        $result = Leads::make()->setSession($session)->query()
            ->select('Id','SubmittedAt','TurboPageId','TurboPageName','Data')
            ->where('DateTimeFrom', date('c', strtotime('2019-01-01')))
            ->where('DateTimeTo', date('c', strtotime('2019-01-31')))
            ->whereIn('TurboPageIds', [234234435, 5656564])
            ->limit(10)
            ->get();

        // ==========================================================================

        self::$checklists->checkResource($result, Leads::class);

        $result =Leads::make()->setSession(self::$fakeSession)->query()
            ->select('Id')
            ->limit(10)
            ->get();

        self::$checklists->checkResource($result, Leads::class, [
            'Id' => 'integer',
            'SubmittedAt' => 'string',
            'TurboPageId' => 'string',
            'TurboPageName' => 'string',
            'Data' => 'array',
            'Data.0.Name' => 'string',
            'Data.0.Value' => 'string'
        ]);
    }
}