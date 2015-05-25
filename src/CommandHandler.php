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
     * @throws Exception
     */
    public function __construct(Config $config) 
    {
        $this->config = $config;
        
        $this->prepareCommands();
    }

    /**
     * Executes main routines for CommandHandler 
     */
    public function handle() 
    {
        $metadata = $this->commandsList[$this->command];
        
        require_once $metadata['file'];
        
        $command = new $metadata['className'];
        $command->arguments = $this->args;
        $command->setup();
        $command->execute();
    }

    /**
     * Finds available commands from config file path
     */
    private function prepareCommands() 
    {
        $filePath = $this->config->file_path;
        
        $filePath = $this->config->file_path = empty($filePath)? getcwd(): $filePath;
        
        $rawFiles = scandir($this->config->file_path);

        $fileList =  array_map(function ($value) use ($filePath) { return $filePath . $value; },
                array_filter(array_diff($rawFiles, array('.', '..')),
                        array($this, 'listPHPFilesOnly')));
        
        $tokenizer = FileTokenizer::init();
        
        $commands = array();

        foreach ($fileList as $file) {
           $info = $tokenizer->parse($file);
           
           if ($info) {
               $commands[$info['className']] = $info;
           }
        }

        $this->commandsList = $commands;
    }
    
    /**
     * Array Filter Callback function - Listing PHP Files
     * 
     * @param string $file
     * @return string
     */
    private function listPHPFilesOnly($file) {
        return !is_dir($file) && strpos($file, '.php');
    }
    
    /**
     * Returns command list
     * 
     * @return array
     */
    public function getCommandList() {
        return array_keys($this->commandsList);
    }
    
    /**
     * Set requested command & prepares cli arguments
     * 
     * @param array $args
     * @throws Exception
     */
    public function setCommand($args) {
         $this->command = isset($args[1])? $args[1]: null;
        
         $this->prepareArgs($args);
        
         if (empty($args[1])) {
            throw new Exception("Please specify command to run.");
         }
        
         if (!in_array($this->command, array_keys($this->commandsList))) {
            throw new Exception($this->command . " :: Command not found.");
         }
    }

    /**
     * Self factory with constructor dependencies
     * 
     * @return \self
     */
    public static function init() {
        return new self(new Config());
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
