# Lib-Console
Simple PHP CLI Framework

#Installation
There are two ways to use lib-console.

####1. Using Composer
composer.json file
```json
{
    "require": {
        "kasundon/lib-console": "~0.0.6"
    }
}
```

```shell
php composer.phar install
```

####2. Using PHAR Archive (console.phar)
Fist of all, Download latest `console.phar`.
```shell
curl -O https://github.com/KasunDon/lib-console/raw/master/build/console.phar
```
####Get help  for `console.phar`

```shell
php console.phar -help
```

# Setup Default Command file path
place `console.json` file to your current working directory. Leave emtpty `file_path` in order to use current working directory.

```json
{
    "file_path": "commands/"
}
```

# Writing Commands

Simply implement `Command` Interface on to your custom command class.

####If using `console.phar` - Dont forget to require_once follwoing statement before implements from `Command` Interface.

```php
require_once 'phar://console.phar/Command.php';
```

###Standard Custom Command
```php
<?php

class Test implements Command {
     
    /**
     * Pre-execution command setup
     */
    public function setup() 
    {
        CommandUtility::log("pre command setup");
    }
    
    /**
     * Executes command routines
     */
    public function execute() 
    {
        CommandUtility::log("execute");
    }
    
    /**
     *  Returns command name/description
     * 
     * @return string
     */
    public function getCommand() 
    {
        return "Test Command";
    }
}
```

#Run Commands
Place `app.php` into current working directory and execute  on following format. first argument is your custom command name. when pass in arguments use following format `--abc 1`. 

Please note: class name will be use as command name.

```shell
php app.php Test --abc 1
```

### Or using `console.phar`

```shell
php console.phar Test --abc 1
```

#Using cli arguments in inside command script
lib-console automatically injecting input cli arguments into `arguments` property. you can simple use them as follows,

```php
 $this->arguments
```


##Feel free to contribute / feedback
###if any questions please feel free to contact kasun@phpbox.info
