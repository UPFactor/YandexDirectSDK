<?php


namespace YandexDirectSDKTest\Examples;

use PHPUnit\Framework\TestCase;
use YandexDirectSDK\Collections\AdGroups;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\ModelCollectionException;
use YandexDirectSDK\Models\AdGroup;

class ModelCollectionExamplesTest extends TestCase
{

    public function getAdGroupsModels()
    {
        return [
            AdGroup::make()
                ->setCampaignId(5565)
                ->setName('MyAdGroup_1')
                ->setRegionIds([225])
                ->setNegativeKeywords(['Negative', 'Keywords']),

            AdGroup::make()
                ->setCampaignId(5565)
                ->setName('MyAdGroup_2')
                ->setRegionIds([225])
                ->setNegativeKeywords(['Negative', 'Keywords']),

            AdGroup::make()
                ->setCampaignId(5565)
                ->setName('MyAdGroup_3')
                ->setRegionIds([225])
        ];
    }


    public function modelsDataProvider()
    {
        return ['YandexDirectSDK\Collections\AdGroups' => $this->getAdGroupsModels()];
    }


    public function collectionDataProvider()
    {
        $models = $this->modelsDataProvider();
        $collections = [];

        foreach ($models as $collectionClass => $content){
            $collections[] = [new $collectionClass($content)];
        }

        return $collections;
    }

