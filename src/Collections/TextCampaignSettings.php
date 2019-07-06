<?php

namespace YandexDirectSDK\Collections;

use YandexDirectSDK\Components\ModelCollection;
use YandexDirectSDK\Models\TextCampaignSetting;

/** 
 * Class TextCampaignSettings 
 * 
 * @package YandexDirectSDK\Collections 
 */
class TextCampaignSettings extends ModelCollection
{
    /**
     * @var TextCampaignSetting[]
     */
    protected $items = [];

    protected static $compatibleModel = TextCampaignSetting::class;
}