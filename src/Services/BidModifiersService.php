<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Collections\BidModifiers;
use YandexDirectSDK\Collections\BidModifierSets;
use YandexDirectSDK\Collections\BidModifierToggles;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\RequestException;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Interfaces\ModelCommon;
use YandexDirectSDK\Models\BidModifier;
use YandexDirectSDK\Models\BidModifierSet;
use YandexDirectSDK\Models\BidModifierToggle;

/** 
 * Class BidModifiersService 
 * 
 * @method   Result         add(ModelCommon $bidModifiers) 
 * @method   Result         delete(ModelCommon|integer[]|integer $bidModifiers) 
 * @method   QueryBuilder   query() 
 *
 * @package YandexDirectSDK\Services 
 */
class BidModifiersService extends Service
{
    protected $serviceName = 'bidmodifiers';

    protected $serviceModelClass = BidModifier::class;

    protected $serviceModelCollectionClass = BidModifiers::class;

    protected $serviceMethods = [
        'add' => 'add:addCollection',
        'delete' => 'delete:actionByIds',
        'query' => 'get:selectionElements'
    ];

    /**
     * Enables/disables the set of adjustments.
     *
     * @param BidModifierToggle|BidModifierToggles|ModelCommon $bidModifiers
     * @return Result
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function toggle($bidModifiers): Result
    {
        return $this->updateCollection(
            'toggle',
            $bidModifiers,
            'BidModifierToggleItems',
            'ToggleResults'
        );
    }

    /**
     * Changes the values of coefficients in rate adjustments.
     *
     * @param BidModifierSet|BidModifierSets|ModelCommon $bidModifierSets
     * @return Result
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function set($bidModifierSets): Result
    {
        return $this->updateCollection(
            'set',
            $bidModifierSets,
            'BidModifiers',
            'SetResults'
        );
    }
}