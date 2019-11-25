<?php

namespace YandexDirectSDK\Models\Foundation;

trait On
{
    /**
     * @param integer|string $id
     * @return static
     */
    public static function on($id)
    {
        return static::make(['Id' => $id]);
    }
}