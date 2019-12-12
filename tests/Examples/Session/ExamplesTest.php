<?php

namespace YandexDirectSDKTest\Examples\Session;

use Exception;
use PHPUnit\Framework\TestCase;
use YandexDirectSDK\Collections\AdGroups;
use YandexDirectSDK\Collections\Campaigns;
use YandexDirectSDK\Collections\Keywords;
use YandexDirectSDK\Components\Data;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\Campaign;
use YandexDirectSDK\Models\TextCampaign;
use YandexDirectSDK\Models\TextCampaignNetworkStrategy;
use YandexDirectSDK\Models\TextCampaignSearchStrategy;
use YandexDirectSDK\Models\TextCampaignStrategy;
use YandexDirectSDK\Services\CampaignsService;
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

    /**
     * @test
     * @return void
     */
    public static function call():void
    {

        $result = Session::call('campaigns', 'get', [
            'SelectionCriteria' => [
                'Types' => ['TEXT_CAMPAIGN'],
            ],
            'FieldNames' => ['Id', 'Name', 'State'],
            'TextCampaignFieldNames' => ['BiddingStrategy', 'Settings'],
            'Page' => [
                'Limit' => 10,
                'Offset' => 0
            ]
        ]);

        print_r($result->data->toArray());

        // [ Post processing ]

        //print_r($result);
    }

    public static function getCampaignsByService()
    {
        /**
         * Получаем коллекцию моделей YandexDirectSDK\Collections\Campaigns,
         * отвечающие заданным условиям.
         *
         * @var Campaigns $campaigns
         */
        $campaigns = CampaignsService::query()
            ->select('Id', 'Name', 'Type', 'State')
            ->whereIn('Types', ['TEXT_CAMPAIGN'])
            ->whereIn('States', ['ON'])
            ->get();

        /**
         * Останавливаем показы рекламных объявлений
         * для всех полученных кампаний.
         */

        CampaignsService::suspend($campaigns);
    }

    /**
     * @test
     * @throws Exception
     */
    public static function createCampaign()
    {
        //Создание рекламной кампании «Текстово-графические объявления»
        Campaign::make()
            ->setName('TextCampaign')
            ->setStartDate('2029-10-01')
            ->setEndDate('2029-10-10')
            ->setNegativeKeywords(['set', 'negative', 'keywords'])
            ->setTextCampaign(
                TextCampaign::make()
                    ->setBiddingStrategy(
                        TextCampaignStrategy::make()
                            ->setSearch(
                                TextCampaignSearchStrategy::make()
                                    ->setBiddingStrategyType('HIGHEST_POSITION')
                            )
                            ->setNetwork(
                                TextCampaignNetworkStrategy::make()
                                    ->setBiddingStrategyType('MAXIMUM_COVERAGE')
                            )
                    )
            )
            ->create()
            ->forSuccessfulResource(function(Campaigns $campaigns){
                $result = $campaigns->addRelatedAdGroups(
                    AdGroups::wrap([
                        AdGroup::make()
                            ->setName('TextGroup 1')
                            ->setRegionIds([225])
                            ->setTrackingParams('from=direct&ad={ad_id}'),
                        AdGroup::make()
                            ->setName('TextGroup 2')
                            ->setRegionIds([2255])
                            ->setNegativeKeywords(['set','negative','keywords'])
                    ])
                );

                $result->forSuccessfulResource(function(AdGroups $adGroups){
                    $adGroups
                        ->addRelatedKeywords(['keyword1','keyword2','keyword3'])
                        ->forFailedResource(function(Keywords $keywords, Data $errors){
                            //...
                        });
                });

                $result->forFailedResource(function(AdGroups $adGroups, Data $errors){
                    //...
                });
            });
    }
}