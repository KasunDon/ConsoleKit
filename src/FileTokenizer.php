<?php
/**
 * FileTokenizer - Iterate through given config 
 * file path and finds php files
 */
class FileTokenizer {

    /**
     * Parsing given file and identify command scripts
     * 
     * @param string $file
     * @return boolean
     */
    public function parse($file) 
    {
        if(!is_readable($file)) {
            return false;
        }
        
        $className = $this->getClassName($file);
        
        if(empty($className)) {
            return false;
        }
        
        require_once $file;
        
        $isCommand = $this->isCommand($className);
        
        return ($isCommand)? array('file' => $file, 'className' => $className): $isCommand;
    }

    /**
     * Find class name using PHP Tokenizer
     * 
     * @param string $file
     * @return string
     */
    private function getClassName($file) {
        $fp = @fopen($file, 'r');

        $class = $buffer = null;
        
        $i = 0;
        
        while (! @feof($fp) && ! $class) {

            $buffer .= @fread($fp, 256);
            
            $tokens = @token_get_all($buffer);    
    
            $noOfTokens = count($tokens);
            
            for (; $i < $noOfTokens; $i++) {
                if ($tokens[$i][0] === T_CLASS) {
                    for ($j = $i + 1; $j < $noOfTokens; $j++) {
                        if ($tokens[$j] === '{') {
                            $class = trim($tokens[$i + 2][1]);
                            break;
                        }
                    }
                }
            }
        }
        
        @fclose($fp);
        
        return $class;
    }

    /**
     * Checks whether child class of Command or not
     * 
     * @param string $className
     * @return boolean
     */
    public function isCommand($className) {
        $class = new ReflectionClass($className);

        if ($class->isInstantiable() && $class->isSubclassOf('Command')) {
            return true;
        }
        
        return false;
    }

    /**
     * Static - Self Factory method 
     * 
     * @return \self
     */
    public static function init() {
        return new self();
    }

}
