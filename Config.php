<?php

/**
 * Config handler
 */
class Config {

    /**
     * @var object 
     */
    private $config;

    /**
     * Constructs Config using given json formatted config file
     * 
     * @param string $file
     */
    public function __construct($file = "config.json") 
    {
        $this->config = json_decode(file_get_contents($file));
    }
    
    /**
     * Overriden Magic function - allows direct property access within config
     * 
     * @param string $name
     * @return mixed
     * @throws Exception
     */
    public function __get($name) 
    {
        if (!isset($this->config->$name)) {
            throw new Exception("Config index not found :: " . $name);
        }
        
        return $this->config->$name;
    }
    
}
