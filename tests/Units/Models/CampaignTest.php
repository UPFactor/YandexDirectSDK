<?php

namespace YandexDirectSDKTest\Unit\Models;

use Exception;
use PHPUnit\Framework\TestCase;
use YandexDirectSDK\Collections\AdExtensions;
use YandexDirectSDK\Collections\AdGroups;
use YandexDirectSDK\Collections\AdImages;
use YandexDirectSDK\Collections\Ads;
use YandexDirectSDK\Collections\Campaigns;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Services\AdExtensionsService;
use YandexDirectSDK\Services\AdGroupsService;
use YandexDirectSDK\Services\AdImagesService;
use YandexDirectSDK\Services\AdsService;
use YandexDirectSDK\Services\CampaignsService;
use YandexDirectSDKTest\Helpers\Checklists;
use YandexDirectSDKTest\Helpers\FakeEnvironment;
use YandexDirectSDKTest\Helpers\FakeSession;

class CampaignTest extends TestCase
{
    /**
     * @var Checklists
     */
    public static $checklists;

    public static function setUpBeforeClass():void
    {
        FakeEnvironment::setUp();
        static::$checklists = new Checklists();
    }

    public static function tearDownAfterClass():void
    {
        FakeEnvironment::tearDown();
        static::$checklists = null;

    }

    public function dataProvider(){
        return [
            'CampaignsService' => [
                'provider' => CampaignsService::class,
                'expectedClass' => Campaigns::class,
                'expectedProperties' => 'Base/campaigns/get:result.Campaigns'
            ],
            'AdExtensionsService' => [
                'provider' => AdExtensionsService::class,
                'expectedClass' => AdExtensions::class,
                'expectedProperties' => 'Base/adextensions/get:result.AdExtensions'
            ],
            'AdGroupsService' => [
                'provider' => AdGroupsService::class,
                'expectedClass' => AdGroups::class,
                'expectedProperties' => 'Base/adgroups/get:result.AdGroups'
            ],
            'AdImagesService' => [
                'provider' => AdImagesService::class,
                'expectedClass' => AdImages::class,
                'expectedProperties' => 'Base/adimages/get:result.AdImages'
            ],
            'AdsService' => [
                'provider' => AdsService::class,
                'expectedClass' => Ads::class,
                'expectedProperties' => 'Base/ads/get:result.Ads'
            ]
        ];
    }

    /**
     * @dataProvider dataProvider
     *
     * @param string $provider
     * @param string $expectedClass
     * @param string $expectedProperties
     * @throws RuntimeException
     * @throws Exception
     */
    public function testTransformation($provider, $expectedClass, $expectedProperties)
    {
        $session = FakeSession::init()->fakeApi(true, 'Base');
        $provider = $provider::{'make'}()->setSession($session);

        self::$checklists->checkResource(
            $provider->{'query'}()->get(),
            $expectedClass,
            $expectedProperties
        );
    }
}