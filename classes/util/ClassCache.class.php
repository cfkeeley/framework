<?php

/**
 *  
 * Copyright Feb 28, 2012 Chris Keeley <info@chriskeeley.co.uk> All rights reserved. 
 *
 * Description of ClassCache
 *
 * @author chris
 */
require_once 'SystemFile.class.php';
/**
 * A file backed class cache. 
 */
class ClassCache {

    /**
     * Persistent storage for the cache.
     * @var type 
     * @access private
     */
    private $cacheFile;
    
    /**
     * Runtime storage for the persistent cache.
     * @var type 
     * @access private
     */
    private $classMap;
    
    /**
     * Static instance holds an instantiation 
     * of the ClassCache to avoid multiple invocation overhead
     * @static
     * @access public
     */
    public static $instance;
    
    /**
     *
     * @var type 
     * @access private
     */
    private $entries;
    
    /**
     * Flag denoting whether or not the cache has been opened.
     * @var boolean true if the cache is open, false if not
     * @access private
     */
    private $open;
    
    /**
     * Logger instance
     * @var Logger 
     */
    private $logger;
    
    /**
     * True if the cache has at least one entry
     * @var type 
     */
    private $hasEntries;
    
    /**
     * Class constructor.
     * @access public 
     */
    public function __construct() {
        $this->cacheFile = new SystemFile(AUTOLOAD_CACHE_FILE);
        $this->classMap = array();
        $this->open = false;
        $this->hasEntries = false;
        $this->logger = Logger::getLogger(__CLASS__);
        $this->openCache();
    }

    /**
     * Get an instance of the ClassCache
     * @return ClassCache 
     * @access public
     * @static
     */
    public static function instance() {
        if (!isset(self::$instance)) {
            self::$instance = new ClassCache();
        }
        return self::$instance;
    }
    
    /**
     * Write the contents of the classMap to persistent storage.
     * @access public
     * @return void
     */
    public function write() {
        $cacheSZ = serialize($this->classMap);
        $this->cacheFile->write($cacheSZ);
    }
    
    /**
     * Lookup an entry in the cache  
     * @access public
     * @return void
     */
    public function lookup($className) {
        
        if(!$this->open) {
            $this->openCache();
        }
        /**
         * Check first to see if its worth looking
         * in the cache
         */
        if($this->hasEntries) {
            $hash = md5(strtolower($className));
            if(isset($this->classMap[$hash])) {
                $aClass = $this->classMap[$hash];
                $aClass->incrementHitCount();
                $this->classMap[$hash] = $aClass;
                return $this->classMap[$hash];
            }
        }
        return false;
    }
    
    /**
     * Load the cache with the contents from persistent storage
     * @access private
     */
    private function openCache() {
        if(!$this->open) {
            $this->classMap = $this->getCacheFileAsSet();
            if(count($this->classMap)) {
                $this->hasEntries = true;
            }
            $this->open = true;
        }
    }
    
    /**
     * the cache data file is a serialized array.
     * we read in the serialized data and hydrate back into array format.
     * @return array contents of the persistent storage
     * @access private
     */
    private function getCacheFileAsSet() {
        $contents = file_get_contents($this->cacheFile->pathName);
        $cacheDataSet = array();
        if($contents) {
            $cacheDataSet = unserialize($contents);
        }
        return $cacheDataSet;
    }
    
    /**
     * Add a new ClassMap entry into the classMap
     * @param ClassMapEntry $entry 
     * @return void
     * @access public
     */
    public function newEntry(ClassMapEntry $entry) {
        $hash = md5(strtolower($entry->getClassName()));
        $this->classMap[$hash] = $entry;
        $this->logger->debug("Cache entry: {$entry->getClassName()}.{$entry->getClassSuffix()}");
    }
    
    /**
     * Make sure we sync the contents of the classMap with persistent storage. 
     * @access public
     * @return void
     */
    public function __destruct() {
        $this->write();
    }
}
?>
