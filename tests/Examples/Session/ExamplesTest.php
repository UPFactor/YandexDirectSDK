<?php

namespace YandexDirectSDKTest\Examples\Session;

use PHPUnit\Framework\TestCase;
use YandexDirectSDK\Collections\Campaigns;
use YandexDirectSDK\Session;
use YandexDirectSDKTest\Examples\Campaigns\CreateExamplesTest;
use YandexDirectSDKTest\Helpers\Checklists;
use YandexDirectSDKTest\Helpers\Env;

class ExamplesTest extends TestCase
{
    /**
     * @var Campaigns
     */
    private static $campaigns;

    /*
     |-------------------------------------------------------------------------------
     |
     | Handlers
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * Constructor
     * @return void
     */
    public static function setUpBeforeClass(): void
    {
        Env::setUpSession();

        static::$campaigns = Campaigns::wrap([
            CreateExamplesTest::createTextCampaign_HighestPosition_MaximumCoverage(),
            CreateExamplesTest::createTextCampaign_WbMaximumClicks_NetworkDefault()
        ]);
    }

    /**
     * Destructor
     * @return void
     */
    public static function tearDownAfterClass(): void
    {
        static::$campaigns->delete();
        static::$campaigns = null;
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Examples
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @test
     * @return void
     */
    public static function init():void
    {
        Session::init('Your OAuth token');

        // [ Post processing ]

        Checklists::checkArray(Session::fetch(), [
            'token' => 'string:Your OAuth token'
        ]);
    }

    /**
     * @test
     * @return void
     */
    public static function init_WithOptions():void
    {
        Session::init('Your OAuth token', [
            'sandbox' => true,
            'language' => 'ru'
        ]);

        // [ Post processing ]

        Checklists::checkArray(Session::fetch(), [
            'token' => 'string:Your OAuth token',
            'sandbox' => 'boolean',
            'language' => 'string:ru'
        ]);
    }
}