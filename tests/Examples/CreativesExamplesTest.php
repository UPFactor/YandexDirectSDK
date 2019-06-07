<?php


namespace YandexDirectSDKTest\Examples;


use PHPUnit\Framework\TestCase;
use YandexDirectSDK\Collections\Creatives;
use YandexDirectSDK\Components\Data;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\ModelCollectionException;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Models\Creative;
use YandexDirectSDK\Session;
use YandexDirectSDKTest\Helpers\SessionTools;

/**
 * Class KeywordsExamplesTest
 * @package YandexDirectSDKTest\Examples
 */
class CreativesExamplesTest extends TestCase
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
     * @return Creatives
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testGetCreatives_byService(){
        $session = self::$session;

        // Demo =====================================================================

        /**
         * Getting a list of result.
         *
         * @var Result $result
         */
        $result = $session->getCreativesService()->query()
            ->select([
                'Id',
                'Type',
                'Name',
                'VideoExtensionCreative.Duration',
                'CpcVideoCreative.Duration'
            ])
            ->whereIn('Types', ['VIDEO_EXTENSION_CREATIVE','CPC_VIDEO_CREATIVE'])
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
         * Convert result to Creatives collection.
         *
         * @var Creatives $creatives
         */
        $creatives = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(Creatives::class, $creatives);

        return $creatives;
    }

    /**
     * @return Creatives
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testGetCreatives_byModel(){
        $session = self::$session;

        // Demo =====================================================================

        /**
         * Getting a list of result.
         *
         * @var Result $result
         */
        $result = Creative::make()->setSession($session)->query()
            ->select([
                'Id',
                'Type',
                'Name',
                'VideoExtensionCreative.Duration',
                'CpcVideoCreative.Duration'
            ])
            ->whereIn('Types', ['VIDEO_EXTENSION_CREATIVE','CPC_VIDEO_CREATIVE'])
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
         * Convert result to Creatives collection.
         *
         * @var Creatives $creatives
         */
        $creatives = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(Creatives::class, $creatives);

        return $creatives;
    }

    /**
     * @return Creatives
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws RuntimeException
     */
    public function testGetCreatives_byCollection(){
        $session = self::$session;

        // Demo =====================================================================

        /**
         * Getting a list of result.
         *
         * @var Result $result
         */
        $result = Creatives::make()->setSession($session)->query()
            ->select([
                'Id',
                'Type',
                'Name',
                'VideoExtensionCreative.Duration',
                'CpcVideoCreative.Duration'
            ])
            ->whereIn('Types', ['VIDEO_EXTENSION_CREATIVE','CPC_VIDEO_CREATIVE'])
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
         * Convert result to Creatives collection.
         *
         * @var Creatives $creatives
         */
        $creatives = $result->getResource();

        // End Demo =====================================================================

        $this->assertTrue($result->errors->isEmpty());
        $this->assertTrue($result->warnings->isEmpty());
        $this->assertIsArray($array);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertInstanceOf(Creatives::class, $creatives);

        return $creatives;
    }
}