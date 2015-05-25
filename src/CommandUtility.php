<?php

/**
 * Command Utility provider
 */
class CommandUtility {

    /**
     * Prints out given message with current datetime stamp
     * 
     * @param string $message
     */
    public static function log($message) 
    {
        print "[" . date("Y-m-d H:i:s") . "]: " . $message . "\n";
    }

}
