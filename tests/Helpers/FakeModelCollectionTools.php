<?php

namespace YandexDirectSDKTest\Helpers;

use YandexDirectSDK\Components\ModelCollection;
use YandexDirectSDK\Exceptions\ModelException;

class FakeModelCollectionTools extends ModelCollection
{
    /**
     * @var Checklists
     */
    protected $checklists;

    /**
     * @var FakeModel[]
     */
    protected $items = [];

    /**
     * @var FakeModel
     */
    protected static $compatibleModel = FakeModel::class;

    /**
     * Collection initialization handler.
     * @param $models
     * @return void
     */
    protected function initialize($models)
    {
        $this->checklists = new Checklists();
    }

    /**
     * Check model properties of this collection.
     *
     * @param array $expectedProperties
     */
    public function check(array $expectedProperties){
        $this->checklists->checkModelCollection($this, $expectedProperties);
    }
}