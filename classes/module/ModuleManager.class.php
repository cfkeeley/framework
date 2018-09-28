<?php

/**
 * Relationshapes 
 * Copyright Sep 15, 2013 Chris Keeley <info@relationshapes.com> All rights reserved. 
 * 
 * Handle the management of modules.
 * Walk through the module directory structure and include each module: init.php file
 * which will be responsible for registering the module with the framework
 */
class ModuleManager {
    
    private static $dir = MODULE_DIR; 

    private function __construct() {/* do nothing */}
    
    /**
     * Call the init methods of each module returning a list of 
     * module data as provided by each module found
     */
    public static function registerModules() {
        $moduleData = Array();
        $logger = Logger::getLogger('ModuleManager');
        $handle = opendir(self::$dir);
        if($handle) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    $className = ucfirst($entry)."Module";
                    $classInstance = new $className();
                    if($classInstance instanceof Module) {
                        $modEntry = $classInstance->init();
                        if($modEntry && $modEntry instanceof ModuleEntry) {
                            $path = self::$dir.$entry;
                            $modEntry->setPath($path);
                            array_push($moduleData,$modEntry);
                        }
                    }
                }
            }
            closedir($handle);
            return $moduleData;
        }
    }
}
?>
