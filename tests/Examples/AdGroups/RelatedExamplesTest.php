<?php

namespace YandexDirectSDKTest\Examples\AdGroups;

use PHPUnit\Framework\TestCase;
use UPTools\Arr;
use YandexDirectSDK\Collections\Ads;
use YandexDirectSDK\Collections\AudienceTargets;
use YandexDirectSDK\Collections\BidModifiers;
use YandexDirectSDK\Collections\BidModifierToggles;
use YandexDirectSDK\Collections\Bids;
use YandexDirectSDK\Collections\BidsAuto;
use YandexDirectSDK\Collections\Keywords;
use YandexDirectSDK\Collections\TrackingPixels;
use YandexDirectSDK\Collections\WebpageConditions;
use YandexDirectSDK\Collections\Webpages;
use YandexDirectSDK\Models\Ad;
use YandexDirectSDK\Models\AdBuilderAd;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\AudienceTarget;
use YandexDirectSDK\Models\BidAuto;
use YandexDirectSDK\Models\BidModifier;
use YandexDirectSDK\Models\Campaign;
use YandexDirectSDK\Models\CpcVideoAdBuilderAd;
use YandexDirectSDK\Models\CpmBannerAdBuilderAd;
use YandexDirectSDK\Models\CpmVideoAdBuilderAd;
use YandexDirectSDK\Models\DemographicsAdjustment;
use YandexDirectSDK\Models\DynamicTextAd;
use YandexDirectSDK\Models\Keyword;
use YandexDirectSDK\Models\MobileAppAd;
use YandexDirectSDK\Models\MobileAppAdBuilderAd;
use YandexDirectSDK\Models\MobileAppImageAd;
use YandexDirectSDK\Models\TextAd;
use YandexDirectSDK\Models\TextAdBuilderAd;
use YandexDirectSDK\Models\TextImageAd;
use YandexDirectSDK\Models\TrackingPixel;
use YandexDirectSDK\Models\Webpage;
use YandexDirectSDK\Models\WebpageCondition;
use YandexDirectSDKTest\Helpers\Checklists;
use YandexDirectSDKTest\Helpers\Env;

