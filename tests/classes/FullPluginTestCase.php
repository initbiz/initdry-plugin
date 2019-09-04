<?php namespace Initbiz\InitDry\Tests\Classes;

use PluginTestCase;
use System\Classes\PluginManager;

abstract class FullPluginTestCase extends PluginTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        // Get the plugin manager
        $pluginManager = PluginManager::instance();

        // Register the plugins to make features like file configuration available
        $pluginManager->registerAll(true);

        // Boot all the plugins to test with dependencies of this plugin
        $pluginManager->bootAll(true);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        // Get the plugin manager
        $pluginManager = PluginManager::instance();

        // Ensure that plugins are registered again for the next test
        $pluginManager->unregisterAll();
    }
}
