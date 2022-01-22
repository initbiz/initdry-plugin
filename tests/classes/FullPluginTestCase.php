<?php

namespace Initbiz\InitDry\Tests\Classes;

use Storage;
use PluginTestCase;
use October\Rain\Database\Model;
use System\Classes\PluginManager;
use System\Classes\UpdateManager;
use System\Classes\VersionManager;

abstract class FullPluginTestCase extends PluginTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Storage::fake('local');

        // Version manager remembers in the databaseVersions all versions
        // between tests even if the table in db is empty
        VersionManager::forgetInstance();

        // Get the plugin manager
        $pluginManager = PluginManager::instance();

        Model::clearExtendedClasses();
        Model::clearBootedModels();

        // TODO: Ensure this line is not necessary to run all types of tests
        // Model::flushEventListeners();

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

    protected function runPluginRefreshCommand($code, $throwException = true)
    {
        // Plugin refresh does not migrate all of the tables
        // That's why we're running update here so that all migrations
        // will be run by plugin:refresh command
        UpdateManager::instance()->updatePlugin($code);
        parent::runPluginRefreshCommand($code, $throwException);
    }
}
