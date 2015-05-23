<?php

/**
 * Class CommandHandler - Handles command initialization and cli arguments
 */
class CommandHandler {

    /**
     * @var Config 
     */
    private $config;
    
    /**
     * @var array 
     */
    private $args;
    
    /**
     * @var string 
     */
    private $command;
    
    /**
     * @var array 
     */
    private $commandsList;

    /**
     * CommandHandler - Constructor
     * 
     * @param Config $config
     * @param array $args
     * @throws Exception
     */
    public function __construct(Config $config, $args) 
    {
        $this->config = $config;
        
        if (empty($args[1])) {
            throw new Exception("Please specify command to run.");
        }

        $this->prepareCommands();
        
        $this->command = $args[1];

        if (!in_array($this->command, array_keys($this->commandsList))) {
            throw new Exception($this->command . " :: Command not found.");
        }
        
        $this->prepareArgs($args);
    }

    /**
     * Executes main routines for CommandHandler 
     */
    public function handle() 
    {
        $file = $this->commandsList[$this->command];
        $class = str_replace(array('/', '.php'), array('_', ''), ucwords($file)); 
        
        require_once $this->commandsList[$this->command];
        
        $command = new $class;
        $command->arguments = $this->args;
        $command->setup();
        $command->execute();
    }

    /**
     * Finds available commands from config file path
     */
    private function prepareCommands() 
    {
        $rawFiles = scandir($this->config->file_path);

        //removing dots 
        $fileList = array_diff($rawFiles, array('.', '..'));

        $commands = array();

        foreach ($fileList as $file) {
            $path = $this->config->file_path . $file;

            $commands[pathinfo($path, PATHINFO_FILENAME)] = $path;
        }

        $this->commandsList = $commands;
    }

    /**
     * Prepares input cli arguments for command usage
     * 
     * @param array $args
     * @throws Exception
     */
    private function prepareArgs($args) 
    {
        $cliArguments = array();

        foreach ($args as $arg) {
            if ((preg_match('/^--/', $arg))) {
                if (!isset($args[array_search($arg, $args) + 1])) {
                    throw new Exception($arg . " CLI Argument value not found.");
                }
                $cliArguments[$arg] = $args[array_search($arg, $args) + 1];
            }
        }

        $this->args = $cliArguments;
    }
    
}