class RelatedExamplesTest extends TestCase
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
     | DataProvider
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * DataProvider
     * @return array
     */
    public static function textGroupProvider()
    {
        Env::setUpSession();

        return [
            'TextGroupHPMC' => [static::$adGroups['TextGroupHPMC'] ?? static::$adGroups['TextGroupHPMC'] = CreateExamplesTest::createTextGroup_HighestPosition_MaximumCoverage()],
            'TextGroupMCND' => [static::$adGroups['TextGroupMCND'] ?? static::$adGroups['TextGroupMCND'] = CreateExamplesTest::createTextGroup_WbMaximumClicks_NetworkDefault()]
        ];
    }

    /**
     * DataProvider
     * @return array
     */
    public static function textGroupHPMCProvider()
    {
        Env::setUpSession();

        return [
            'TextGroupHPMC' => [static::$adGroups['TextGroupHPMC'] ?? static::$adGroups['TextGroupHPMC'] = CreateExamplesTest::createTextGroup_HighestPosition_MaximumCoverage()],
        ];
    }

    /**
     * DataProvider
     * @return array
     */
    public static function textGroupMCNDProvider()
    {
        Env::setUpSession();

        return [
            'TextGroupMCND' => [static::$adGroups['TextGroupMCND'] ?? static::$adGroups['TextGroupMCND'] = CreateExamplesTest::createTextGroup_WbMaximumClicks_NetworkDefault()]
        ];
    }

    /**
     * DataProvider
     * @return array
     */
    public static function dynamicTextAdGroupProvider()
    {
        Env::setUpSession();

        return [
            'DynamicTextAdGroupMCSO' => [static::$adGroups['DynamicTextAdGroupMCSO'] ?? static::$adGroups['DynamicTextAdGroupMCSO'] = CreateExamplesTest::createDynamicTextAdGroup_WbMaximumClicks_ServingOff()],
        ];
    }

    /**
     * DataProvider
     * @return array
     */
    public static function mobileAppAdGroupProvider()
    {
        Env::setUpSession();

        return [
            'MobileAppAdGroupHPND' => [static::$adGroups['MobileAppAdGroupHPND'] ?? static::$adGroups['MobileAppAdGroupHPND'] = CreateExamplesTest::createMobileAppAdGroup_HighestPosition_NetworkDefault()],
        ];
    }

    /**
     * DataProvider
     * @return array
     */
    public static function cpmBannerAdGroupProvider()
    {
        Env::setUpSession();

        return [
            'CpmBannerKeywordsAdGroupSOMC' => [static::$adGroups['CpmBannerKeywordsAdGroupSOMC'] ?? static::$adGroups['CpmBannerKeywordsAdGroupSOMC'] = CreateExamplesTest::createCpmBannerKeywordsAdGroup_ServingOff_ManualCpm()],
            'CpmBannerUserProfileAdGroupSOMC' => [static::$adGroups['CpmBannerUserProfileAdGroupSOMC'] ?? static::$adGroups['CpmBannerUserProfileAdGroupSOMC'] = CreateExamplesTest::createCpmBannerUserProfileAdGroup_ServingOff_ManualCpm()]
        ];
    }

    /**
     * DataProvider
     * @return array
     */
    public static function cpmBannerKeywordsAdGroupProvider()
    {
        Env::setUpSession();

        return [
            'CpmBannerKeywordsAdGroupSOMC' => [static::$adGroups['CpmBannerKeywordsAdGroupSOMC'] ?? static::$adGroups['CpmBannerKeywordsAdGroupSOMC'] = CreateExamplesTest::createCpmBannerKeywordsAdGroup_ServingOff_ManualCpm()]
        ];
    }

    /**
     * DataProvider
     * @return array
     */
    public static function cpmVideoAdGroupProvider()
    {
        Env::setUpSession();

        return [
            'CpmVideoAdGroupSOMC' => [static::$adGroups['CpmVideoAdGroupSOMC'] ?? static::$adGroups['CpmVideoAdGroupSOMC'] = CreateExamplesTest::createCpmVideoAdGroup_ServingOff_ManualCpm()],
        ];
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Examples
     |
     |-------------------------------------------------------------------------------
    */

    /*
     | Add related ads
     | -------------------------------------------------------------------------------
     */

    /**
     * @test
     * @dataProvider textGroupProvider
     * @param AdGroup $adGroup
     */
    public static function addRelatedAds(AdGroup $adGroup):void
    {
        $ads = Ads::wrap([
            Ad::make()
                ->setTextAd(
                    TextAd::make()
                        ->setTitle('My first ad title')
                        ->setTitle2('My first ad title2')
                        ->setText('First ad text')
                        ->setHref('https://mysite.com/page/')
                        ->setMobile('NO')
                ),
            Ad::make()
                ->setTextAd(
                    TextAd::make()
                        ->setTitle('My second ad title')
                        ->setTitle2('My second ad title2')
                        ->setText('Second ad text')
                        ->setHref('https://mysite.com/page/')
                        ->setMobile('YES')
                ),
        ]);

        $result = $adGroup->addRelatedAds($ads);

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
            $result->getResource()->delete()
        );
    }

    /**
     * @test
     * @dataProvider textGroupProvider
     * @param AdGroup $adGroup
     */
    public static function addRelatedAds_TextAd(AdGroup $adGroup):void
    {
        // [ Pre processing ]

        $imgLocalPath = Env::getFilesPath('img1080x607.png');

        // [ Example ]

        $ad = Ad::make()
            ->setTextAd(
                TextAd::make()
                    ->setTitle('My Title')
                    ->setTitle2('My Title2')
                    ->setText('My text')
                    ->setHref('https://mysite.com/page/')
                    ->setMobile('NO')
                    ->setAdImage('TextAd Image', $imgLocalPath)
            );

        $result = $adGroup->addRelatedAds($ad);

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
    }

    /**
     * @test
     * @dataProvider textGroupProvider
     * @param AdGroup $adGroup
     */
    public static function addRelatedAds_TextImageAd(AdGroup $adGroup):void
    {
        // [ Pre processing ]

        $imgLocalPath = Env::getFilesPath('img240x400.png');

        // [ Example ]

        $ad = Ad::make()
            ->setTextImageAd(
                TextImageAd::make()
                    ->setHref('https://mysite.com/page/')
                    ->setAdImage('TextAd Image', $imgLocalPath)
            );

        $result = $adGroup->addRelatedAds($ad);

        // [ Post processing ]

        Checklists::checkResource($result, Ads::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'TextImageAd.AdImageHash' => 'required|string',
            'TextImageAd.Href' => 'required|string'
        ]);
    }

    /**
     * @test
     * @dataProvider textGroupProvider
     * @param AdGroup $adGroup
     */
    public static function addRelatedAds_TextAdBuilderAd(AdGroup $adGroup):void
    {
        $ad = Ad::make()
            ->setTextAdBuilderAd(
                TextAdBuilderAd::make()
                    ->setCreative(
                        AdBuilderAd::make()->setCreativeId('1234567')
                    )
                    ->setHref('https://mysite.com/page/')
            );

        $result = $adGroup->addRelatedAds($ad);

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
     * @dataProvider textGroupProvider
     * @param AdGroup $adGroup
     */
    public static function addRelatedAds_CpcVideoAdBuilderAd(AdGroup $adGroup):void
    {
        $ad = Ad::make()
            ->setCpcVideoAdBuilderAd(
                CpcVideoAdBuilderAd::make()
                    ->setHref('https://mysite.com/page/')
                    ->setCreative(
                        AdBuilderAd::make()->setCreativeId('1234567')
                    )
            );

        $result = $adGroup->addRelatedAds($ad);

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
     * @dataProvider dynamicTextAdGroupProvider
     * @param AdGroup $adGroup
     */
    public static function addRelatedAds_DynamicTextAd(AdGroup $adGroup):void
    {
        $ad = Ad::make()
            ->setDynamicTextAd(
                DynamicTextAd::make()
                    ->setText('My text')
            );

        $result = $adGroup->addRelatedAds($ad);

        // [ Post processing ]

        Checklists::checkResource($result, Ads::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'DynamicTextAd.Text' => 'required|string'
        ]);
    }

    /**
     * @test
     * @dataProvider mobileAppAdGroupProvider
     * @param AdGroup $adGroup
     */
    public static function addRelatedAds_MobileAppAd(AdGroup $adGroup):void
    {
        // [ Pre processing ]

        $imgLocalPath = Env::getFilesPath('img1080x607.png');

        // [ Example ]

        $ad = Ad::make()
            ->setMobileAppAd(
                MobileAppAd::make()
                    ->setTitle('My Title')
                    ->setText('My text')
                    ->setAction('INSTALL')
                    ->setAgeLabel('AGE_18')
                    ->setAdImage('MobileAppAd Image', $imgLocalPath)
            );

        $result = $adGroup->addRelatedAds($ad);

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
    }

    /**
     * @test
     * @dataProvider mobileAppAdGroupProvider
     * @param AdGroup $adGroup
     */
    public static function addRelatedAds_MobileAppImageAd(AdGroup $adGroup):void
    {
        // [ Pre processing ]

        $imgLocalPath = Env::getFilesPath('img240x400.png');

        // [ Example ]

        $ad = Ad::make()
            ->setMobileAppImageAd(
                MobileAppImageAd::make()
                    ->setAdImage('MobileAppAd Image', $imgLocalPath)
            );

        $result = $adGroup->addRelatedAds($ad);

        // [ Post processing ]

        Checklists::checkResource($result, Ads::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'MobileAppImageAd.AdImageHash' => 'required|string'
        ]);
    }

    /**
     * @test
     * @dataProvider mobileAppAdGroupProvider
     * @param AdGroup $adGroup
     */
    public static function addRelatedAds_MobileAppAdBuilderAd(AdGroup $adGroup):void
    {
        $ad = Ad::make()
            ->setMobileAppAdBuilderAd(
                MobileAppAdBuilderAd::make()
                    ->setCreative(
                        AdBuilderAd::make()->setCreativeId('1234567')
                    )
            );

        $result = $adGroup->addRelatedAds($ad);

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
     * @dataProvider cpmBannerAdGroupProvider
     * @param AdGroup $adGroup
     */
    public static function addRelatedAds_CpmBannerAdBuilderAd(AdGroup $adGroup):void
    {
        $ad = Ad::make()
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

        $result = $adGroup->addRelatedAds($ad);

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
     * @dataProvider cpmVideoAdGroupProvider
     * @param AdGroup $adGroup
     */
    public static function addRelatedAds_CpmVideoAdBuilderAd(AdGroup $adGroup):void
    {
        $ad = Ad::make()
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

        $result = $adGroup->addRelatedAds($ad);

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

    /*
     | Get related ads
     | -------------------------------------------------------------------------------
     */

    /**
     * @test
     * @dataProvider textGroupHPMCProvider
     * @depends addRelatedAds_TextAd
     * @param AdGroup $adGroup
     */
    public static function getRelatedAds_TextGroup(AdGroup $adGroup):void
    {
        $ads = $adGroup->getRelatedAds([
            'Id',
            'AdGroupId',
            'Type',
            'TextAd.Title',
            'TextAd.Title2',
            'TextAd.Text'
        ]);

        // [ Post processing ]

        Checklists::checkModelCollection($ads, Ads::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'Type' => 'required|string',
            'TextAd' => 'required_if:Type,TEXT_AD|array',
            'TextAd.Title' => 'required_if:Type,TEXT_AD|string',
            'TextAd.Title2' => 'required_if:Type,TEXT_AD|string',
            'TextAd.Text' => 'required_if:Type,TEXT_AD|string',
        ]);
    }

    /**
     * @test
     * @dataProvider dynamicTextAdGroupProvider
     * @depends addRelatedAds_DynamicTextAd
     * @param AdGroup $adGroup
     */
    public static function getRelatedAds_DynamicTextAdGroup(AdGroup $adGroup):void
    {
        $ads = $adGroup->getRelatedAds([
            'Id',
            'AdGroupId',
            'DynamicTextAd.Text'
        ]);

        // [ Post processing ]

        Checklists::checkModelCollection($ads, Ads::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'DynamicTextAd.Text' => 'required|string'
        ]);
    }

    /**
     * @test
     * @dataProvider mobileAppAdGroupProvider
     * @depends addRelatedAds_MobileAppAd
     * @param AdGroup $adGroup
     */
    public static function getRelatedAds_MobileAppAdGroup(AdGroup $adGroup):void
    {
        $ads = $adGroup->getRelatedAds([
            'Id',
            'AdGroupId',
            'Type',
            'MobileAppAd.Title',
            'MobileAppAd.Text',
        ]);

        // [ Post processing ]

        Checklists::checkModelCollection($ads, Ads::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'Type' => 'required|string',
            'MobileAppAd' => 'required_if:Type,MOBILE_APP_AD|array',
            'MobileAppAd.Title' => 'required_if:Type,MOBILE_APP_AD|string',
            'MobileAppAd.Text' => 'required_if:Type,MOBILE_APP_AD|string'
        ]);
    }

    /*
      | Add related keywords
      | -------------------------------------------------------------------------------
      */

    /**
     * @test
     * @dataProvider textGroupHPMCProvider
     * @depends addRelatedAds_TextAd
     * @param AdGroup $adGroup
     */
    public static function addRelatedKeywords_ByList(AdGroup $adGroup):void
    {
        $result = $adGroup->addRelatedKeywords(
            Keywords::makeByList(['keyword1','keyword2','keyword3'])
        );

        // [ Post processing ]

        Checklists::checkResource($result, Keywords::class, [
            'Id' => 'required|integer',
            'Keyword' => 'required|string'
        ]);

        Checklists::checkResult(
            $result->getResource()->delete()
        );
    }

    /**
     * @test
     * @dataProvider textGroupProvider
     * @depends addRelatedAds_TextAd
     * @param AdGroup $adGroup
     */
    public static function addRelatedKeywords_TextGroup(AdGroup $adGroup):void
    {
        $result = $adGroup->addRelatedKeywords(
            Keywords::make(
                Keyword::make()
                    ->setUserParam1('param1-by-keyword-1')
                    ->setUserParam2('param2-by-keyword-1')
                    ->setKeyword('yandex direct -api'),
                Keyword::make()
                    ->setUserParam1('param1-by-keyword-2')
                    ->setUserParam2('param2-by-keyword-2')
                    ->setKeyword('yandex sdk -direct -api')
            )
        );

        // [ Post processing ]

        Checklists::checkResource($result, Keywords::class, [
            'Id' => 'required|integer',
            'UserParam1' => 'required|string',
            'UserParam2' => 'required|string',
            'Keyword' => 'required|string'
        ]);
    }

    /**
     * @test
     * @dataProvider mobileAppAdGroupProvider
     * @depends addRelatedAds_MobileAppAd
     * @param AdGroup $adGroup
     */
    public static function addRelatedKeywords_MobileAppAdGroup(AdGroup $adGroup):void
    {
        $result = $adGroup->addRelatedKeywords(
            Keywords::make(
                Keyword::make()
                    ->setUserParam1('param1-by-keyword-1')
                    ->setUserParam2('param2-by-keyword-1')
                    ->setKeyword('yandex direct -api'),
                Keyword::make()
                    ->setUserParam1('param1-by-keyword-2')
                    ->setUserParam2('param2-by-keyword-2')
                    ->setKeyword('yandex sdk -direct -api')
            )
        );

        // [ Post processing ]

        Checklists::checkResource($result, Keywords::class, [
            'Id' => 'required|integer',
            'UserParam1' => 'required|string',
            'UserParam2' => 'required|string',
            'Keyword' => 'required|string'
        ]);
    }

    /**
     * @test
     * @dataProvider cpmBannerKeywordsAdGroupProvider
     * @depends addRelatedAds_CpmBannerAdBuilderAd
     * @param AdGroup $adGroup
     */
    public static function addRelatedKeywords_CpmBannerAdGroup(AdGroup $adGroup):void
    {
        $result = $adGroup->addRelatedKeywords(
            Keywords::make(
                Keyword::make()
                    ->setUserParam1('param1-by-keyword-1')
                    ->setUserParam2('param2-by-keyword-1')
                    ->setKeyword('yandex direct -api'),
                Keyword::make()
                    ->setUserParam1('param1-by-keyword-2')
                    ->setUserParam2('param2-by-keyword-2')
                    ->setKeyword('yandex sdk -direct -api')
            )
        );

        // [ Post processing ]

        Checklists::checkResource($result, Keywords::class, [
            'Id' => 'required|integer',
            'UserParam1' => 'required|string',
            'UserParam2' => 'required|string',
            'Keyword' => 'required|string'
        ]);
    }

    /*
     | Get related keywords
     | -------------------------------------------------------------------------------
     */

    /**
     * @test
     * @dataProvider textGroupProvider
     * @depends addRelatedKeywords_TextGroup
     * @param AdGroup $adGroup
     */
    public static function getRelatedKeywords_TextGroup(AdGroup $adGroup):void
    {
        $keywords = $adGroup->getRelatedKeywords([
            'Id',
            'UserParam1',
            'UserParam2',
            'Keyword',
            'Status'
        ]);

        // [ Post processing ]

        Checklists::checkModelCollection($keywords, Keywords::class, [
            'Id' => 'required|integer',
            'UserParam1' => 'required|string',
            'UserParam2' => 'required|string',
            'Keyword' => 'required|string',
            'Status' => 'required|string'
        ]);
    }

    /**
     * @test
     * @dataProvider mobileAppAdGroupProvider
     * @depends addRelatedKeywords_MobileAppAdGroup
     * @param AdGroup $adGroup
     */
    public static function getRelatedKeywords_MobileAppAdGroup(AdGroup $adGroup):void
    {
        $keywords = $adGroup->getRelatedKeywords(['Id','Keyword','Status']);

        // [ Post processing ]

        Checklists::checkModelCollection($keywords, Keywords::class, [
            'Id' => 'required|integer',
            'Keyword' => 'required|string',
            'Status' => 'required|string'
        ]);
    }

    /**
     * @test
     * @dataProvider cpmBannerKeywordsAdGroupProvider
     * @depends addRelatedKeywords_CpmBannerAdGroup
     * @param AdGroup $adGroup
     */
    public static function getRelatedKeywords_CpmBannerAdGroup(AdGroup $adGroup):void
    {
        $keywords = $adGroup->getRelatedKeywords(['Id','Keyword','Status']);

        // [ Post processing ]

        Checklists::checkModelCollection($keywords, Keywords::class, [
            'Id' => 'required|integer',
            'Keyword' => 'required|string',
            'Status' => 'required|string'
        ]);
    }

    /*
     | Related audience targets
     | -------------------------------------------------------------------------------
     */

    /**
     * @test
     * @dataProvider textGroupHPMCProvider
     * @depends addRelatedAds_TextAd
     * @param AdGroup $adGroup
     */
    public static function addRelatedAudienceTargets(AdGroup $adGroup):void
    {
        $result = $adGroup->addRelatedAudienceTargets(
            AudienceTarget::make()
                ->setInterestId(42)
                ->setContextBid(20000000)
        );

        // [ Post processing ]

        Checklists::checkResource(
            $result,
            AudienceTargets::class,
            [
                'InterestId' => 'required|integer',
                'ContextBid' => 'required|integer'
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
     * @dataProvider textGroupHPMCProvider
     * @depends addRelatedAudienceTargets
     * @param AdGroup $adGroup
     */
    public static function getRelatedAudienceTargets(AdGroup $adGroup):void
    {
        $audienceTargets = $adGroup->getRelatedAudienceTargets([
            'Id',
            'AdGroupId',
            'InterestId',
            'ContextBid',
            'State'
        ]);

        // [ Post processing ]

        Checklists::checkModelCollection($audienceTargets, AudienceTargets::class);
        static::assertTrue($audienceTargets->isEmpty());
    }

    /*
     | Related bids
     | -------------------------------------------------------------------------------
     */

    /**
     * @test
     * @dataProvider textGroupHPMCProvider
     * @depends addRelatedAds_TextAd
     * @param AdGroup $adGroup
     */
    public static function setRelatedBids(AdGroup $adGroup):void
    {
        $result = $adGroup->setRelatedBids(30000000, 10000000);

        // [ Post processing ]

        Checklists::checkResource($result, Bids::class, [
            'AdGroupId' => 'required|integer',
            'Bid' => 'required|integer',
            'ContextBid' => 'required|integer'
        ]);
    }

    /**
     * @test
     * @dataProvider textGroupHPMCProvider
     * @depends addRelatedAds_TextAd
     * @param AdGroup $adGroup
     */
    public static function setRelatedContextBids(AdGroup $adGroup):void
    {
        $result = $adGroup->setRelatedContextBids(10000000);

        // [ Post processing ]

        Checklists::checkResource($result, Bids::class, [
            'AdGroupId' => 'required|integer',
            'ContextBid' => 'required|integer'
        ]);
    }

    /**
     * @test
     * @dataProvider textGroupMCNDProvider
     * @depends addRelatedAds_TextAd
     * @param AdGroup $adGroup
     */
    public static function setRelatedStrategyPriority(AdGroup $adGroup):void
    {
        $result = $adGroup->setRelatedStrategyPriority('HIGH');

        // [ Post processing ]

        Checklists::checkResource($result, Bids::class, [
            'AdGroupId' => 'required|integer',
            'StrategyPriority' => 'required|string'
        ]);
    }

    /**
     * @test
     * @dataProvider textGroupHPMCProvider
     * @depends setRelatedBids
     * @depends setRelatedContextBids
     * @param AdGroup $adGroup
     */
    public static function getRelatedBids(AdGroup $adGroup):void
    {
        $bids = $adGroup->getRelatedBids(['Bid','CampaignId','AdGroupId','KeywordId']);

        // [ Post processing ]

        Checklists::checkModelCollection($bids, Bids::class, [
            'Bid' => 'required|integer',
            'CampaignId' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'KeywordId' => 'required|integer'
        ]);
    }

    /**
     * @test
     * @dataProvider textGroupHPMCProvider
     * @depends addRelatedAds_TextAd
     * @param AdGroup $adGroup
     */
    public static function setRelatedBidsAuto(AdGroup $adGroup):void
    {
        $result = $adGroup->setRelatedBidsAuto(
            BidAuto::make()
                ->setScope(['SEARCH'])
                ->setPosition('PREMIUMBLOCK')
        );

        // [ Post processing ]

        Checklists::checkResource($result, BidsAuto::class, [
            'AdGroupId' => 'required|integer',
            'Scope' => 'required|array',
            'Position' => 'string'
        ]);
    }

    /*
     | Related bid modifiers
     | -------------------------------------------------------------------------------
     */

    /**
     * @test
     * @dataProvider textGroupHPMCProvider
     * @depends addRelatedAds_TextAd
     * @param AdGroup $adGroup
     */
    public static function addRelatedBidModifiers(AdGroup $adGroup):void
    {
        $bidModifier = BidModifier::make()
            ->setDemographicsAdjustment(
                DemographicsAdjustment::make()
                    ->setAge('AGE_18_24')
                    ->setGender('GENDER_FEMALE')
                    ->setBidModifier(50)
            );

        $result = $adGroup->addRelatedBidModifiers($bidModifier);

        // [ Post processing ]

        Checklists::checkResource($result, BidModifiers::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'DemographicsAdjustment.Age' => 'required|string',
            'DemographicsAdjustment.Gender' => 'required|string',
            'DemographicsAdjustment.BidModifier' => 'required|integer',
        ]);
    }

    /**
     * @test
     * @dataProvider textGroupHPMCProvider
     * @depends addRelatedBidModifiers
     * @param AdGroup $adGroup
     */
    public static function getRelatedBidModifiers(AdGroup $adGroup):void
    {
        $bidModifiers = $adGroup->getRelatedBidModifiers([
            'Id',
            'CampaignId',
            'AdGroupId',
            'DemographicsAdjustment.Age',
            'DemographicsAdjustment.Gender',
            'DemographicsAdjustment.BidModifier'
        ]);

        // [ Post processing ]

        Checklists::checkModelCollection($bidModifiers, BidModifiers::class, [
            'Id' => 'required|integer',
            'CampaignId' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'DemographicsAdjustment.Age' => 'required|string',
            'DemographicsAdjustment.Gender' => 'required|string',
            'DemographicsAdjustment.BidModifier' => 'required|integer',
        ]);
    }

    /**
     * @test
     * @dataProvider textGroupHPMCProvider
     * @depends addRelatedBidModifiers
     * @param AdGroup $adGroup
     */
    public static function disableRelatedBidModifiers(AdGroup $adGroup):void
    {
        $result = $adGroup->disableBidModifiers('DEMOGRAPHICS_ADJUSTMENT');

        // [ Post processing ]

        Checklists::checkResource($result, BidModifierToggles::class);
        sleep(10);
    }

    /**
     * @test
     * @dataProvider textGroupHPMCProvider
     * @depends disableRelatedBidModifiers
     * @param AdGroup $adGroup
     */
    public static function enableRelatedBidModifiers(AdGroup $adGroup):void
    {
        $result = $adGroup->enableBidModifiers('DEMOGRAPHICS_ADJUSTMENT');

        // [ Post processing ]

        Checklists::checkResource($result, BidModifierToggles::class);
        sleep(10);
    }

    /*
     | Related webpages
     | -------------------------------------------------------------------------------
     */

    /**
     * @test
     * @dataProvider dynamicTextAdGroupProvider
     * @depends addRelatedAds_TextAd
     * @param AdGroup $adGroup
     */
    public static function addRelatedWebpages(AdGroup $adGroup):void
    {
        $result = $adGroup->addRelatedWebpages(
            Webpage::make()
                ->setName('MyTargetingCondition')
                ->setConditions(
                    WebpageConditions::make(
                        WebpageCondition::domainContain(['mysite.com']),
                        WebpageCondition::pageNotContain(['home', 'main'])
                    )
                )
        );

        // [ Post processing ]

        Checklists::checkResource($result, Webpages::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'Name' => 'string',
            'Conditions' => 'required|size:2',
            'Conditions.*.Operand' => 'required|string',
            'Conditions.*.Operator' => 'required|string',
            'Conditions.*.Arguments' => 'required|array_of:string'
        ]);
    }

    /**
     * @test
     * @dataProvider dynamicTextAdGroupProvider
     * @depends addRelatedWebpages
     * @param AdGroup $adGroup
     */
    public static function getRelatedWebpages(AdGroup $adGroup):void
    {
        $webpages = $adGroup->getRelatedWebpages([
            'Id',
            'Name',
            'CampaignId',
            'AdGroupId',
            'Conditions'
        ]);

        // [ Post processing ]

        Checklists::checkModelCollection($webpages, Webpages::class, [
            'Id' => 'required|integer',
            'CampaignId' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'Name' => 'string',
            'Conditions' => 'required|size:2',
            'Conditions.*.Operand' => 'required|string',
            'Conditions.*.Operator' => 'required|string',
            'Conditions.*.Arguments' => 'required|array_of:string'
        ]);
    }
}