<?php

namespace Initbiz\InitDry\Models;

use System\Models\SettingModel;

class PublicAssetSetting extends SettingModel
{
    public $settingsCode = 'initbiz_initdry_public_asset_setting';

    public $settingsFields = 'fields.yaml';

    public $attachOne = [
        'icon' => \System\Models\File::class,
        'logo' => \System\Models\File::class,
    ];

    /**
     * Get public logo URL
     *
     * @param integer|null $width
     * @param integer|null $height
     * @return string
     */
    public static function getPublicLogoUrl(?int $width = null, ?int $height = null): string
    {
        $settings = (new self())->instance();

        if (!$settings->logo) {
            return url('/plugins/initbiz/initdry/assets/img/october-logo.png');
        }

        $url = $settings->logo->getPath();

        if (!empty($width) || !empty($height)) {
            $url = $settings->logo->getThumb($width, $height, 'auto');
        }

        return $url;
    }

    /**
     * Get public icon URL
     *
     * @param integer|null $width
     * @param integer|null $height
     * @return string
     */
    public static function getPublicIconUrl(?int $width = null, ?int $height = null): string
    {
        $settings = (new self())->instance();

        if (!$settings->icon) {
            return url('/plugins/initbiz/initdry/assets/img/october-icon.png');
        }

        $url = $settings->icon->getPath();

        if (!empty($width) || !empty($height)) {
            $url = $settings->icon->getThumb($width, $height, 'auto');
        }

        return $url;
    }
}