    /**
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testNew()
    {
        list($adGroup1, $adGroup2, $adGroup3) = $this->getAdGroupsModels();

        // Demo =====================================================================

        $adGroupCollection = new AdGroups([$adGroup1, $adGroup2, $adGroup3]);

        // End Demo =================================================================

        $this->assertInstanceOf(AdGroups::class, $adGroupCollection);
        $this->assertSame([$adGroup1, $adGroup2, $adGroup3], $adGroupCollection->all());
    }

    /**
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testWrap()
    {
        list($adGroup1, $adGroup2, $adGroup3) = $this->getAdGroupsModels();

        // Demo =====================================================================

        $adGroupCollection = AdGroups::wrap([$adGroup1, $adGroup2, $adGroup3]);

        // End Demo =================================================================

        $this->assertInstanceOf(AdGroups::class, $adGroupCollection);
        $this->assertSame([$adGroup1, $adGroup2, $adGroup3], $adGroupCollection->all());
    }

    /**
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testMake()
    {
        list($adGroup1, $adGroup2, $adGroup3) = $this->getAdGroupsModels();

        // Demo =====================================================================

        $adGroupCollection = AdGroups::make($adGroup1, $adGroup2, $adGroup3);

        // End Demo =================================================================

        $this->assertInstanceOf(AdGroups::class, $adGroupCollection);
        $this->assertSame([$adGroup1, $adGroup2, $adGroup3], $adGroupCollection->all());
    }

    /**
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testInsert()
    {
        // Demo =====================================================================

        $rawCollection = [
            [
                'Name' => 'MyAdGroup_1',
                'CampaignId' => 5565,
                'RegionIds' => [225],
                'NegativeKeywords' => [
                    'Items' => ['Negative', 'Keywords']
                ]
            ],
            [
                'Name' => 'MyAdGroup_2',
                'CampaignId' => 5565,
                'RegionIds' => [225],
                'NegativeKeywords' => [
                    'Items' => ['Negative', 'Keywords']
                ]
            ],
            [
                'Name' => 'MyAdGroup_3',
                'CampaignId' => 5565,
                'RegionIds' => [225]
            ]
        ];

        $adGroupCollection = AdGroups::make()->insert($rawCollection);

        // End Demo =================================================================

        $this->assertSame(
            $adGroupCollection->toArray(),
            $rawCollection
        );
    }

    /**
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testAll()
    {
        list($adGroup1, $adGroup2, $adGroup3) = $this->getAdGroupsModels();

        // Demo =====================================================================

        $adGroupCollection = AdGroups::wrap([$adGroup1, $adGroup2, $adGroup3]);
        $adGroupCollection->all(); // array of AdGroup models

        // End Demo =================================================================

        $this->assertEquals($this->getAdGroupsModels(), $adGroupCollection->all());
    }

    /**
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testCount()
    {
        list($adGroup1, $adGroup2, $adGroup3) = $this->getAdGroupsModels();

        // Demo =====================================================================

        $adGroupCollection = AdGroups::wrap([$adGroup1, $adGroup2, $adGroup3]);
        $adGroupCollection->count(); // 3

        // End Demo =================================================================

        $this->assertEquals(3, $adGroupCollection->count());
    }

    /**
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testIsEmpty()
    {
        list($adGroup1, $adGroup2, $adGroup3) = $this->getAdGroupsModels();

        // Demo =====================================================================

        $adGroupCollectionEmpty = AdGroups::wrap([]);
        $adGroupCollectionFull = AdGroups::wrap([$adGroup1, $adGroup2, $adGroup3]);

        $adGroupCollectionEmpty->isEmpty(); // true
        $adGroupCollectionFull->isEmpty(); // false

        // End Demo =================================================================

        $this->assertTrue($adGroupCollectionEmpty->isEmpty());
        $this->assertFalse($adGroupCollectionFull->isEmpty());
    }

    /**
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testIsEmpty_CallbackFunction()
    {
        // Demo =====================================================================

        $adGroupCollection = AdGroups::wrap([]);

        $adGroupCollection->isEmpty(function(AdGroups $collection){
            $model = AdGroup::make()
                ->setCampaignId(5565)
                ->setName('MyAdGroup')
                ->setRegionIds([225]);

            $collection->push($model);
        });

        $adGroupCollection->isEmpty(); // false;
        $adGroupCollection->count(); // 1;

        // End Demo =================================================================

        $this->assertFalse($adGroupCollection->isEmpty());
        $this->assertEquals(1, $adGroupCollection->count());
    }

    /**
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testIsNotEmpty()
    {
        list($adGroup1, $adGroup2, $adGroup3) = $this->getAdGroupsModels();

        // Demo =====================================================================

        $adGroupCollectionEmpty = AdGroups::wrap([]);
        $adGroupCollectionFull = AdGroups::wrap([$adGroup1, $adGroup2, $adGroup3]);

        $adGroupCollectionEmpty->isNotEmpty(); // false
        $adGroupCollectionFull->isNotEmpty(); // true

        // End Demo =================================================================

        $this->assertFalse($adGroupCollectionEmpty->isNotEmpty());
        $this->assertTrue($adGroupCollectionFull->isNotEmpty());
    }

    /**
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testIsNotEmpty_CallbackFunction()
    {
        list($adGroup1, $adGroup2, $adGroup3) = $this->getAdGroupsModels();

        //Demo =====================================================================

        $adGroupCollection = AdGroups::wrap([$adGroup1, $adGroup2, $adGroup3]);

        $adGroupCollection->isNotEmpty(function(AdGroups $collection){
            $collection->reset();
        });

        $adGroupCollection->isNotEmpty(); //false

        // End Demo =================================================================

        $this->assertFalse($adGroupCollection->isNotEmpty());
    }

    /**
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testExtract()
    {
        //Demo =====================================================================

        $adGroup1 = AdGroup::make()
            ->setCampaignId(5565)
            ->setName('MyAdGroup_1')
            ->setRegionIds([225])
            ->setNegativeKeywords(['Negative', 'Keywords']);

        $adGroup2 = AdGroup::make()
            ->setCampaignId(5565)
            ->setName('MyAdGroup_2')
            ->setRegionIds([225])
            ->setNegativeKeywords(['Negative', 'Keywords']);

        $adGroupCollection = AdGroups::make($adGroup1, $adGroup2);

        $names = $adGroupCollection->extract('name');
        $namesAndCampaignIds = $adGroupCollection->extract(['name','campaignId']);

        // End Demo =================================================================

        $this->assertEquals(
            ['MyAdGroup_1','MyAdGroup_2'],
            $names
        );

        $this->assertEquals(
            [['name' => 'MyAdGroup_1', 'campaignId' => 5565],['name' => 'MyAdGroup_2', 'campaignId' => 5565]],
            $namesAndCampaignIds
        );
    }

    /**
     * @return AdGroups
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testFirst()
    {
        // Demo =====================================================================

        $adGroup1 = AdGroup::make()
            ->setCampaignId(5561)
            ->setName('MyAdGroup_1')
            ->setRegionIds([225]);

        $adGroup2 = AdGroup::make()
            ->setCampaignId(5562)
            ->setName('MyAdGroup_2')
            ->setRegionIds([225]);

        $adGroup3 = AdGroup::make()
            ->setCampaignId(5563)
            ->setName('MyAdGroup_3')
            ->setRegionIds([225]);

        $adGroupCollection = AdGroups::make($adGroup1, $adGroup2, $adGroup3);

        /** @var AdGroup $adGroupFirstModel */
        $adGroupFirstModel = $adGroupCollection->first();

