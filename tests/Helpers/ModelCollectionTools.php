<?php

namespace YandexDirectSDKTest\Helpers;

use YandexDirectSDK\Components\ModelCollection;

class ModelCollectionTools extends ModelCollection
{
    /**
     * @var ModelTools[]
     */
    protected $items = [];

    protected $compatibleModel = ModelTools::class;
}