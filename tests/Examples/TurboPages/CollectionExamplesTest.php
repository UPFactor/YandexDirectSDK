<?php


namespace YandexDirectSDKTest\Examples\TurboPages;

use PHPUnit\Framework\TestCase;
use YandexDirectSDK\Collections\TurboPages;
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
     * @throws ModelException
     * @throws RuntimeException
     * @throws ModelCollectionException
     */
    public function testGetTurboPages()
    {
        $session = self::$session;

        // DEMO =====================================================================

        /**
         * @var Session $session
         * @var Result $result
         */
        $result = TurboPages::make()->setSession($session)->query()
            ->select('Id','Name','Href','PreviewHref')
            ->limit(10)
            ->get();

        // ==========================================================================

        self::$checklists->checkResource($result, TurboPages::class);

        $result = TurboPages::make()->setSession(self::$fakeSession)->query()
            ->select('Id','Name','Href','PreviewHref')
            ->limit(10)
            ->get();

        self::$checklists->checkResource($result, TurboPages::class, [
            'Id' => 'integer',
            'Name' => 'string',
            'Href' => 'string',
            'PreviewHref' => 'string'
        ]);
    }
}