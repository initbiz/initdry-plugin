<?php

declare(strict_types=1);

namespace Initbiz\InitDry\Console;

use October\Rain\Scaffold\Console\CreatePlugin;

class InitCreatePlugin extends CreatePlugin
{
    /**
     * @var string signature for the command
     */
    protected $signature = 'init:create:plugin
        {namespace : The name of the plugin to create. <info>(eg: Acme.Blog)</info>}
        {--o|overwrite : Overwrite existing files with generated ones}';

    /**
     * @var string description of the console command
     */
    protected $description = 'Creates a new plugin - inIT style.';

    /**
     * @var string type of class being generated
     */
    protected $typeLabel = 'Plugin';

    /**
     * makeStubs makes all stubs
     */
    public function makeStubs()
    {
        $this->makeStub('initcreateplugin/plugin.stub', 'Plugin.php');
        $this->makeStub('initcreateplugin/plugin_yaml.stub', 'plugin.yaml');
        $this->makeStub('initcreateplugin/phpunit_xml.stub', 'phpunit.xml');
        $this->makeStub('initcreateplugin/emptytest.stub', 'tests/unit/EmptyTest.php');
        $this->makeStub('initcreateplugin/version.stub', 'updates/version.yaml');
        $this->makeStub('initcreateplugin/lang.stub', 'lang/en/lang.php');
        $this->makeStub('initcreateplugin/lang.stub', 'lang/pl/lang.php');
        $this->makeStub('initcreateplugin/composer.stub', 'composer.json');
        $this->makeStub('initcreateplugin/gitignore.stub', '.gitignore');
    }
}
