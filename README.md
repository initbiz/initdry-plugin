# InIT DRY - InIT.biz package with useful classes and helpers.

![SEO Storm - ultimate SEO tool for OctoberCMS](https://raw.githubusercontent.com/initbiz/initdry-plugin/master/docs/init-dry.png)

This is a repo of OctoberCMS plugin by [InIT.biz](https://init.biz).

## Introduction

A collection of useful classes and helpers that can save you a bundle of development time.

## `PluginRegistrationManager`

The `PluginRegistrationManager` was created to run and merge the output of any register methods from `Plugin.php` in your system. Using the manager you can define your own register*something* method which returns an array of merged arrays.

The manager is `Singleton` so the example usage would be as follows:

```php
    $pluginRegistrationManager = PluginRegistrationManager::instance();
    $registeredDefinitions = $pluginRegistrationManager->runMethod('registerMyPluginDefinitions');
```

## `Helpers`

Class with commonly used functions that do not belong to any other helpers.

    getUser() : mixed
        Get currently logged in user and timestamp 'last seen'
        Returns:
            mixed — (User || null)

    getFileListToDropdown() : array
        Helper to be used in models to list all cms pages in dropdown
        Returns:
            array — pages base file names

    getPageUrl(string  $pageCode, \Cms\Classes\Theme  $theme = null) : string
        Get url of page using page code
        Parameters:
            string 	$pageCode page code
            \Cms\Classes\Theme 	$theme theme object
        Returns:
            string — url

## `StringHelpers`

Class with string helpers.

    random_str(integer  $length, string  $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') : string
        A method by Scott Arciszewski: https://stackoverflow.com/a/31107425
        Generate a random string, using a cryptographically secure
        pseudorandom number generator (random_int)
        Parameters:
            integer $length How many characters do we want?
            string 	$keyspace A string of all possible characters to select from
        Returns:
            string

    ucwords(string  $string, array  $delimiters = array(' ', '-', '\'', '"', ".")) : string
        Upper case every word after the delimiter
        Parameters:
            string 	$string     string to upper case after all delimiters
            array 	$delimiters array of delimiters to uppercase after
        Returns:
            string — parsed string

    mb_ucfirst(string  $string, string  $encoding = 'UTF-8') : string
        First letter uppercase in string
        Parameters:
            string 	$string   string to make first letter upper case
            string 	$encoding encoding
        Returns:
            string — First letter uppercased string
