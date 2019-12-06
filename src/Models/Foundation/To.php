<?php

namespace YandexDirectSDK\Models\Foundation;

trait To
{
    /**
     * @param integer|string $id
     * @return static
     */
    public static function to($id)
    {
        return static::make(['Id' => $id]);
    }
}