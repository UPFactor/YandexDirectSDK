<?php


namespace YandexDirectSDKTest\Examples;


use PHPUnit\Framework\TestCase;
use YandexDirectSDK\Collections\AdGroups;
use YandexDirectSDK\Collections\Bids;
use YandexDirectSDK\Collections\BidsAuto;
use YandexDirectSDK\Collections\Campaigns;
use YandexDirectSDK\Collections\Keywords;
use YandexDirectSDK\Collections\TurboPages;
use YandexDirectSDK\Components\Data;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\ModelCollectionException;
use YandexDirectSDK\Exceptions\RequestException;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Exceptions\ServiceException;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\BidAuto;
use YandexDirectSDK\Models\Campaign;
use YandexDirectSDK\Models\Keyword;
use YandexDirectSDK\Models\TurboPage;
use YandexDirectSDK\Session;
use YandexDirectSDKTest\Helpers\SessionTools;

/**
 * Class KeywordsExamplesTest
 * @package YandexDirectSDKTest\Examples
 */
class TurboPagesExamplesTest extends TestCase
{

    /**
     * @var Session
     */
    public static $session;

    public static function setUpBeforeClass():void
    {
        self::$session = SessionTools::init();
    }

    public static function tearDownAfterClass():void
    {
        self::$session = null;
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Get
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * @return TurboPages
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testGetTurboPages_byService(){
        $session = self::$session;

        // Demo =====================================================================

        /**
         * Getting a list of result.
         *
         * @var Result $result
         */
        $result = $session->getTurboPagesService()->query()
            ->select('Id','Name')
            ->limit(10)
            ->get();

        /**
         * Convert result to array.
         *
         * @var array $array
         */
        $array = $result->getData()->all();

        /**
         * Convert result to data object.
         *
         * @var Data $data
         */
        $data = $result->getData();

        /**
         * Convert result to TurboPages collection.
         *
         * @var TurboPages $turboPages
         */
        $turboPages = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(TurboPages::class, $turboPages);

        return $turboPages;
    }

    /**
     * @return TurboPages
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testGetTurboPages_byModel(){
        $session = self::$session;

        // Demo =====================================================================

        /**
         * Getting a list of result.
         *
         * @var Result $result
         */
        $result = TurboPage::make()->setSession($session)->query()
            ->select('Id','Name','Href','PreviewHref')
            ->limit(10)
            ->get();

        /**
         * Convert result to array.
         *
         * @var array $array
         */
        $array = $result->getData()->all();

        /**
         * Convert result to data object.
         *
         * @var Data $data
         */
        $data = $result->getData();

        /**
         * Convert result to TurboPages collection.
         *
         * @var TurboPages $turboPages
         */
        $turboPages = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(TurboPages::class, $turboPages);

        return $turboPages;
    }

    /**
     * @return TurboPages
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws RuntimeException
     */
    public function testGetTurboPages_byCollection(){
        $session = self::$session;

        // Demo =====================================================================

        /**
         * Getting a list of result.
         *
         * @var Result $result
         */
        $result = TurboPages::make()->setSession($session)->query()
            ->select('Id','Name','Href','PreviewHref')
            ->limit(10)
            ->get();

        /**
         * Convert result to array.
         *
         * @var array $array
         */
        $array = $result->getData()->all();

        /**
         * Convert result to data object.
         *
         * @var Data $data
         */
        $data = $result->getData();

        /**
         * Convert result to TurboPages collection.
         *
         * @var TurboPages $turboPages
         */
        $turboPages = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(TurboPages::class, $turboPages);

        return $turboPages;
    }
}