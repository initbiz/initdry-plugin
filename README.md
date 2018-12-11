# InIT DRY

# Introduction
Plugin with set of classes and helpers to be used in third party plugins.

The more plugins we develop the more copy-pasta is out there. This plugin is an end to those practices.

Go ahead and contribute.

# Documentation
For now the plugin includes two classes: `PluginRegistrationManager` and `Helpers`.

## `PluginRegistrationManager`
The `PluginRegistrationManager` was created to run and merge output of any register methods from `Plugin.php` in your system. Using the manager you can define your own register*something* method which returns array of merged arrays.

The manager is `Singleton` so the example usage would be as follows:

```php
    $pluginRegistrationManager = PluginRegistrationManager::instance();
    $registeredDefinitions = $pluginRegistrationManager->runMethod('registerMyPluginDefinitions');
```

## `Helpers`
`Helpers` class is just a set of frequently used methods that can be run anywhere in the code. See [the class here](https://github.com/initbizlab/oc-initdry-plugin/blob/master/classes/Helpers.php) for more info.
