<?php


namespace YandexDirectSDKTest\Examples\Creatives;

use PHPUnit\Framework\TestCase;
use YandexDirectSDK\Collections\Creatives;
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
    public function testGetCreatives()
    {
        $session = self::$session;

        // DEMO =====================================================================

        /**
         * @var Session $session
         * @var Result $result
         */
        $result = Creatives::make()->setSession($session)->query()
            ->select([
                'Id',
                'Type',
                'Name',
                'VideoExtensionCreative.Duration',
                'CpcVideoCreative.Duration'
            ])
            ->whereIn('Types', ['VIDEO_EXTENSION_CREATIVE','CPC_VIDEO_CREATIVE'])
            ->limit(10)
            ->get();

        // ==========================================================================

        self::$checklists->checkResource($result, Creatives::class);

        $result = Creatives::make()->setSession(self::$fakeSession)->query()
            ->select('Id')
            ->limit(10)
            ->get();

        self::$checklists->checkResource($result, Creatives::class, [
            'Id' => 'integer',
            'Type' => 'string',
            'Name' => 'string',
            'PreviewUrl' => 'string',
            'Width' => 'integer',
            'Height' => 'integer',
            'ThumbnailUrl' => 'string',
            'Associated' => 'string',
            'VideoExtensionCreative' => 'array',
            'VideoExtensionCreative.Duration' => 'integer',
            'CpcVideoCreative' => 'array',
            'CpcVideoCreative.Duration' => 'integer',
            'CpmVideoCreative' => 'array',
            'CpmVideoCreative.Duration' => 'integer'
        ]);
    }
}