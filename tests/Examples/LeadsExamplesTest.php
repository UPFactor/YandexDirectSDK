<?php


namespace YandexDirectSDKTest\Examples;


use PHPUnit\Framework\TestCase;
use YandexDirectSDK\Collections\Leads;
use YandexDirectSDK\Components\Data;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\ModelCollectionException;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Models\Lead;
use YandexDirectSDK\Session;
use YandexDirectSDKTest\Helpers\SessionTools;

/**
 * Class KeywordsExamplesTest
 * @package YandexDirectSDKTest\Examples
 */
class LeadsExamplesTest extends TestCase
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
     * @return Leads
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testGetLeads_byService(){
        $session = self::$session;

        // Demo =====================================================================

        /**
         * Getting a list of result.
         *
         * @var Result $result
         */
        $result = $session->getLeadsService()->query()
            ->select('Id','SubmittedAt','TurboPageId','TurboPageName','Data')
            ->where('DateTimeFrom', date('c', strtotime('2019-01-01')))
            ->where('DateTimeTo', date('c', strtotime('2019-01-31')))
            ->whereIn('TurboPageIds', [234234435,5656564])
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
         * Convert result to Leads collection.
         *
         * @var Leads $leads
         */
        $leads = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(Leads::class, $leads);

        return $leads;
    }

    /**
     * @return Leads
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testGetLeads_byModel(){
        $session = self::$session;

        // Demo =====================================================================

        /**
         * Getting a list of result.
         *
         * @var Result $result
         */
        $result = Lead::make()->setSession($session)->query()
            ->select('Id','SubmittedAt','TurboPageId','TurboPageName','Data')
            ->where('DateTimeFrom', date('c', strtotime('2019-01-01')))
            ->where('DateTimeTo', date('c', strtotime('2019-01-31')))
            ->whereIn('TurboPageIds', [234234435,5656564])
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
         * Convert result to Leads collection.
         *
         * @var Leads $leads
         */
        $leads = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(Leads::class, $leads);

        return $leads;
    }

    /**
     * @return Leads
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws RuntimeException
     */
    public function testGetLeads_byCollection(){
        $session = self::$session;

        // Demo =====================================================================

        /**
         * Getting a list of result.
         *
         * @var Result $result
         */
        $result = Leads::make()->setSession($session)->query()
            ->select('Id','SubmittedAt','TurboPageId','TurboPageName','Data')
            ->where('DateTimeFrom', date('c', strtotime('2019-01-01')))
            ->where('DateTimeTo', date('c', strtotime('2019-01-31')))
            ->whereIn('TurboPageIds', [234234435,5656564])
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
         * @var Leads $leads
         */
        $leads = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(Leads::class, $leads);

        return $leads;
    }
}