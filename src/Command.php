<?php

/**
 * Command Interface
 */
interface Command {
    
    /**
     * Pre-execution command setup
     */
    public function setup();
    
    /**
     * Executes command routines
     */
    public function execute();
    
    /**
     *  Returns command name/description
     * 
     * @return string
     */
    public function getCommand();
    
}
