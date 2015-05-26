# Lib-Console
Simple PHP CLI Framework

# Setup Default Command file path
```json
{
    "file_path": "commands/"
}
```


# Writing Commands

Simply implement `Command` Interface on to your custom command class.

```php
<?php

class Commands_Test implements Command {
     
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
Place `app.php` into current working directory and execute  on following format. first argument is your custom command name. when pass in arguments use following format `--abc 1`

```shell
php app.php Test --abc 1
```

#Using cli arguments in command
ConsoleKit automatically injecting input cli arguments into `arguments` property. you can simple use them as follows,

```php
 $this->arguments
```


###if any questions please feel free to contact kasun@phpbox.info
