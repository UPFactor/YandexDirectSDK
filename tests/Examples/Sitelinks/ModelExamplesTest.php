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
use YandexDirectSDK\Interfaces\Model as ModelInterface;
use YandexDirectSDK\Models\Sitelink;
use YandexDirectSDK\Models\SitelinksSet;
use YandexDirectSDK\Session;
use YandexDirectSDKTest\Helpers\Checklists;
use YandexDirectSDKTest\Helpers\SessionTools;

class ModelExamplesTest extends TestCase
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
    public static $sitelinksSet;

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
        if (!is_null(self::$sitelinksSet)){
            self::$sitelinksSet->delete();
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
     * @return SitelinksSet|ModelInterface
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
         * @var SitelinksSet $sitelinksSet
         */
        $sitelinksSet = SitelinksSet::make()
            ->setSitelinks(
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
            );

        $sitelinksSet->setSession($session);
        $sitelinksSet->add();

        // ==========================================================================

        return self::$sitelinksSet = self::$checklists->checkModel($sitelinksSet, [
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
     * @param SitelinksSet $sitelinksSet
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws ModelException
     * @throws RuntimeException
     */
    public function testGetSitelinks(SitelinksSet $sitelinksSet)
    {
        $session = self::$session;

        // DEMO =====================================================================

        /**
         * @var SitelinksSet $sitelinksSet
         * @var Session $session
         * @var Result $result
         */
        $result = SitelinksSets::make()->setSession($session)->query()
            ->select('Id', 'Sitelinks')
            ->whereIn('Ids', $sitelinksSet->id)
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
     * @param SitelinksSet $sitelinksSet
     * @throws ModelException
     */
    public function testDeleteSitelinks(SitelinksSet $sitelinksSet)
    {
        // DEMO =====================================================================

        /**
         * @var SitelinksSet $sitelinksSet
         * @var Result $result
         */
        $result = $sitelinksSet->delete();

        // ==========================================================================

        self::$checklists->checkResource($result, null);
        self::$sitelinksSet = null;
    }
}