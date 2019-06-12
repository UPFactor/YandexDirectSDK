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
    protected $compatibleModel = FakeModel::class;

    /**
     * Collection initialization handler.
     */
    protected function initialize($models)
    {
        $this->checklists = new Checklists();
    }

    /**
     * Check model properties of this collection.
     *
     * @param array $expectedProperties
     * @throws ModelException
     */
    public function check(array $expectedProperties){
        $this->checklists->checkModelCollection($this, $expectedProperties);
    }
}