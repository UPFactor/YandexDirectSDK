<?php

namespace YandexDirectSDKTest\Examples\Campaigns;

use PHPUnit\Framework\TestCase;
use UPTools\Arr;
use YandexDirectSDK\Collections\AdGroups;
use YandexDirectSDK\Collections\Ads;
use YandexDirectSDK\Collections\AudienceTargets;
use YandexDirectSDK\Collections\BidModifiers;
use YandexDirectSDK\Collections\BidModifierToggles;
use YandexDirectSDK\Collections\Bids;
use YandexDirectSDK\Collections\BidsAuto;
use YandexDirectSDK\Collections\Keywords;
use YandexDirectSDK\Collections\WebpageConditions;
use YandexDirectSDK\Collections\Webpages;
use YandexDirectSDK\Models\Ad;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\BidAuto;
use YandexDirectSDK\Models\BidModifier;
use YandexDirectSDK\Models\Campaign;
use YandexDirectSDK\Models\DynamicTextAdGroup;
use YandexDirectSDK\Models\Keyword;
use YandexDirectSDK\Models\MobileAppAdGroup;
use YandexDirectSDK\Models\RegionalAdjustment;
use YandexDirectSDK\Models\TextAd;
use YandexDirectSDK\Models\Webpage;
use YandexDirectSDK\Models\WebpageCondition;
use YandexDirectSDKTest\Helpers\Checklists;
use YandexDirectSDKTest\Helpers\Env;

class RelatedExamplesTest extends TestCase
{
    /**
     * @var Campaign[]
     */
    private static $campaigns = [];

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

        Campaign::find(Arr::map(static::$campaigns, function(Campaign $campaign){
            return $campaign->id;
        }))->delete();

        static::$campaigns = [];
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
    public static function campaignProvider()
    {
        return array_merge(
            static::textCampaignProvider(),
            static::dynamicTextCampaignProvider(),
            static::mobileAppCampaignProvider(),
            static::cpmBannerCampaignProvider()
        );
    }

    /**
     * DataProvider
     * @return array
     */
    public static function textCampaignProvider()
    {
        Env::setUpSession();

        return [
            'TextCampaignHPMC' => [static::$campaigns['TextCampaignHPMC'] ?? static::$campaigns['TextCampaignHPMC'] = CreateExamplesTest::createTextCampaign_HighestPosition_MaximumCoverage()],
            'TextCampaignMCND' => [static::$campaigns['TextCampaignMCND'] ?? static::$campaigns['TextCampaignMCND'] = CreateExamplesTest::createTextCampaign_WbMaximumClicks_NetworkDefault()]
        ];
    }

    /**
     * DataProvider
     * @return array
     */
    public static function textCampaignHPMCProvider()
    {
        Env::setUpSession();

        return [
            'TextCampaignHPMC' => [static::$campaigns['TextCampaignHPMC'] ?? static::$campaigns['TextCampaignHPMC'] = CreateExamplesTest::createTextCampaign_HighestPosition_MaximumCoverage()],
        ];
    }

    /**
     * DataProvider
     * @return array
     */
    public static function textCampaignMCNDProvider()
    {
        Env::setUpSession();

        return [
            'TextCampaignMCND' => [static::$campaigns['TextCampaignMCND'] ?? static::$campaigns['TextCampaignMCND'] = CreateExamplesTest::createTextCampaign_WbMaximumClicks_NetworkDefault()]
        ];
    }

    /**
     * DataProvider
     * @return array
     */
    public static function dynamicTextCampaignProvider()
    {
        Env::setUpSession();

        return [
            'DynamicTextCampaignHPSO' => [static::$campaigns['DynamicTextCampaignHPSO'] ?? static::$campaigns['DynamicTextCampaignHPSO'] = CreateExamplesTest::createDynamicTextCampaign_HighestPosition_ServingOff()],
        ];
    }

    /**
     * DataProvider
     * @return array
     */
    public static function mobileAppCampaignProvider()
    {
        Env::setUpSession();

        return [
            'MobileAppCampaignHPND' => [static::$campaigns['MobileAppCampaignHPND'] ?? static::$campaigns['MobileAppCampaignHPND'] = CreateExamplesTest::createMobileAppCampaign_HighestPosition_NetworkDefault()],
        ];
    }

