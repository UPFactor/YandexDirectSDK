<?php


namespace YandexDirectSDKTest\Units\Components\DataProviders;


use YandexDirectSDKTest\Helpers\Env;

trait ModelPropertyAccessProvider
{
    public function modelPropertyAccessProvider()
    {
        $model = Env::setUpModel('PropertyAccessProviderModel', [
            'properties' => [
                'nonAddable' => 'string',
                'nonUpdatable' => 'string',
                'nonReadable' => 'string',
                'nonWritable' => 'string'
            ],
            'nonAddableProperties' => [
                'nonAddable'
            ],
            'nonUpdatableProperties' => [
                'nonUpdatable'
            ],
            'nonReadableProperties' => [
                'nonReadable'
            ],
            'nonWritableProperties' => [
                'nonWritable'
            ]
        ]);

        $model = $model::make([
            'nonAddable' => 'nonAddableValue',
            'nonUpdatable' => 'nonUpdatableValue',
            'nonReadable' => 'nonReadableValue',
            'nonWritable' => 'nonWritableValue'
        ]);

        return [
            'model' => [$model]
        ];
    }
}