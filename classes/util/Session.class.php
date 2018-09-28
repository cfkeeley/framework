<?php
/**
 *  
 * Copyright 2011 Chris Keeley <info@chriskeeley.co.uk> All rights reserved.
 */
class Session {
    /**
     * Current session id
     * @var string session id
     * @access public
     */
    private $sid;
    
    /**
     *
     * @var type 
     */
    private $logger;
    
    private $SESSION_USER = 'session_user';
    
    /**
     * Class constructor
     * Never called - this is private to facilitate the singleton pattern.
     */
     public function __construct() {
        $this->logger = Logger::getLogger(__CLASS__);
    }

    /**
     * unset a session variable
     * @param <type> $name
     */
    final public function clear( $name ) {
        if( isset( $_SESSION[ $name ] ) ) {
                unset( $_SESSION[ $name ] );
                $this->logger->info("Clearing session var:{$name}");
        }
    }
    /**
     * 
     * Enter description here ...
     * @param unknown_type $name
     * @param unknown_type $value
     */
    final public function get($name) {
                if( isset( $_SESSION[ $name ] ) ) {
               return $_SESSION[ $name ];
        }
        return null;
    }
    
    /**
     * the user currently in the session
     */
    final public function setSessionUser(SessionUser $sessionUser = null) {
        if($sessionUser) {
            $_SESSION[$this->SESSION_USER] = $sessionUser;
            $_SESSION['logged_in'] = true;
        }
        else {
            $_SESSION['logged_in'] = false;
        }
     }
     
     /**
      * Update the session user from the DB
      */
     final public function reloadSessionUserFromDB() {
         if(isset($_SESSION[$this->SESSION_USER])) {
             $sessionUser = $_SESSION[$this->SESSION_USER];
             $userProfileDAO = new UserProfileDAO();
             try {
                $profile = $sessionUser->getUserProfile();
                $updatedUser = $userProfileDAO->findByUserId($profile->id);
                if($updatedUser) {
                    $sessionUser->setUserProfile($updatedUser);
                    $this->setSessionUser($sessionUser);
                }
                return true;  
             }
             catch(DAOException $e) {
                 throw new SessionException($e);
             }
         }
         return false;
     }

    /**
     *
     * @return type
     * @throws SessionException 
     */
    final public function getSessionUser() {
        if(!isset($_SESSION['session_user'])) {   
            throw new SessionException('Unable to find user in session');
        }
        return $_SESSION['session_user'];
    }
    
    /**
     *
     * @return type 
     */
    final public function isLoggedIn() {
        return isset($_SESSION['logged_in']) ? true : false;
    }
    
    /**
     * 
     * Enter description here ...
     * @param unknown_type $name
     * @param unknown_type $value
     */
    final public function set($name,$value) {
        $_SESSION[$name]=$value;
        if(!isset($_SESSION[$name])) {
            throw new SessionException("Failed to set session var: {$name}");
        }
        $this->logger->info("Setting session var:{$name}");
    }

    /**
     * start a session
     * Enter description here ...
     */
    final public function init() {
        $running = session_start();
        if(!$running) {
            throw new SessionException('Alert! Failed to start session');
        }
        $this->sid = session_id();
        $this->logger->info("Session has id: [{$this->sid}]");
        return true;
    }
    /**
     *
     * @return type ]
     */
    final public function destroy() {
        if(!session_destroy()) {
            throw new SessionException("Failed to destroy session");
        }
        $this->logger->info("Destroying session");
        return true;
    }
}