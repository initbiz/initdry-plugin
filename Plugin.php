<?php

declare(strict_types=1);

namespace Initbiz\InitDry;

use File;
use Cache;
use Config;
use Cms\Classes\Theme;
use System\Classes\PluginBase;
use System\Classes\CombineAssets;
use System\Classes\PluginManager;

/**
 * InitDry Plugin Information File
 */
class Plugin extends PluginBase
{
    public static $rebootCssCacheKey = 'reboot-css.last-modified';

    public function register()
    {
        $this->registerConsoleCommand('initdry.droptables', \Initbiz\InitDry\Console\DropTables::class);
        $this->registerConsoleCommand('initdry.maintenance', \Initbiz\InitDry\Console\Maintenance::class);
        $this->registerConsoleCommand('init.create.plugin', \Initbiz\InitDry\Console\InitCreatePlugin::class);
    }

    public function registerMarkupTags()
    {
        return [
            'functions' => [
                'hasPlugin' => [$this, 'hasPlugin'],
                'rebootingStyles' => [$this, 'rebootingStyles'],
            ]
        ];
    }

    public function hasPlugin($pluginCode)
    {
        if (empty($pluginCode)) {
            return false;
        }

        $pluginManager = PluginManager::instance();

        return $pluginManager->hasPlugin($pluginCode) && !$pluginManager->isDisabled($pluginCode);
    }

    public function rebootingStyles()
    {
        $src = Config::get('initbiz.initdry::rebootScssPath');
        $destination = Config::get('initbiz.initdry::rebootCssPath');

        $fileExists = File::exists($destination);
        if ($fileExists) {
            $theme = Theme::getActiveTheme();
            $path = $theme->getPath() . $src;
            $lastMod = File::lastModified($path);
            if ($lastMod !== Cache::get(self::$rebootCssCacheKey)) {
                $this->compileRebootCss();
                $lastMod = File::lastModified($path);
                Cache::forever(self::$rebootCssCacheKey, $lastMod);
            }
        } else {
            $this->compileRebootCss();
        }

        return File::get($destination);
    }

    protected function compileRebootCss()
    {
        $combiner = CombineAssets::instance();
        $destination = Config::get('initbiz.initdry::rebootCssPath');
        $src = Config::get('initbiz.initdry::rebootScssPath');

        $theme = Theme::getActiveTheme();
        $path = $theme->getPath() . $src;
        $combiner->combineToFile([$path], $destination);
    }
}
