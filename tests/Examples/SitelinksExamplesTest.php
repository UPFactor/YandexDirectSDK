<?php


namespace YandexDirectSDKTest\Examples;


use PHPUnit\Framework\TestCase;
use YandexDirectSDK\Collections\Sitelinks;
use YandexDirectSDK\Collections\SitelinksSets;
use YandexDirectSDK\Components\Data;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\ModelCollectionException;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Models\Sitelink;
use YandexDirectSDK\Models\SitelinksSet;
use YandexDirectSDK\Session;
use YandexDirectSDKTest\Helpers\SessionTools;

class SitelinksExamplesTest extends TestCase
{
    /**
     * @var Session
     */
    protected static $session;

    /**
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public static function setUpBeforeClass():void
    {
        self::$session = SessionTools::init();

        $sitelinksSets = self::$session->getSitelinksService()->query()
            ->select('Id','Sitelinks')
            ->get();

        $sitelinksSets = $sitelinksSets->getResource()->filter(function(SitelinksSet $sitelinksSet){
            foreach ($sitelinksSet->getSitelinks()->toArray() as $item){
                if (strpos($item['Href'], 'https://mysite.com/demo-page') !== false){
                    return true;
                }
            }
            return false;
        });

        $sitelinksSets->isNotEmpty(function(SitelinksSets $sitelinksSets){
            $sitelinksSets->delete();
        });
    }

    public static function tearDownAfterClass():void
    {
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
     * @return SitelinksSets
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testAddSitelinks_byService(){
        $session = self::$session;

        // Demo =====================================================================

        /**
         * Create SitelinksSet model and add a collection of links to it.
         * @var SitelinksSet $sitelinkSet
         */
        $sitelinksSet = SitelinksSet::make()->setSitelinks(
            Sitelinks::make(
                Sitelink::make()
                    ->setTitle('My first link')
                    ->setDescription('My first link description')
                    ->setHref('https://mysite.com/demo-page1'),
                Sitelink::make()
                    ->setTitle('My second link')
                    ->setDescription('My second link description')
                    ->setHref('https://mysite.com/demo-page2')
            )
        );

        /**
         * Add SitelinksSet to Yandex.Direct.
         * @var Session $session
         * @var SitelinksSet $sitelinkSet
         * @var Result $result
         */
        $result = $session->getSitelinksService()->add($sitelinksSet);

        /**
         * Convert result to array.
         * @var array $array
         */
        $array = $result->getData()->all();

        /**
         * Convert result to data object.
         * @var Data $data
         */
        $data = $result->getData();

        /**
         * Convert result to SitelinksSets collection.
         * @var SitelinksSets $sitelinksSets
         */
        $sitelinksSets = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(SitelinksSets::class, $sitelinksSets);