    /**
     * DataProvider
     * @return array
     */
    public static function cpmBannerCampaignProvider()
    {
        Env::setUpSession();

        return [
            'CpmBannerCampaignSOMC' => [static::$campaigns['CpmBannerCampaignSOMC'] ?? static::$campaigns['CpmBannerCampaignSOMC'] = CreateExamplesTest::createCpmBannerCampaign_ServingOff_ManualCpm()],
        ];
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
     * @dataProvider textCampaignProvider
     * @param Campaign $campaign
     */
    public static function addRelatedAdGroups(Campaign $campaign): void
    {
        $adGroups = AdGroups::wrap([
            AdGroup::make()
                ->setName('MyAdGroup one')
                ->setRegionIds([225])
                ->setNegativeKeywords(['negative','keywords'])
                ->setTrackingParams('from=direct&ad={ad_id}'),
            AdGroup::make()
                ->setName('MyAdGroup two')
                ->setRegionIds([225])
        ]);

        $result = $campaign->addRelatedAdGroups($adGroups);

        // [ Post processing ]

        Checklists::checkResource($result, AdGroups::class, [
            'Id' => 'required|integer',
            'CampaignId' => 'required|integer',
            'Name' => 'required|string',
            'RegionIds' => 'required|array_of:integer',
            'NegativeKeywords.Items' => 'array_of:string',
            'TrackingParams' => 'string'
        ]);

        Checklists::checkResult(
            $result->getResource()->delete()
        );
    }

    /**
     * @test
     * @dataProvider textCampaignProvider
     * @param Campaign $campaign
     */
    public static function addRelatedAdGroup_TextAdGroup(Campaign $campaign): void
    {
        $adGroup = AdGroup::make()
            ->setName('TextAdGroup')
            ->setRegionIds([225])
            ->setNegativeKeywords(['negative','keywords'])
            ->setTrackingParams('from=direct&ad={ad_id}');

        $result = $campaign->addRelatedAdGroups($adGroup);

        // [ Post processing ]

        Checklists::checkResource($result, AdGroups::class, [
            'Id' => 'required|integer',
            'CampaignId' => 'required|integer',
            'Name' => 'required|string',
            'RegionIds' => 'required|array_of:integer',
            'NegativeKeywords.Items' => 'required|array_of:string',
            'TrackingParams' => 'required|string'
        ]);

        $adGroups = $result->getResource();

        $adsResult = $adGroups->addRelatedAds(
            Ad::make()
                ->setTextAd(
                    TextAd::make()
                        ->setTitle('Title of my ad')
                        ->setTitle2('Title of my second ad')
                        ->setText('My ad text')
                        ->setHref('https://mysite.com/page/')
                        ->setMobile('NO')
                )
        );

        $keywordsResult = $adGroups->addRelatedKeywords(
            Keywords::make(
                Keyword::make()->setKeyword('yandex api'),
                Keyword::make()->setKeyword('yandex direct')
            )
        );

        Checklists::checkResource($adsResult, Ads::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'TextAd.Title' => 'required|string',
            'TextAd.Title2' => 'required|string',
            'TextAd.Text' => 'required|string',
            'TextAd.Href' => 'required|string',
            'TextAd.Mobile' => 'required|string'
        ]);

        Checklists::checkResource($keywordsResult, Keywords::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'Keyword' => 'required|string'
        ]);
    }

    /**
     * @test
     * @dataProvider dynamicTextCampaignProvider
     * @param Campaign $campaign
     */
    public static function addRelatedAdGroup_DynamicTextAdGroup(Campaign $campaign): void
    {
        $adGroup = AdGroup::make()
            ->setName('DynamicTextAdGroup')
            ->setRegionIds([225])
            ->setNegativeKeywords(['negative','keywords'])
            ->setTrackingParams('from=direct&ad={ad_id}')
            ->setDynamicTextAdGroup(
                DynamicTextAdGroup::make()
                    ->setDomainUrl('yandex.ru')
            );

        $result = $campaign->addRelatedAdGroups($adGroup);

        // [ Post processing ]

        Checklists::checkResource($result, AdGroups::class, [
            'Id' => 'required|integer',
            'CampaignId' => 'required|integer',
            'Name' => 'required|string',
            'RegionIds' => 'required|array_of:integer',
            'NegativeKeywords.Items' => 'required|array_of:string',
            'TrackingParams' => 'required|string'
        ]);
    }

    /**
     * @test
     * @dataProvider mobileAppCampaignProvider
     * @param Campaign $campaign
     */
    public static function addRelatedAdGroup_MobileAppAdGroup(Campaign $campaign): void
    {
        $adGroup = AdGroup::make()
            ->setName('MobileAppAdGroup')
            ->setRegionIds([225])
            ->setNegativeKeywords(['negative','keywords'])
            ->setTrackingParams('from=direct&ad={ad_id}')
            ->setMobileAppAdGroup(
                MobileAppAdGroup::make()
                    ->setStoreUrl('https://play.google.com/store/apps/details?id=ru.yandex.direct')
                    ->setTargetDeviceType(['DEVICE_TYPE_MOBILE','DEVICE_TYPE_TABLET'])
                    ->setTargetCarrier('WI_FI_AND_CELLULAR')
                    ->setTargetOperatingSystemVersion('2.3')
            );

        $result = $campaign->addRelatedAdGroups($adGroup);

        // [ Post processing ]

        Checklists::checkResource($result, AdGroups::class, [
            'Id' => 'required|integer',
            'CampaignId' => 'required|integer',
            'Name' => 'required|string',
            'RegionIds' => 'required|array_of:integer',
            'NegativeKeywords.Items' => 'required|array_of:string',
            'TrackingParams' => 'required|string'
        ]);
    }

    /**
     * @test
     * @dataProvider cpmBannerCampaignProvider
     * @param Campaign $campaign
     */
    public static function addRelatedAdGroup_CpmBannerKeywordsAdGroup(Campaign $campaign): void
    {
        $adGroup = AdGroup::make()
            ->setName('CpmBannerKeywordsAdGroup')
            ->setRegionIds([225])
            ->setNegativeKeywords(['negative','keywords'])
            ->setTrackingParams('from=direct&ad={ad_id}')
            ->setCpmBannerKeywordsAdGroup();

        $result = $campaign->addRelatedAdGroups($adGroup);

        // [ Post processing ]

        Checklists::checkResource($result, AdGroups::class, [
            'Id' => 'required|integer',
            'CampaignId' => 'required|integer',
            'Name' => 'required|string',
            'RegionIds' => 'required|array_of:integer',
            'NegativeKeywords.Items' => 'required|array_of:string',
            'TrackingParams' => 'required|string',
            'CpmBannerKeywordsAdGroup' => 'required'
        ]);
    }

    /**
     * @test
     * @dataProvider cpmBannerCampaignProvider
     * @param Campaign $campaign
     */
    public static function addRelatedAdGroup_CpmBannerUserProfileAdGroup(Campaign $campaign): void
    {
        $adGroup = AdGroup::make()
            ->setName('CpmBannerUserProfileAdGroup')
            ->setRegionIds([225])
            ->setTrackingParams('from=direct&ad={ad_id}')
            ->setCpmBannerUserProfileAdGroup();

        $result = $campaign->addRelatedAdGroups($adGroup);

        // [ Post processing ]

        Checklists::checkResource($result, AdGroups::class, [
            'Id' => 'required|integer',
            'CampaignId' => 'required|integer',
            'Name' => 'required|string',
            'RegionIds' => 'required|array_of:integer',
            'TrackingParams' => 'required|string',
            'CpmBannerUserProfileAdGroup' => 'required'
        ]);
    }

    /**
     * @test
     * @dataProvider cpmBannerCampaignProvider
     * @param Campaign $campaign
     */
    public static function addRelatedAdGroup_CpmVideoAdGroup(Campaign $campaign): void
    {
        $adGroup = AdGroup::make()
            ->setName('CpmVideoAdGroup')
            ->setRegionIds([225])
            ->setTrackingParams('from=direct&ad={ad_id}')
            ->setCpmVideoAdGroup();

        $result = $campaign->addRelatedAdGroups($adGroup);

        // [ Post processing ]

        Checklists::checkResource($result, AdGroups::class, [
            'Id' => 'required|integer',
            'CampaignId' => 'required|integer',
            'Name' => 'required|string',
            'RegionIds' => 'required|array_of:integer',
            'TrackingParams' => 'required|string',
            'CpmVideoAdGroup' => 'required'
        ]);
    }

    /**
     * @test
     * @dataProvider campaignProvider
     * @depends addRelatedAdGroup_TextAdGroup
     * @depends addRelatedAdGroup_DynamicTextAdGroup
     * @depends addRelatedAdGroup_MobileAppAdGroup
     * @depends addRelatedAdGroup_CpmBannerKeywordsAdGroup
     * @depends addRelatedAdGroup_CpmBannerUserProfileAdGroup
     * @depends addRelatedAdGroup_CpmVideoAdGroup
     * @param Campaign $campaign
     */
    public static function getRelatedAdGroups(Campaign $campaign): void
    {
        $adGroups = $campaign->getRelatedAdGroups(['Id', 'Name']);

        // [ Post processing ]

        Checklists::checkModelCollection($adGroups, AdGroups::class, [
            'Id' => 'required|integer',
            'Name' => 'required|string',
        ]);
    }

    /**
     * @test
     * @dataProvider textCampaignHPMCProvider
     * @depends addRelatedAdGroup_TextAdGroup
     * @param Campaign $campaign
     */
    public static function getRelatedAds(Campaign $campaign): void
    {
        $ads = $campaign->getRelatedAds(['Id','TextAd.Title']);

        // [ Post processing ]

        Checklists::checkModelCollection($ads, Ads::class, [
            'Id' => 'required|integer',
            'TextAd.Title' => 'required|string',
        ]);
    }

    /**
     * @test
     * @dataProvider textCampaignHPMCProvider
     * @depends addRelatedAdGroup_TextAdGroup
     * @param Campaign $campaign
     */
    public static function addRelatedBidModifiers(Campaign $campaign): void
    {
        $bidModifier = BidModifier::make()
            ->setRegionalAdjustment(
                RegionalAdjustment::make()
                    ->setRegionId(225)
                    ->setBidModifier(50)
            );

        $result = $campaign->addRelatedBidModifiers($bidModifier);

        // [ Post processing ]

        Checklists::checkResource($result, BidModifiers::class, [
            'Id' => 'required|integer',
            'CampaignId' => 'required|integer',
            'RegionalAdjustment.RegionId' => 'required|integer',
            'RegionalAdjustment.BidModifier' => 'required|integer'
        ]);
    }

    /**
     * @test
     * @dataProvider textCampaignHPMCProvider
     * @depends addRelatedAdGroup_TextAdGroup
     * @depends addRelatedBidModifiers
     * @param Campaign $campaign
     */
    public static function getRelatedBidModifiers(Campaign $campaign): void
    {
        $bidModifiers = $campaign->getRelatedBidModifiers([
            'Id',
            'CampaignId',
            'RegionalAdjustment.RegionId',
            'RegionalAdjustment.BidModifier'
        ]);

        // [ Post processing ]

        Checklists::checkModelCollection($bidModifiers, BidModifiers::class, [
            'Id' => 'required|integer',
            'CampaignId' => 'required|integer',
            'RegionalAdjustment.RegionId' => 'required|integer',
            'RegionalAdjustment.BidModifier' => 'required|integer'
        ]);
    }

    /**
     * @test
     * @dataProvider textCampaignHPMCProvider
     * @depends addRelatedAdGroup_TextAdGroup
     * @depends addRelatedBidModifiers
     * @param Campaign $campaign
     */
    public static function disableBidModifiers(Campaign $campaign): void
    {
        $result = $campaign->disableBidModifiers('REGIONAL_ADJUSTMENT');

        // [ Post processing ]

        Checklists::checkResource($result, BidModifierToggles::class);
        sleep(10);
    }

    /**
     * @test
     * @dataProvider textCampaignHPMCProvider
     * @depends addRelatedAdGroup_TextAdGroup
     * @depends addRelatedBidModifiers
     * @param Campaign $campaign
     */
    public static function enableBidModifiers(Campaign $campaign): void
    {
        $result = $campaign->enableBidModifiers('REGIONAL_ADJUSTMENT');

        // [ Post processing ]

        Checklists::checkResource($result, BidModifierToggles::class);
        sleep(10);
    }

    /**
     * @test
     * @dataProvider textCampaignHPMCProvider
     * @depends addRelatedAdGroup_TextAdGroup
     * @param Campaign $campaign
     */
    public static function getRelatedAudienceTarget(Campaign $campaign): void
    {
        $audienceTargets = $campaign->getRelatedAudienceTargets(['Id','AdGroupId','State']);

        // [ Post processing ]

        Checklists::checkModelCollection($audienceTargets, AudienceTargets::class);

        Env::useLocalApi(true);
        $audienceTargets = $campaign->getRelatedAudienceTargets(['Id','AdGroupId','State']);
        Env::useLocalApi(false);

        Checklists::checkModelCollection($audienceTargets, AudienceTargets::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'CampaignId' => 'required|integer',
            'RetargetingListId' => 'required|integer',
            'InterestId' => 'required|integer',
            'State' => 'required|string',
            'ContextBid' => 'required|integer',
            'StrategyPriority' => 'required|string'
        ]);
    }

    /**
     * @test
     * @dataProvider textCampaignHPMCProvider
     * @depends addRelatedAdGroup_TextAdGroup
     * @param Campaign $campaign
     */
    public static function setRelatedBids(Campaign $campaign): void
    {
        $result = $campaign->setRelatedBids(30000000, 10000000);

        // [ Post processing ]

        Checklists::checkResource($result, Bids::class, [
            'CampaignId' => 'required|integer',
            'Bid' => 'required|integer',
            'ContextBid' => 'required|integer'
        ]);
    }

    /**
     * @test
     * @dataProvider textCampaignHPMCProvider
     * @depends addRelatedAdGroup_TextAdGroup
     * @param Campaign $campaign
     */
    public static function setRelatedContextBids(Campaign $campaign): void
    {
        $result = $campaign->setRelatedContextBids(10000000);

        // [ Post processing ]

        Checklists::checkResource($result, Bids::class, [
            'CampaignId' => 'required|integer',
            'ContextBid' => 'required|integer'
        ]);
    }

    /**
     * @test
     * @dataProvider textCampaignHPMCProvider
     * @depends addRelatedAdGroup_TextAdGroup
     * @depends setRelatedBids
     * @depends setRelatedContextBids
     * @param Campaign $campaign
     */
    public static function getRelatedBids(Campaign $campaign): void
    {
        $bids = $campaign->getRelatedBids(['Bid','CampaignId','AdGroupId','KeywordId']);

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
     * @dataProvider textCampaignMCNDProvider
     * @depends addRelatedAdGroup_TextAdGroup
     * @param Campaign $campaign
     */
    public static function setRelatedStrategyPriority(Campaign $campaign): void
    {
        $result = $campaign->setRelatedStrategyPriority('LOW');

        // [ Post processing ]

        Checklists::checkResource($result, Bids::class, [
            'CampaignId' => 'required|integer',
            'StrategyPriority' => 'required|string'
        ]);
    }

    /**
     * @test
     * @dataProvider textCampaignHPMCProvider
     * @depends addRelatedAdGroup_TextAdGroup
     * @param Campaign $campaign
     */
    public static function setRelatedBidsAuto(Campaign $campaign): void
    {
        $bidAuto = BidAuto::make()
            ->setScope(['SEARCH'])
            ->setPosition('PREMIUMBLOCK');

        $result = $campaign->setRelatedBidsAuto($bidAuto);

        // [ Post processing ]

        Checklists::checkResource($result, BidsAuto::class, [
            'CampaignId' => 'required|integer',
            'Scope' => 'required|array',
            'Position' => 'string'
        ]);
    }

    /**
     * @test
     * @dataProvider textCampaignHPMCProvider
     * @depends addRelatedAdGroup_TextAdGroup
     * @param Campaign $campaign
     */
    public static function getRelatedKeywords(Campaign $campaign): void
    {
        $keywords = $campaign->getRelatedKeywords(['Id','Keyword','Status']);

        // [ Post processing ]

        Checklists::checkModelCollection($keywords, Keywords::class, [
            'Id' => 'required|integer',
            'Keyword' => 'required|string',
            'Status' => 'required|string'
        ]);
    }

    /**
     * @test
     * @dataProvider dynamicTextCampaignProvider
     * @depends addRelatedAdGroup_DynamicTextAdGroup
     * @param Campaign $campaign
     */
    public static function getRelatedWebpages(Campaign $campaign): void
    {
        // [ Pre processing ]

        $adGroup = AdGroup::make()
            ->setName('Test')
            ->setCampaignId($campaign->id)
            ->setRegionIds([225])
            ->setDynamicTextAdGroup(
                DynamicTextAdGroup::make()
                    ->setDomainUrl('yandex.ru')
            );

        Checklists::checkResource(
            $adGroup->create(),
            AdGroups::class
        );

        Checklists::checkResource(
            $adGroup->addRelatedWebpages(
                Webpage::make()
                    ->setName('MyTargetingCondition')
                    ->setConditions(
                        WebpageConditions::make(
                            WebpageCondition::domainContain(['mysite.com']),
                            WebpageCondition::pageNotContain(['home', 'main'])
                        )
                    )
            ),
            Webpages::class
        );

        // [ Example ]

        $webpages = $campaign->getRelatedWebpages([
            'Id',
            'Name',
            'CampaignId',
            'AdGroupId',
            'Conditions'
        ]);

        // [ Post processing ]

        Checklists::checkModelCollection($webpages, Webpages::class, [
            'Id' => 'required|integer',
            'AdGroupId' => 'required|integer',
            'Name' => 'string',
            'Conditions' => 'required|size:2',
            'Conditions.*.Operand' => 'required|string',
            'Conditions.*.Operator' => 'required|string',
            'Conditions.*.Arguments' => 'required|array_of:string'
        ]);
    }
}