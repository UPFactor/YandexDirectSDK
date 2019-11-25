<?php

namespace YandexDirectSDKTest\Examples\Ads;

use PHPUnit\Framework\TestCase;
use UPTools\Arr;
use YandexDirectSDK\Collections\Ads;
use YandexDirectSDK\Collections\TrackingPixels;
use YandexDirectSDK\Models\Ad;
use YandexDirectSDK\Models\AdBuilderAd;
use YandexDirectSDK\Models\AdGroup;
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
use YandexDirectSDKTest\Examples\AdGroups\ModelExamplesTest as AdGroupsModelExamplesTest;
use YandexDirectSDKTest\Helpers\Checklists;
use YandexDirectSDKTest\Helpers\Env;

class ModelExamplesTest extends TestCase
{
    /**
     * @var AdGroup[]
     */
    public static $adGroups = [];

    public static $ads = [];

    public static function init()
    {
        AdGroupsModelExamplesTest::init();
        AdGroupsModelExamplesTest::testAdd_TextGroup();
        AdGroupsModelExamplesTest::testAdd_DynamicTextAdGroup();
        AdGroupsModelExamplesTest::testAdd_MobileAppAdGroup();
        AdGroupsModelExamplesTest::testAdd_CpmBannerKeywordsAdGroup();
        AdGroupsModelExamplesTest::testAdd_CpmBannerUserProfileAdGroup();
        AdGroupsModelExamplesTest::testAdd_CpmVideoAdGroup();
        static::$adGroups = AdGroupsModelExamplesTest::$adGroups;
    }

    public static function destruct()
    {
        AdGroupsModelExamplesTest::destruct();
        static::$adGroups = [];
    }

    /*
     |------------------------------------------------------------------------------------------------------------------
     |
     | Handlers
     |
     |------------------------------------------------------------------------------------------------------------------
    */

    public static function setUpBeforeClass(): void
    {
        Env::setUpSession();
        static::init();
    }

    public static function tearDownAfterClass(): void
    {
        static::destruct();
    }

    /*
     |------------------------------------------------------------------------------------------------------------------
     |
     | Add
     |
     |------------------------------------------------------------------------------------------------------------------
    */

    public static function testAdd_TextAd():Ad
    {
        // [ Pre processing ] ==========================================================================================

        $adGroup = static::$adGroups['TextGroup_HighestPosition_MaximumCoverage'];
        $imgLocalPath = Env::getFilesPath('img1080x607.png');

        // [ Example ] =================================================================================================

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

        $result = $ad->add();

        // [ Post processing ] =========================================================================================

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

        return static::$ads['TextAd'] = $ad;
    }

