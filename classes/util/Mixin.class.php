<?php

/**
 *  
 * Copyright Jan 30, 2012 9:20:03 AM Chris Keeley <info@chriskeeley.co.uk> All rights reserved. 
 *
 * Description of Mixin
 *
 * @author chris
 */
class Mixin {

    public function __construct() {
        // Default constructor. Do nothing
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
            throw new PropertyException(null, "Named property:{$member} does not exist in ".__CLASS__);
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