        return $sitelinksSets;
    }

    /**
     * @depends testAddSitelinks_byService
     *
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testAddSitelinks_byModel(){
        $session = self::$session;

        // Demo =====================================================================

        /**
         * Create SitelinksSet model and add a collection of links to it.
         * @var SitelinksSet $sitelinkSet
         */
        $sitelinksSet = SitelinksSet::make()->setSitelinks(
            Sitelinks::make(
                Sitelink::make()
                    ->setTitle('My first link')
                    ->setDescription('My first link description')
                    ->setHref('https://mysite.com/demo-page3'),
                Sitelink::make()
                    ->setTitle('My second link')
                    ->setDescription('My second link description')
                    ->setHref('https://mysite.com/demo-page4')
            )
        );

        /**
         * Associate a SitelinksSet model with a session.
         * @var SitelinksSet $sitelinkSet
         * @var Session $session
         */
        $sitelinksSet->setSession($session);

        /**
         * Add SitelinksSet to Yandex.Direct.
         * @var Result $result
         */
        $result = $sitelinksSet->add();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(SitelinksSet::class, $sitelinksSet);
        $this->assertNotNull($sitelinksSet->id);
    }

    /**
     * @depends testAddSitelinks_byService
     *
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testAddSitelinks_byCollection(){
        $session = self::$session;

        // Demo =====================================================================

        /**
         * Create a collection of multiple sets of links.
         * @var SitelinksSets $sitelinksSets
         */
        $sitelinksSets = SitelinksSets::make(
            //First set of links
            SitelinksSet::make()->setSitelinks(
                Sitelinks::make(
                    Sitelink::make()
                        ->setTitle('My first link')
                        ->setDescription('My first link description')
                        ->setHref('https://mysite.com/demo-page5'),
                    Sitelink::make()
                        ->setTitle('My second link')
                        ->setDescription('My second link description')
                        ->setHref('https://mysite.com/demo-page6')
                )
            ),
            //Second set of links
            SitelinksSet::make()->setSitelinks(
                Sitelinks::make(
                    Sitelink::make()
                        ->setTitle('My another first link')
                        ->setDescription('My another first link description')
                        ->setHref('https://mysite.com/demo-page7'),
                    Sitelink::make()
                        ->setTitle('My another second link')
                        ->setDescription('My another second link description')
                        ->setHref('https://mysite.com/demo-page8')
                )
            )
        );

        /**
         * Associate a collection of link sets with a session.
         * @var SitelinksSets $sitelinksSets
         * @var Session $session
         */
        $sitelinksSets->setSession($session);

        /**
         * Add link sets to Yandex.Direct.
         * @var SitelinksSets $sitelinksSets
         * @var Result $result
         */
        $result = $sitelinksSets->add();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertInstanceOf(SitelinksSets::class, $sitelinksSets);
        $this->assertNotNull($sitelinksSets->first()->{'id'});
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Get
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddSitelinks_byService
     *
     * @return SitelinksSets
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testGetSitelinks_byService(){
        $session = self::$session;

        // Demo =====================================================================

        /**
         * Getting a list of result.
         * @var Result $result
         */
        $result = $session->getSitelinksService()->query()
            ->select(['Id','Sitelinks'])
            ->get();

        /**
         * Convert result to array.
         * @var array $array
         */
        $array = $result->getData()->all();

        /**
         * Convert result to data object.
         * @var Data $data
         */
        $data = $result->getData();

        /**
         * Convert result to SitelinksSets collection.
         * @var SitelinksSets $sitelinksSets
         */
        $sitelinksSets = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(SitelinksSets::class, $sitelinksSets);

        return $sitelinksSets;
    }

    /**
     * @depends testAddSitelinks_byService
     *
     * @return SitelinksSets
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testGetSitelinks_byModel(){
        $session = self::$session;

        // Demo =====================================================================

        /**
         * Getting a list of result.
         * @var Result $result
         */
        $result = SitelinksSet::make()->setSession($session)->query()
            ->select(['Id','Sitelinks'])
            ->get();

        /**
         * Convert result to array.
         * @var array $array
         */
        $array = $result->getData()->all();

        /**
         * Convert result to data object.
         * @var Data $data
         */
        $data = $result->getData();

        /**
         * Convert result to SitelinksSets collection.
         * @var SitelinksSets $sitelinksSets
         */
        $sitelinksSets = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(SitelinksSets::class, $sitelinksSets);

        return $sitelinksSets;
    }

    /**
     * @depends testAddSitelinks_byService
     *
     * @return SitelinksSets
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws RuntimeException
     */
    public function testGetSitelinks_byCollection(){
        $session = self::$session;

        // Demo =====================================================================

        /**
         * Getting a list of result.
         * @var Result $result
         */
        $result = SitelinksSets::make()->setSession($session)->query()
            ->select(['Id','Sitelinks'])
            ->get();

        /**
         * Convert result to array.
         * @var array $array
         */
        $array = $result->getData()->all();

        /**
         * Convert result to data object.
         * @var Data $data
         */
        $data = $result->getData();

        /**
         * Convert result to SitelinksSets collection.
         * @var SitelinksSets $sitelinksSets
         */
        $sitelinksSets = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(SitelinksSets::class, $sitelinksSets);

        return $sitelinksSets;
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Delete
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @depends testAddSitelinks_byService
     *
     * @param SitelinksSets $sitelinksSets
     */
    public function testDeleteSitelinks(SitelinksSets $sitelinksSets){

        // Demo =====================================================================

        /**
         * @var SitelinksSets $sitelinksSets
         */
        $result = $sitelinksSets->delete();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
    }
}