<?php

namespace YandexDirectSDKTest\Examples\Ads;

use PHPUnit\Framework\TestCase;
use UPTools\Arr;
use YandexDirectSDK\Collections\Ads;
use YandexDirectSDK\Collections\TrackingPixels;
use YandexDirectSDK\Models\Ad;
use YandexDirectSDK\Models\AdBuilderAd;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\Campaign;
use YandexDirectSDK\Models\CpcVideoAdBuilderAd;
use YandexDirectSDK\Models\CpmBannerAdBuilderAd;
use YandexDirectSDK\Models\CpmVideoAdBuilderAd;
use YandexDirectSDK\Models\DynamicTextAd;
use YandexDirectSDK\Models\MobileAppAd;
use YandexDirectSDK\Models\MobileAppAdBuilderAd;
use YandexDirectSDK\Models\MobileAppImageAd;
use YandexDirectSDK\Models\TextAd;
use YandexDirectSDK\Models\TextAdBuilderAd;
use YandexDirectSDK\Models\TextImageAd;
use YandexDirectSDK\Models\TrackingPixel;
use YandexDirectSDKTest\Examples\AdGroups\CreateExamplesTest as AdGroupsCreateExamplesTest;
use YandexDirectSDKTest\Helpers\Checklists;
use YandexDirectSDKTest\Helpers\Env;

