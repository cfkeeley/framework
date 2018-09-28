<?php
/**
 *  
 * Copyright 2011 Chris Keeley <info@chriskeeley.co.uk> All rights reserved.
 */
class SessionUser {
    
    /**
     *
     * @var type 
     */
    private $loggedIn;
    
    /**
     *
     * @var type 
     */
    private $profile;
    
    /**
     *
     * @param Person $person
     * @param DateTime $loggedIn 
     */
    public function __construct(UserProfile $profile = null, DateTime $loggedIn = null) {
        $this->profile = $profile;
        $this->loggedIn = $loggedIn;
    }
    
    /**
     *
     * @param type $timestamp 
     */
    public function setLoggedIn($timestamp) {
        $this->loggedIn = $timestamp;
    }
    
    /**
     *
     * @return type 
     */
    public function getLoggedIn() {
        return $this->loggedIn;
    }

    /**
     * 
     * @param UserProfile $profile
     */
    public function setUserProfile(UserProfile $profile = null) {
        if($profile) {
            $this->profile = $profile;
        }
    }
    
    /**
     * 
     * @return type
     */
    public function getUserProfile() {
        return $this->profile;
    }

}
?>