        if (!is_null($adGroupFirstModel)){
            $adGroupFirstModel->getName(); // MyAdGroup_1
        }

        // End Demo =================================================================

        $this->assertEquals('MyAdGroup_1', $adGroupFirstModel->getName());

        return $adGroupCollection;
    }

    /**
     * @depends testFirst
     *
     * @param AdGroups $adGroupCollection
     */
    public function testFirst_CallbackFunction($adGroupCollection)
    {
        // Demo =====================================================================

        /** @var AdGroup $adGroupFirstModel */
        $adGroupFirstModel = $adGroupCollection->first(function(AdGroup $model){
            return $model->getCampaignId() === 5562;
        });

        if (!is_null($adGroupFirstModel)){
            $adGroupFirstModel->getName(); // MyAdGroup_2
        }

        // End Demo =================================================================

        $this->assertEquals('MyAdGroup_2', $adGroupFirstModel->getName());
    }

    /**
     * @return AdGroups
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testLast()
    {
        // Demo =====================================================================

        $adGroup1 = AdGroup::make()
            ->setCampaignId(5561)
            ->setName('MyAdGroup_1')
            ->setRegionIds([225]);

        $adGroup2 = AdGroup::make()
            ->setCampaignId(5562)
            ->setName('MyAdGroup_2')
            ->setRegionIds([225]);

        $adGroup3 = AdGroup::make()
            ->setCampaignId(5563)
            ->setName('MyAdGroup_3')
            ->setRegionIds([225]);

        $adGroupCollection = AdGroups::make($adGroup1, $adGroup2, $adGroup3);

        /** @var AdGroup $adGroupFirstModel */
        $adGroupFirstModel = $adGroupCollection->last();

        if (!is_null($adGroupFirstModel)){
            $adGroupFirstModel->getName(); // MyAdGroup_3
        }

        // End Demo =================================================================

        $this->assertEquals('MyAdGroup_3', $adGroupFirstModel->getName());

        return $adGroupCollection;
    }

    /**
     * @depends testFirst
     *
     * @param AdGroups $adGroupCollection
     */
    public function testLast_CallbackFunction($adGroupCollection)
    {
        // Demo =====================================================================

        /** @var AdGroup $adGroupFirstModel */
        $adGroupFirstModel = $adGroupCollection->last(function(AdGroup $model){
            return $model->getCampaignId() === 5562;
        });

        if (!is_null($adGroupFirstModel)){
            $adGroupFirstModel->getName(); // MyAdGroup_2
        }

        // End Demo =================================================================

        $this->assertEquals('MyAdGroup_2', $adGroupFirstModel->getName());

    }

    /**
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testShift()
    {
        list($adGroup1, $adGroup2, $adGroup3) = $this->getAdGroupsModels();

        //Demo =====================================================================

        $adGroupCollection = AdGroups::wrap([$adGroup1, $adGroup2, $adGroup3]);

        // Returns model $adGroup1
        $adGroupFirstModel = $adGroupCollection->shift();

        // Returns [$adGroup2, $adGroup3]
        $adGroupCollection->all();

        // End Demo =================================================================

        $this->assertSame($adGroup1, $adGroupFirstModel);
        $this->assertSame([$adGroup2, $adGroup3], $adGroupCollection->all());
    }

    /**
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testPop()
    {
        list($adGroup1, $adGroup2, $adGroup3) = $this->getAdGroupsModels();

        //Demo =====================================================================

        $adGroupCollection = AdGroups::wrap([$adGroup1, $adGroup2, $adGroup3]);

        // Returns model $adGroup3
        $adGroupFirstModel = $adGroupCollection->pop();

        // Returns [$adGroup1, $adGroup2]
        $adGroupCollection->all();

        // End Demo =================================================================

        $this->assertSame($adGroup3, $adGroupFirstModel);
        $this->assertSame([$adGroup1, $adGroup2], $adGroupCollection->all());
    }

    /**
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testInitial()
    {
        list($adGroup1, $adGroup2, $adGroup3) = $this->getAdGroupsModels();

        //Demo =====================================================================

        $adGroupCollection = AdGroups::wrap([$adGroup1, $adGroup2, $adGroup3]);

        // Returns AdGroups[$adGroup1, $adGroup2]
        $collection1 = $adGroupCollection->initial();

        // Returns AdGroups[$adGroup1]
        $collection2 = $adGroupCollection->initial(2);

        // End Demo =================================================================

        $this->assertInstanceOf(AdGroups::class, $collection1);
        $this->assertNotSame($adGroupCollection, $collection1);
        $this->assertSame($collection1->all(), [$adGroup1, $adGroup2]);

        $this->assertInstanceOf(AdGroups::class, $collection2);
        $this->assertNotSame($adGroupCollection, $collection2);
        $this->assertSame($collection2->all(), [$adGroup1]);

    }

    /**
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testTail()
    {
        list($adGroup1, $adGroup2, $adGroup3) = $this->getAdGroupsModels();

        //Demo =====================================================================

        $adGroupCollection = AdGroups::wrap([$adGroup1, $adGroup2, $adGroup3]);

        // Returns AdGroups[$adGroup2, $adGroup3]
        $collection1 = $adGroupCollection->tail();

        // Returns AdGroups[$adGroup3]
        $collection2 = $adGroupCollection->tail(2);

        // End Demo =================================================================

        $this->assertInstanceOf(AdGroups::class, $collection1);
        $this->assertNotSame($adGroupCollection, $collection1);
        $this->assertSame($collection1->all(), [$adGroup2, $adGroup3]);

        $this->assertInstanceOf(AdGroups::class, $collection2);
        $this->assertNotSame($adGroupCollection, $collection2);
        $this->assertSame($collection2->all(), [$adGroup3]);
    }

    /**
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testSlice()
    {
        list($adGroup1, $adGroup2, $adGroup3) = $this->getAdGroupsModels();

        // Demo =====================================================================

        $adGroupCollection = AdGroups::wrap([$adGroup1, $adGroup2, $adGroup3]);

        // Returns AdGroups[$adGroup3]
        $collection1 = $adGroupCollection->slice(2);

        // Returns AdGroups[$adGroup1, $adGroup2]
        $collection2 = $adGroupCollection->slice(0, 2);

        // Returns AdGroups[$adGroup2, $adGroup3]
        $collection3 = $adGroupCollection->slice(1,2);

        // End Demo =================================================================

        $this->assertInstanceOf(AdGroups::class, $collection1);
        $this->assertNotSame($adGroupCollection, $collection1);
        $this->assertSame($collection1->all(), [$adGroup3]);

        $this->assertInstanceOf(AdGroups::class, $collection2);
        $this->assertNotSame($adGroupCollection, $collection2);
        $this->assertSame($collection2->all(), [$adGroup1, $adGroup2]);

        $this->assertInstanceOf(AdGroups::class, $collection3);
        $this->assertNotSame($adGroupCollection, $collection3);
        $this->assertSame($collection3->all(), [$adGroup2, $adGroup3]);
    }

    /**
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testCopy()
    {
        list($adGroup1, $adGroup2, $adGroup3) = $this->getAdGroupsModels();

        // Demo =====================================================================

        $originalCollection = AdGroups::wrap([$adGroup1, $adGroup2, $adGroup3]);
        $copyCollection = $originalCollection->copy();

        // End Demo =================================================================

        $this->assertInstanceOf(AdGroups::class, $copyCollection);
        $this->assertNotSame($originalCollection, $copyCollection);
        $this->assertNotSame($originalCollection->all(), $copyCollection->all());
    }

    /**
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testHash()
    {
        list($adGroup1, $adGroup2, $adGroup3) = $this->getAdGroupsModels();

        // Demo =====================================================================

        $adGroupCollection = AdGroups::wrap([$adGroup1, $adGroup2, $adGroup3]);

        //Returns "9f622f737999e219536793b9c09513ff7b2e803d"
        $adGroupCollection->hash();

        // End Demo =================================================================

        $this->assertEquals('9f622f737999e219536793b9c09513ff7b2e803d', $adGroupCollection->hash());

        /** @var AdGroup $model */
        $model = $adGroupCollection->first();
        $model->setName('new name');

        $this->assertNotEquals('9f622f737999e219536793b9c09513ff7b2e803d', $adGroupCollection->hash());
    }

    /**
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testPush()
    {
        list($adGroup1, $adGroup2, $adGroup3) = $this->getAdGroupsModels();

        // Demo =====================================================================

        $adGroupCollection = AdGroups::make();
        $adGroupCollection->push($adGroup1)->push($adGroup2)->push($adGroup3);

        // End Demo =================================================================

        $this->assertSame([$adGroup1, $adGroup2, $adGroup3], $adGroupCollection->all());
    }

    /**
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testMap()
    {
        list($adGroup1, $adGroup2, $adGroup3) = $this->getAdGroupsModels();

        // Demo =====================================================================

        $originalCollection = AdGroups::wrap([$adGroup1, $adGroup2, $adGroup3]);

        $newCollection = $originalCollection->map(function(AdGroup $model, $key){
            $newModel = $model->copy()->setName($model->name . ' key: ' . $key);
            return $newModel;
        });

        // End Demo =================================================================

        $this->assertInstanceOf(AdGroups::class, $newCollection);
        $this->assertNotSame($originalCollection, $newCollection);
        $this->assertNotSame($originalCollection->all(), $newCollection->all());
        $this->assertNotEquals($originalCollection->extract('name'), $newCollection->extract('name'));
    }

    /**
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testEach()
    {
        list($adGroup1, $adGroup2, $adGroup3) = $this->getAdGroupsModels();
        $adGroupCollection = AdGroups::wrap([$adGroup1, $adGroup2, $adGroup3]);
        $hash = $adGroupCollection->hash();

        // Demo =====================================================================

        $adGroupCollection->each(function(AdGroup $model, $key){
            $model->setName($model->name . ' key: ' . $key);
        });

        // End Demo =================================================================

        $this->assertNotEquals($hash, $adGroupCollection->hash());
    }

    /**
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     */
    public function testFilter()
    {
        // Demo =====================================================================

        $adGroup1 = AdGroup::make()
            ->setCampaignId(5561)
            ->setName('MyAdGroup_1')
            ->setRegionIds([225]);

        $adGroup2 = AdGroup::make()
            ->setCampaignId(5562)
            ->setName('MyAdGroup_2')
            ->setRegionIds([225]);

        $adGroup3 = AdGroup::make()
            ->setCampaignId(5562)
            ->setName('MyAdGroup_3')
            ->setRegionIds([225]);

        $originalCollection = AdGroups::wrap([$adGroup1, $adGroup2, $adGroup3]);

        // Returns AdGroups[$adGroup2, $adGroup3]
        $newCollection = $originalCollection->filter(function(AdGroup $model){
            return $model->campaignId === 5562;
        });

        // End Demo =================================================================

        $this->assertInstanceOf(AdGroups::class, $newCollection);
        $this->assertNotSame($originalCollection, $newCollection);
        $this->assertSame([$adGroup2, $adGroup3], $newCollection->all());
    }
}