    public static function testAdd_TextImageAd():Ad
    {
        // [ Pre processing ] ==========================================================================================

        $adGroup = static::$adGroups['TextGroup_HighestPosition_MaximumCoverage'];
        $imgLocalPath = Env::getFilesPath('img240x400.png');

        // [ Example ] =================================================================================================

        $ad = Ad::make()
            ->setAdGroupId($adGroup->id)
            ->setTextImageAd(
                TextImageAd::make()
                    ->setHref('https://mysite.com/page/')
                    ->setAdImage('TextAd Image', $imgLocalPath)
            );

        $result = $ad->add();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Ads::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'TextImageAd.AdImageHash' => 'required|string',
            'TextImageAd.Href' => 'required|string'
        ]);

        return static::$ads['TextImageAd'] = $ad;
    }

    public static function testAdd_TextAdBuilderAd():void
    {
        // [ Pre processing ] ==========================================================================================

        $adGroup = static::$adGroups['TextGroup_HighestPosition_MaximumCoverage'];

        // [ Example ] =================================================================================================

        $ad = Ad::make()
            ->setAdGroupId($adGroup->id)
            ->setTextAdBuilderAd(
                TextAdBuilderAd::make()
                    ->setCreative(
                        AdBuilderAd::make()->setCreativeId('1234567')
                    )
                    ->setHref('https://mysite.com/page/')
            );

        $result = $ad->add();

        // [ Post processing ] =========================================================================================

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

    public static function testAdd_CpcVideoAdBuilderAd():void
    {
        // [ Pre processing ] ==========================================================================================

        $adGroup = static::$adGroups['TextGroup_HighestPosition_MaximumCoverage'];

        // [ Example ] =================================================================================================

        $ad = Ad::make()
            ->setAdGroupId($adGroup->id)
            ->setCpcVideoAdBuilderAd(
                CpcVideoAdBuilderAd::make()
                    ->setHref('https://mysite.com/page/')
                    ->setCreative(
                        AdBuilderAd::make()->setCreativeId('1234567')
                    )
            );

        $result = $ad->add();

        // [ Post processing ] =========================================================================================

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

    public static function testAdd_DynamicTextAd():Ad
    {
        // [ Pre processing ] ==========================================================================================

        $adGroup = static::$adGroups['DynamicTextAdGroup_WbMaximumClicks_ServingOff'];

        // [ Example ] =================================================================================================

        $ad = Ad::make()
            ->setAdGroupId($adGroup->id)
            ->setDynamicTextAd(
                DynamicTextAd::make()
                    ->setText('My text')
            );

        $result = $ad->add();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Ads::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'DynamicTextAd.Text' => 'required|string'
        ]);

        return static::$ads['DynamicTextAd'] = $ad;
    }

    public static function testAdd_MobileAppAd():Ad
    {
        // [ Pre processing ] ==========================================================================================

        $adGroup = static::$adGroups['MobileAppAdGroup_HighestPosition_NetworkDefault'];
        $imgLocalPath = Env::getFilesPath('img1080x607.png');

        // [ Example ] =================================================================================================

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

        $result = $ad->add();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Ads::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'MobileAppAd.AdImageHash' => 'required|string',
            'MobileAppAd.Title' => 'required|string',
            'MobileAppAd.Text' => 'required|string',
            'MobileAppAd.Action' => 'required|string',
            'MobileAppAd.AgeLabel' => 'required|string'
        ]);

        return static::$ads['MobileAppAd'] = $ad;
    }

    public static function testAdd_MobileAppImageAd():Ad
    {
        // [ Pre processing ] ==========================================================================================

        $adGroup = static::$adGroups['MobileAppAdGroup_HighestPosition_NetworkDefault'];
        $imgLocalPath = Env::getFilesPath('img240x400.png');

        // [ Example ] =================================================================================================

        $ad = Ad::make()
            ->setAdGroupId($adGroup->id)
            ->setMobileAppImageAd(
                MobileAppImageAd::make()
                    ->setAdImage('MobileAppAd Image', $imgLocalPath)
            );

        $result = $ad->add();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Ads::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'MobileAppImageAd.AdImageHash' => 'required|string'
        ]);

        return static::$ads['MobileAppImageAd'] = $ad;
    }

    public static function testAdd_MobileAppAdBuilderAd():void
    {
        // [ Pre processing ] ==========================================================================================

        $adGroup = static::$adGroups['MobileAppAdGroup_HighestPosition_NetworkDefault'];

        // [ Example ] =================================================================================================

        $ad = Ad::make()
            ->setAdGroupId($adGroup->id)
            ->setMobileAppAdBuilderAd(
                MobileAppAdBuilderAd::make()
                    ->setCreative(
                        AdBuilderAd::make()->setCreativeId('1234567')
                    )
            );

        $result = $ad->add();

        // [ Post processing ] =========================================================================================

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

    public static function testAdd_CpmBannerAdBuilderAd():void
    {
        // [ Pre processing ] ==========================================================================================

        $adGroup = static::$adGroups['CpmBannerUserProfileAdGroup_ServingOff_ManualCpm'];

        // [ Example ] =================================================================================================

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

        $result = $ad->add();

        // [ Post processing ] =========================================================================================

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

    public static function testAdd_CpmVideoAdBuilderAd():void
    {
        // [ Pre processing ] ==========================================================================================

        $adGroup = static::$adGroups['CpmVideoAdGroup_ServingOff_ManualCpm'];

        // [ Example ] =================================================================================================

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

        $result = $ad->add();

        // [ Post processing ] =========================================================================================

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


    /*
     |------------------------------------------------------------------------------------------------------------------
     |
     | Getting
     |
     |------------------------------------------------------------------------------------------------------------------
    */

    /**
     * @depends testAdd_TextAd
     * @depends testAdd_DynamicTextAd
     */
    public static function testFind():void
    {
        // [ Pre processing ] ==========================================================================================

        $id = static::$ads['TextAd']->id;

        $ids = Arr::map(static::$ads, function(Ad $ad){
            return $ad->id;
        });

        // [ Example ] =================================================================================================

        /**
         * @var integer $id
         * @var Ad $ad
         */
        $ad = Ad::find($id, ['Id', 'Status']);

        // [ Example ] =================================================================================================

        /**
         * @var integer[] $ids
         * @var Ads $ads
         */
        $ads = Ad::find($ids, [
            'Id',
            'Status',
            'Type',
            'TextAd.Text',
            'DynamicTextAd.Text'
        ]);

        // [ Post processing ] =========================================================================================

        Checklists::checkModel($ad, [
            'Id' => 'required|integer',
            'Status' => 'required|string'
        ]);

        Checklists::checkModelCollection($ads, [
            'Id' => 'required|integer',
            'Status' => 'required|string',
            'TextAd.Text' => 'required_if:Type,TEXT_AD|string',
            'DynamicTextAd.Text' => 'required_if:Type,DYNAMIC_TEXT_AD|string'
        ]);
    }

    /**
     * @depends testAdd_TextAd
     * @depends testAdd_DynamicTextAd
     */
    public static function testQuery():void
    {
        // [ Pre processing ] ==========================================================================================

        $adGroupIds = Arr::map(static::$adGroups, function(AdGroup $adGroup){
            return $adGroup->id;
        });

        // [ Example ] =================================================================================================

        $result = Ad::query()
            ->select([
                'Id',
                'Status',
                'Type',
                'TextAd.Text',
                'DynamicTextAd.Text'
            ])
            ->whereIn('AdGroupIds', $adGroupIds)
            ->whereIn('Types', ['TEXT_AD', 'DYNAMIC_TEXT_AD'])
            ->whereIn('Statuses', 'DRAFT')
            ->get();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Ads::class, [
            'Id' => 'required|integer',
            'Type' => 'required|string:TEXT_AD,MOBILE_APP_AD,DYNAMIC_TEXT_AD',
            'Status' => 'required|string:DRAFT',
            'TextAd.Text' => 'required_if:Type,TEXT_AD|string',
            'DynamicTextAd.Text' => 'required_if:Type,DYNAMIC_TEXT_AD|string'
        ]);
    }

    /*
     |------------------------------------------------------------------------------------------------------------------
     |
     | Actions
     |
     |------------------------------------------------------------------------------------------------------------------
    */

    /**
     * @depends testAdd_TextAd
     * @param Ad $ad
     */
    public static function testModerate(Ad $ad)
    {
        $result = $ad->moderate();

        // [ Post processing ] =========================================================================================

        Checklists::checkResult($result);
        sleep(10);
    }

    /**
     * @depends testAdd_TextAd
     * @param Ad $ad
     */
    public static function testSuspend(Ad $ad)
    {
        $result = $ad->suspend();

        // [ Post processing ] =========================================================================================

        Checklists::checkResult($result);
        sleep(10);
    }

    /**
     * @depends testAdd_TextAd
     * @depends testSuspend
     * @param Ad $ad
     */
    public static function testArchive(Ad $ad)
    {
        $result = $ad->archive();

        // [ Post processing ] =========================================================================================

        Checklists::checkResult($result);
        sleep(10);
    }

    /**
     * @depends testAdd_TextAd
     * @depends testArchive
     * @param Ad $ad
     */
    public static function testUnarchive(Ad $ad)
    {
        $result = $ad->unarchive();

        // [ Post processing ] =========================================================================================

        Checklists::checkResult($result);
        sleep(10);
    }

    /**
     * @depends testAdd_TextAd
     * @depends testUnarchive
     * @param Ad $ad
     */
    public static function testResume(Ad $ad)
    {
        $result = $ad->resume();

        // [ Post processing ] =========================================================================================

        Checklists::checkResult($result);
        sleep(10);
    }

    /*
     |------------------------------------------------------------------------------------------------------------------
     |
     | Update
     |
     |------------------------------------------------------------------------------------------------------------------
    */

    /**
     * @depends testAdd_TextAd
     * @param Ad $ad
     */
    public static function testUpdateTextAd(Ad $ad):void
    {
        $ad->textAd
            ->setTitle('New title')
            ->setTitle2('New title2')
            ->setText('New text')
            ->setMobile('YES');

        $result = $ad->update();

        // [ Post processing ] =========================================================================================

        Checklists::checkResource($result, Ads::class);
    }

    /*
     |------------------------------------------------------------------------------------------------------------------
     |
     | Delete
     |
     |------------------------------------------------------------------------------------------------------------------
    */

    /**
     * @depends testAdd_TextAd
     * @param Ad $ad
     */
    public static function testDeleteTextAd(Ad $ad):void
    {
        // [ Pre processing ] ==========================================================================================

        $adID = $ad->id;

        // [ Example ] =================================================================================================

        $result = Ad::find($adID)->delete();

        // [ Post processing ] =========================================================================================

        Checklists::checkResult($result);
    }
}