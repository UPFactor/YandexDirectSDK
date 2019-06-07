<?php


namespace YandexDirectSDKTest\Examples;


use PHPUnit\Framework\TestCase;
use YandexDirectSDK\Components\Data;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\RequestException;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Session;
use YandexDirectSDKTest\Helpers\SessionTools;

/**
 * Class DictionariesExamplesTest
 * @package YandexDirectSDKTest\Examples
 */
class DictionariesExamplesTest extends TestCase{
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

    /**
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function testCurrencies(){

        $session = self::$session;

        // Demo =====================================================================

        /**
         * @var Session $session
         * @var Data $data
         */
        $data = $session->getDictionariesService()->getCurrencies();

        /**
         * @var Data $data
         * @var array $array
         */
        $array = $data->all();

        // End Demo =====================================================================

        $this->assertInstanceOf(Data::class, $data);
        $this->assertFalse($data->isEmpty());
        $this->assertIsArray($array);
    }

    /**
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function testMetroStations(){

        $session = self::$session;

        // Demo =====================================================================

        /**
         * @var Session $session
         * @var Data $data
         */
        $data = $session->getDictionariesService()->getMetroStations();

        /**
         * @var Data $data
         * @var array $array
         */
        $array = $data->all();

        // End Demo =====================================================================

        $this->assertInstanceOf(Data::class, $data);
        $this->assertFalse($data->isEmpty());
        $this->assertIsArray($array);
    }

    /**
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function testGeoRegions(){

        $session = self::$session;

        // Demo =====================================================================

        /**
         * @var Session $session
         * @var Data $data
         */
        $data = $session->getDictionariesService()->getGeoRegions();

        /**
         * @var Data $data
         * @var array $array
         */
        $array = $data->all();

        // End Demo =====================================================================

        $this->assertInstanceOf(Data::class, $data);
        $this->assertFalse($data->isEmpty());
        $this->assertIsArray($array);
    }

    /**
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function testTimeZones(){

        $session = self::$session;

        // Demo =====================================================================

        /**
         * @var Session $session
         * @var Data $data
         */
        $data = $session->getDictionariesService()->getTimeZones();

        /**
         * @var Data $data
         * @var array $array
         */
        $array = $data->all();

        // End Demo =====================================================================

        $this->assertInstanceOf(Data::class, $data);
        $this->assertFalse($data->isEmpty());
        $this->assertIsArray($array);
    }

    /**
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function testConstants(){

        $session = self::$session;

        // Demo =====================================================================

        /**
         * @var Session $session
         * @var Data $data
         */
        $data = $session->getDictionariesService()->getConstants();

        /**
         * @var Data $data
         * @var array $array
         */
        $array = $data->all();

        // End Demo =====================================================================

        $this->assertInstanceOf(Data::class, $data);
        $this->assertFalse($data->isEmpty());
        $this->assertIsArray($array);
    }

    /**
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function testAdCategories(){

        $session = self::$session;

        // Demo =====================================================================

        /**
         * @var Session $session
         * @var Data $data
         */
        $data = $session->getDictionariesService()->getAdCategories();

        /**
         * @var Data $data
         * @var array $array
         */
        $array = $data->all();

        // End Demo =====================================================================

        $this->assertInstanceOf(Data::class, $data);
        $this->assertFalse($data->isEmpty());
        $this->assertIsArray($array);
    }

    /**
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function testOperationSystemVersions(){

        $session = self::$session;

        // Demo =====================================================================

        /**
         * @var Session $session
         * @var Data $data
         */
        $data = $session
            ->getDictionariesService()
            ->getOperationSystemVersions();

        /**
         * @var Data $data
         * @var array $array
         */
        $array = $data->all();

        // End Demo =====================================================================

        $this->assertInstanceOf(Data::class, $data);
        $this->assertFalse($data->isEmpty());
        $this->assertIsArray($array);
    }

    /**
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function testSupplySidePlatforms(){

        $session = self::$session;

        // Demo =====================================================================

        /**
         * @var Session $session
         * @var Data $data
         */
        $data = $session
            ->getDictionariesService()
            ->getSupplySidePlatforms();

        /**
         * @var Data $data
         * @var array $array
         */
        $array = $data->all();

        // End Demo =====================================================================

        $this->assertInstanceOf(Data::class, $data);
        $this->assertFalse($data->isEmpty());
        $this->assertIsArray($array);
    }

    /**
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function testInterests(){

        $session = self::$session;

        // Demo =====================================================================

        /**
         * @var Session $session
         * @var Data $data
         */
        $data = $session->getDictionariesService()->getInterests();

        /**
         * @var Data $data
         * @var array $array
         */
        $array = $data->all();

        // End Demo =====================================================================

        $this->assertInstanceOf(Data::class, $data);
        $this->assertFalse($data->isEmpty());
        $this->assertIsArray($array);
    }

    /**
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function testAudienceCriteriaTypes(){

        $session = self::$session;

        // Demo =====================================================================

        /**
         * @var Session $session
         * @var Data $data
         */
        $data = $session
            ->getDictionariesService()
            ->getAudienceCriteriaTypes();

        /**
         * @var Data $data
         * @var array $array
         */
        $array = $data->all();

        // End Demo =====================================================================

        $this->assertInstanceOf(Data::class, $data);
        $this->assertFalse($data->isEmpty());
        $this->assertIsArray($array);
    }

    /**
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function testAudienceDemographicProfiles(){

        $session = self::$session;

        // Demo =====================================================================

        /**
         * @var Session $session
         * @var Data $data
         */
        $data = $session
            ->getDictionariesService()
            ->getAudienceDemographicProfiles();

        /**
         * @var Data $data
         * @var array $array
         */
        $array = $data->all();

        // End Demo =====================================================================

        $this->assertInstanceOf(Data::class, $data);
        $this->assertFalse($data->isEmpty());
        $this->assertIsArray($array);
    }

    /**
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function testAudienceInterests(){

        $session = self::$session;

        // Demo =====================================================================

        /**
         * @var Session $session
         * @var Data $data
         */
        $data = $session
            ->getDictionariesService()
            ->getAudienceInterests();

        /**
         * @var Data $data
         * @var array $array
         */
        $array = $data->all();

        // End Demo =====================================================================

        $this->assertInstanceOf(Data::class, $data);
        $this->assertFalse($data->isEmpty());
        $this->assertIsArray($array);
    }

    /**
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function testDictionaries(){

        $session = self::$session;

        // Demo =====================================================================

        /**
         * @var Session $session
         * @var Data $data
         */
        $data = $session
            ->getDictionariesService()
            ->getDictionaries(['Currencies', 'TimeZones']);

        /**
         * @var Data $data
         * @var array $array
         */
        $array = $data->all();

        // End Demo =====================================================================

        $this->assertInstanceOf(Data::class, $data);
        $this->assertFalse($data->isEmpty());
        $this->assertTrue($data->has('Currencies'));
        $this->assertTrue($data->has('TimeZones'));
        $this->assertIsArray($array);
    }
}