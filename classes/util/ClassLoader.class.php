<?php

/**
 *  
 * Copyright 2011 Chris Keeley <info@chriskeeley.co.uk> All rights reserved.
 */
require_once('ClassCache.class.php');
require_once('ClassMapEntry.class.php');

/**
 * 
 */
class ClassLoader {

    /**
     * The name of the class to locate
     * @var string strTargetClassName
     * @access private
     */
    private $strTargetClassName;

    /**
     * The name of the top level classpaths
     * @var string top level classpath to begin search
     * @access private
     */
    private $classPaths;

    /**
     *
     * @var type 
     */
    private static $instance;

    /**
     * Class constructor.
     * Setup class and allocate any required resources
     * @access public
     */
    private function __construct() {
        global $classPaths;
        $this->classPaths = $classPaths;
        $this->cache = ClassCache::instance();
        spl_autoload_register(array($this, 'load'));
    }

    /**
     * Create or return the instance of the classloader
     * @return type 
     */
    public static function instance() {
        if (!self::$instance) {
            self::$instance = new ClassLoader();
        }
        return self::$instance;
    }

    /**
     * This method invokes the class search
     * @param string $strClassName
     * @access public
     */
    final public function load($strClassName = null) {
        $this->strTargetClassName = $strClassName;
        // first do a cache lookup for the class
        $entry = $this->cache->lookup($strClassName);
        if ($entry) {
            require_once( $entry );
        } else {
            // if it's not cached then we have to search the filesystem.
            foreach ($this->classPaths as $classPath) {
                if ($this->searchClassPath($classPath)) {
                    return true;
                }
            }
        }
        return true;
    }

    /**
     * This method recurses down through every subdirectory of $path @see $classPaths
     * and attempts to find the class specified by the member $strTargetClassName.
     * @TODO Optimise this routine
     * @param string $path
     * @access private
     * @return void
     */
    final private function searchClassPath($path) {
        if (is_dir($path)) {
            $dh = opendir($path);
            if ($dh) {
                while (( $file = readdir($dh) ) !== false) {
                    // ignore parent, current and svn directories
                    if ($file != "." && $file != ".." && $file != ".svn") {
                        $newDir = realpath($path . "/" . $file);
                        if (is_dir($newDir)) {
                            $this->searchClassPath($newDir);
                        } else {
                            // strip off the suffix of each class in order to make a faster comparison
                            $targetClassName = $this->strTargetClassName;
                            $currentClassName = substr($file, 0, stripos($file, "."));
                            if (strtolower($targetClassName) === strtolower($currentClassName)) {
                                $entry = new ClassMapEntry($file, $path);
                                $this->cache->newEntry($entry);
                                require_once( $entry );
                                return true;
                            }
                        }
                    }
                }
                closedir($dh);
            }
        }
    }

}

?>