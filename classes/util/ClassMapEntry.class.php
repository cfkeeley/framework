<?php

/**
 *  
 * Copyright Feb 28, 2012 Chris Keeley <info@chriskeeley.co.uk> All rights reserved. 
 *
 * Description of ClassMapEntry
 *
 * @author chris
 */
class ClassMapEntry {
    
    /**
     *
     * @var type 
     */
    private $name;
    
    /**
     *
     * @var type 
     */
    private $suffix;
    
    /**
     *
     * @var type 
     */
    private $path;
    
    /**
     *
     * @var type 
     */
    private $length;
    
    /**
     * How many times this class has been retrieved from the cache
     * @var type 
     */
    private $hitCount;
    
    /**
     * 
     */
    public function __construct($className, $classPath) {
        $tokens = explode(".", $className, 2);
        $this->name = $tokens[0];
        $this->suffix = $tokens[1];
        $this->path = $classPath;
        $this->hitCount = 0;
        $this->length = strlen($this->name);
    }
    
    /**
     * 
     */
    public function incrementHitCount() {
        $this->hitCount++;
    }

    /**
     * 
     */
    public function getClassName() {
       return $this->name; 
    }
    
    /**
     * 
     */
    public function getClassSuffix() {
        return $this->suffix;
    }
    
    /**
     * 
     */
    public function getClassPath() {
        return $this->path;
    }
    
    /**
     *
     * @return type 
     */
    public function getClassNameLength() {
        return $this->length;
    }
    
    /**
     *
     * @return type 
     */
    public function __toString() {
        return "{$this->path}/{$this->name}.{$this->suffix}";
    }

}

?>
