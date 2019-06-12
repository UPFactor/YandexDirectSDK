<?php


namespace YandexDirectSDKTest\Examples\Sitelinks;

use PHPUnit\Framework\TestCase;
use YandexDirectSDK\Collections\Sitelinks;
use YandexDirectSDK\Collections\SitelinksSets;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\ModelCollectionException;
use YandexDirectSDK\Exceptions\ModelException;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Interfaces\ModelCollection as ModelCollectionInterface;
use YandexDirectSDK\Models\Sitelink;
use YandexDirectSDK\Models\SitelinksSet;
use YandexDirectSDK\Session;
use YandexDirectSDKTest\Helpers\Checklists;
use YandexDirectSDKTest\Helpers\SessionTools;

class ServiceExamplesTest extends TestCase
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
     * @var SitelinksSets
     */
    public static $sitelinksSets;

    /*
     |-------------------------------------------------------------------------------
     |
     | Handlers
     |
     |-------------------------------------------------------------------------------
    */

    public static function setUpBeforeClass():void
    {
        self::$checklists = new Checklists();
        self::$session = SessionTools::init();
    }


    public static function tearDownAfterClass():void
    {
        if (!is_null(self::$sitelinksSets)){
            self::$sitelinksSets->delete();
        }

        self::$checklists = null;
        self::$session = null;
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Add
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @return SitelinksSets|ModelCollectionInterface
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     */
    public function testAddSitelinks()
    {
        $session = self::$session;

        // DEMO =====================================================================

        /**
         * @var Session $session
         * @var Result $result
         */
        $result = $session->getSitelinksService()->add(
            SitelinksSet::make()->setSitelinks(
                Sitelinks::make(
                    Sitelink::make()
                        ->setTitle('My first link')
                        ->setDescription('My first link description')
                        ->setHref('https://mysite.com/demo-page-1'),
                    Sitelink::make()
                        ->setTitle('My second link')
                        ->setDescription('My second link description')
                        ->setHref('https://mysite.com/demo-page-2')
                )
            )
        );

        // ==========================================================================

        return self::$sitelinksSets = self::$checklists->checkResource($result, SitelinksSets::class, [
            'Id' => 'integer',
            'Sitelinks.0.Title' => 'string',
            'Sitelinks.0.Description' => 'string',
            'Sitelinks.0.Href' => 'string',
            'Sitelinks.1.Title' => 'string',
            'Sitelinks.1.Description' => 'string',
            'Sitelinks.1.Href' => 'string'
        ]);
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Get
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddSitelinks
     *
     * @param SitelinksSets $sitelinksSets
     * @throws InvalidArgumentException
     * @throws ModelException
     * @throws RuntimeException
     */
    public function testGetSitelinks(SitelinksSets $sitelinksSets)
    {
        $session = self::$session;
        $sitelinksSetIds = $sitelinksSets->extract('id');

        // DEMO =====================================================================

        /**
         * @var array $sitelinksSetIds
         * @var Session $session
         * @var Result $result
         */
        $result = $session->getSitelinksService()->query()
            ->select('Id', 'Sitelinks')
            ->whereIn('Ids', $sitelinksSetIds)
            ->get();

        // ==========================================================================

        self::$checklists->checkResource($result, SitelinksSets::class, [
            'Id' => 'integer',
            'Sitelinks.0.Title' => 'string',
            'Sitelinks.0.Description' => 'string',
            'Sitelinks.0.Href' => 'string',
            'Sitelinks.1.Title' => 'string',
            'Sitelinks.1.Description' => 'string',
            'Sitelinks.1.Href' => 'string'
        ]);
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Delete
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddSitelinks
     *
     * @param SitelinksSets $sitelinksSets
     * @throws ModelException
     */
    public function testDeleteSitelinks(SitelinksSets $sitelinksSets)
    {
        $session = self::$session;
        $sitelinksSetIds = $sitelinksSets->extract('id');

        // DEMO =====================================================================

        /**
         * @var array $sitelinksSetIds
         * @var Session $session
         * @var Result $result
         */
        $result = $session
            ->getSitelinksService()
            ->delete($sitelinksSetIds);

        // ==========================================================================

        self::$checklists->checkResource($result, null);
        self::$sitelinksSets = null;
    }
}