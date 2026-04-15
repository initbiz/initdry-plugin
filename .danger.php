<?php

declare(strict_types=1);

use Initbiz\Linter\Classes\DangerConfigMaker;

include_once 'linter-plugin/classes/DangerConfigMaker.php';

$configMaker = new DangerConfigMaker();

// Enable rules below

$configMaker->enableRule('linter-plugin/dangerrules/VersionYamlUpdatedRule.php');
// TODO: rules
// - merge request's source branch name starts with feature/, or bugfix/
// - merge request name starts with task ID e.g.: #1234:

return $configMaker->getConfig();
