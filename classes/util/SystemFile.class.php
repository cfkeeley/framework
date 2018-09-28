<?php

/**
 *  
 * Copyright 2011 Chris Keeley <info@chriskeeley.co.uk> All rights reserved.
 */

/**
 * wrapper for a file
 * provides convenience routines
 * @TODO write convenience routines lol
 */
class SystemFile {

    /**
     * the full path to the file
     */
    private $pathName;
    /**
     *
     * @var type 
     */
    private $fileData;
    /**
     *
     * @var type 
     */
    private $path;
    /**
     *
     * @var type 
     */
    private $name;

    /**
     * information about the file returned from stat()
     */
    private $info;

    /**
     *
     * @param type $pathName
     * @throws Exception 
     */
    public function __construct($pathName = null) {
        if (file_exists($pathName)) {
            $this->pathName = $pathName;
        } else {
            throw new FileNotFoundException("Unable to locate file:{$pathName}");
        }
    }

    /**
     * create a file on the host filesystem
     * @return unknown_type
     */
    public function write($content) {
        $bytesWritten = 0;
        if (file_exists($this->pathName)) {
            $bytesWritten = file_put_contents($this->pathName, $content);
            $this->info = pathinfo($this->pathName);
        }
        return $bytesWritten;
    }

    /**
     * delete a file from the host filesystem
     * @return unknown_type
     */
    public function delete() {
        return unlink($this->pathName);
    }

    /**
     *
     * @param type $member
     * @return type
     * @throws PropertyNotExistsException 
     */
    public function __get($member) {
        if(property_exists($this, $member)) {
            return $this->$member;
        }
        else {
            throw new PropertyException("Named property:{$member} does not exist in ".__CLASS__);
        }
    }
    /**
     *
     * @param type $member
     * @param type $value
     * @return boolean
     * @throws PropertyException 
     */
    public function __set($member,$value) {
        if(property_exists($this, $member)) {
            $this->$member = $value;
            return true;
        }
        else {
            throw new PropertyException("Attempt to access a non existent property: {$member}");
        }
    }
}

?>