class CreateExamplesTest extends TestCase
{
    /**
     * @var AdGroup[]
     */
    private static $adGroups = [];

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
        static::$adGroups = [];
    }

    /**
     * Destructor
     * @return void
     */
    public static function tearDownAfterClass(): void
    {
        Env::setUpSession();

        Campaign::find(Arr::map(static::$adGroups, function(AdGroup $adGroup){
            return $adGroup->campaignId;
        }))->delete();

        static::$adGroups = [];
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Examples
     |
     |-------------------------------------------------------------------------------
    */

    /*
     | Make
     | -------------------------------------------------------------------------------
     */

    /**
     * @test
     * @return void
     */
    public static function makeTextAd():void
    {
        // [ Pre processing ]

        static::$adGroups[] = $adGroup = AdGroupsCreateExamplesTest::createTextGroup_HighestPosition_MaximumCoverage();

        // [ Example ]

        $ad = Ad::make([
            'AdGroupId' => $adGroup->id,
            'TextAd' => [
                'Title' => 'My Title',
                'Title2' => 'My Title2',
                'Text' => 'My ad text',
                'Href' => 'https://mysite.com/page/',
                'Mobile' => 'YES'
            ]
        ]);

        $result = $ad->create();

        // [ Post processing ]

        Checklists::checkResource($result, Ads::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'TextAd' => 'required|array',
            'TextAd.Title' => 'required|string',
            'TextAd.Title2' => 'required|string',
            'TextAd.Text' => 'required|string',
            'TextAd.Mobile' => 'required|string'
        ]);

        Checklists::checkResult(
            $ad->delete()
        );
    }

    /*
     | Create
     | -------------------------------------------------------------------------------
     */

    /**
     * @test
     * @return Ad
     */
    public static function createTextAd():Ad
    {
        // [ Pre processing ]

        static::$adGroups[] = $adGroup = AdGroupsCreateExamplesTest::createTextGroup_HighestPosition_MaximumCoverage();
        $imgLocalPath = Env::getFilesPath('img1080x607.png');

        // [ Example ]

        $ad = Ad::make()
            ->setAdGroupId($adGroup->id)
            ->setTextAd(
                TextAd::make()
                    ->setTitle('My Title')
                    ->setTitle2('My Title2')
                    ->setText('My text')
                    ->setHref('https://mysite.com/page/')
                    ->setMobile('NO')
                    ->setAdImage('TextAd Image', $imgLocalPath)
            );

        $result = $ad->create();

        // [ Post processing ]

        Checklists::checkResource($result, Ads::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'TextAd' => 'required|array',
            'TextAd.Title' => 'required|string',
            'TextAd.Title2' => 'required|string',
            'TextAd.Text' => 'required|string',
            'TextAd.Mobile' => 'required|string',
            'TextAd.AdImageHash' => 'required|string'
        ]);

        return $ad;
    }

    /**
     * @test
     * @return Ad
     */
    public static function createTextImageAd():Ad
    {
        // [ Pre processing ]

        static::$adGroups[] = $adGroup = AdGroupsCreateExamplesTest::createTextGroup_HighestPosition_MaximumCoverage();
        $imgLocalPath = Env::getFilesPath('img240x400.png');

        // [ Example ]

        $ad = Ad::make()
            ->setAdGroupId($adGroup->id)
            ->setTextImageAd(
                TextImageAd::make()
                    ->setHref('https://mysite.com/page/')
                    ->setAdImage('TextAd Image', $imgLocalPath)
            );

        $result = $ad->create();

        // [ Post processing ]

        Checklists::checkResource($result, Ads::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'TextImageAd.AdImageHash' => 'required|string',
            'TextImageAd.Href' => 'required|string'
        ]);

        return $ad;
    }

    /**
     * @test
     * @return void
     */
    public static function createTextAdBuilderAd():void
    {
        // [ Pre processing ]

        static::$adGroups[] = $adGroup = AdGroupsCreateExamplesTest::createTextGroup_HighestPosition_MaximumCoverage();

        // [ Example ]

        $ad = Ad::make()
            ->setAdGroupId($adGroup->id)
            ->setTextAdBuilderAd(
                TextAdBuilderAd::make()
                    ->setCreative(
                        AdBuilderAd::make()->setCreativeId('1234567')
                    )
                    ->setHref('https://mysite.com/page/')
            );

        $result = $ad->create();

        // [ Post processing ]

        Checklists::checkResource(
            $result,
            Ads::class,
            [
                'TextAdBuilderAd.Creative.CreativeId' => 'required|integer',
                'TextAdBuilderAd.Href' => 'required|string'
            ],
            null,
            [
                '0' => 'required|array|size:1',
                '0.0.code' => 'required|integer:8800'
            ]
        );
    }

    /**
     * @test
     * @return void
     */
    public static function createCpcVideoAdBuilderAd():void
    {
        // [ Pre processing ]

        static::$adGroups[] = $adGroup = AdGroupsCreateExamplesTest::createTextGroup_HighestPosition_MaximumCoverage();

        // [ Example ]

        $ad = Ad::make()
            ->setAdGroupId($adGroup->id)
            ->setCpcVideoAdBuilderAd(
                CpcVideoAdBuilderAd::make()
                    ->setHref('https://mysite.com/page/')
                    ->setCreative(
                        AdBuilderAd::make()->setCreativeId('1234567')
                    )
            );

        $result = $ad->create();

        // [ Post processing ]

        Checklists::checkResource(
            $result,
            Ads::class,
            [
                'CpcVideoAdBuilderAd.Href' => 'required',
                'CpcVideoAdBuilderAd.Creative.CreativeId' => 'required|integer'
            ],
            null,
            [
                '0' => 'required|array|size:1',
                '0.0.code' => 'required|integer:8800'
            ]
        );
    }

    /**
     * @test
     * @return Ad
     */
    public static function createDynamicTextAd():Ad
    {
        // [ Pre processing ]

        static::$adGroups[] = $adGroup = AdGroupsCreateExamplesTest::createDynamicTextAdGroup_WbMaximumClicks_ServingOff();

        // [ Example ]

        $ad = Ad::make()
            ->setAdGroupId($adGroup->id)
            ->setDynamicTextAd(
                DynamicTextAd::make()
                    ->setText('My text')
            );

        $result = $ad->create();

        // [ Post processing ]

        Checklists::checkResource($result, Ads::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'DynamicTextAd.Text' => 'required|string'
        ]);

        return $ad;
    }

    /**
     * @test
     * @return Ad
     */
    public static function createMobileAppAd():Ad
    {
        // [ Pre processing ]

        static::$adGroups[] = $adGroup = AdGroupsCreateExamplesTest::createMobileAppAdGroup_HighestPosition_NetworkDefault();
        $imgLocalPath = Env::getFilesPath('img1080x607.png');

        // [ Example ]

        $ad = Ad::make()
            ->setAdGroupId($adGroup->id)
            ->setMobileAppAd(
                MobileAppAd::make()
                    ->setTitle('My Title')
                    ->setText('My text')
                    ->setAction('INSTALL')
                    ->setAgeLabel('AGE_18')
                    ->setAdImage('MobileAppAd Image', $imgLocalPath)
            );

        $result = $ad->create();

        // [ Post processing ]

        Checklists::checkResource($result, Ads::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'MobileAppAd.AdImageHash' => 'required|string',
            'MobileAppAd.Title' => 'required|string',
            'MobileAppAd.Text' => 'required|string',
            'MobileAppAd.Action' => 'required|string',
            'MobileAppAd.AgeLabel' => 'required|string'
        ]);

        return $ad;
    }

    /**
     * @test
     * @return Ad
     */
    public static function createMobileAppImageAd():Ad
    {
        // [ Pre processing ]

        static::$adGroups[] = $adGroup = AdGroupsCreateExamplesTest::createMobileAppAdGroup_HighestPosition_NetworkDefault();
        $imgLocalPath = Env::getFilesPath('img240x400.png');

        // [ Example ]

        $ad = Ad::make()
            ->setAdGroupId($adGroup->id)
            ->setMobileAppImageAd(
                MobileAppImageAd::make()
                    ->setAdImage('MobileAppAd Image', $imgLocalPath)
            );

        $result = $ad->create();

        // [ Post processing ]

        Checklists::checkResource($result, Ads::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'MobileAppImageAd.AdImageHash' => 'required|string'
        ]);

        return $ad;
    }

    /**
     * @test
     * @return void
     */
    public static function createMobileAppAdBuilderAd():void
    {
        // [ Pre processing ]

        static::$adGroups[] = $adGroup = AdGroupsCreateExamplesTest::createMobileAppAdGroup_HighestPosition_NetworkDefault();

        // [ Example ]

        $ad = Ad::make()
            ->setAdGroupId($adGroup->id)
            ->setMobileAppAdBuilderAd(
                MobileAppAdBuilderAd::make()
                    ->setCreative(
                        AdBuilderAd::make()->setCreativeId('1234567')
                    )
            );

        $result = $ad->create();

        // [ Post processing ]

        Checklists::checkResource(
            $result,
            Ads::class,
            [
                'MobileAppAdBuilderAd.Creative.CreativeId' => 'required|integer'
            ],
            null,
            [
                '0' => 'required|array|size:1',
                '0.0.code' => 'required|integer:8800'
            ]
        );
    }

    /**
     * @test
     * @return void
     */
    public static function createCpmBannerAdBuilderAd():void
    {
        // [ Pre processing ]

        static::$adGroups[] = $adGroup = AdGroupsCreateExamplesTest::createCpmBannerUserProfileAdGroup_ServingOff_ManualCpm();

        // [ Example ]

        $ad = Ad::make()
            ->setAdGroupId($adGroup->id)
            ->setCpmBannerAdBuilderAd(
                CpmBannerAdBuilderAd::make()
                    ->setHref('https://mysite.com/page/')
                    ->setTrackingPixels(
                        TrackingPixels::make(
                            TrackingPixel::make()
                                ->setTrackingPixel('https://mc.yandex.ru/pixel/12345678901234567890?md=%aw_random%')
                        )
                    )
                    ->setCreative(
                        AdBuilderAd::make()->setCreativeId('1234567')
                    )
            );

        $result = $ad->create();

        // [ Post processing ]

        Checklists::checkResource(
            $result,
            Ads::class,
            [
                'CpmBannerAdBuilderAd.Href' => 'required',
                'CpmBannerAdBuilderAd.TrackingPixels.Items' => 'required|array',
                'CpmBannerAdBuilderAd.TrackingPixels.Items.*.TrackingPixel' => 'string',
                'CpmBannerAdBuilderAd.Creative.CreativeId' => 'required|integer'
            ],
            null,
            [
                '0' => 'required|array|size:1',
                '0.0.code' => 'required|integer:8800'
            ]
        );
    }

    /**
     * @test
     * @return void
     */
    public static function createCpmVideoAdBuilderAd():void
    {
        // [ Pre processing ]

        static::$adGroups[] = $adGroup = AdGroupsCreateExamplesTest::createCpmVideoAdGroup_ServingOff_ManualCpm();

        // [ Example ]

        $ad = Ad::make()
            ->setAdGroupId($adGroup->id)
            ->setCpmVideoAdBuilderAd(
                CpmVideoAdBuilderAd::make()
                    ->setHref('https://mysite.com/page/')
                    ->setTrackingPixels(
                        TrackingPixels::make(
                            TrackingPixel::make()
                                ->setTrackingPixel('https://mc.yandex.ru/pixel/12345678901234567890?md=%aw_random%')
                        )
                    )
                    ->setCreative(
                        AdBuilderAd::make()->setCreativeId('1234567')
                    )
            );

        $result = $ad->create();

        // [ Post processing ]

        Checklists::checkResource(
            $result,
            Ads::class,
            [
                'CpmVideoAdBuilderAd.Href' => 'required',
                'CpmVideoAdBuilderAd.TrackingPixels.Items' => 'required|array',
                'CpmVideoAdBuilderAd.TrackingPixels.Items.*.TrackingPixel' => 'string',
                'CpmVideoAdBuilderAd.Creative.CreativeId' => 'required|integer'
            ],
            null,
            [
                '0' => 'required|array|size:1',
                '0.0.code' => 'required|integer:8800'
            ]
        );
    }
}