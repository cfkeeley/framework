<?php

/**
 * Relationshapes 
 * Copyright Jul 21, 2012 Chris Keeley <chris@relationshapes.com> All rights reserved. 
 */
class HttpContext {
 
    /**
     * The current session for the resource
     * @var type 
     */
    private $session;
    
    /**
     * The current user accessing the resource
     * @var UserProfile 
     */
    private $userProfile;
    
    /**
     *
     * @var type 
     */
    private $sessionUser;
    
    /**
     *
     * @var HTTPRequest 
     */
    private $request;
    
    /**
     *
     * @var HTTPResponse 
     */
    private $response;
    
    /**
     *
     * @var Layout
     */
    private $view;
    
    private $user;
    
    /**
     * 
     */
    public function __construct() {
        $this->session = new Session();
        $this->user = null;
    }
    
    /**
     * 
     * @param HTTPRequest $aRequest
     */
    public function setRequest(HTTPRequest $aRequest) {
        $this->request = $aRequest;
    }
    
    /**
     * 
     * @return type
     */
    public function getRequest() {
        return $this->request;
    }
    
    /**
     * 
     * @param HTTPResponse $aResponse
     */
    public function setResponse(HTTPResponse $aResponse) {
        $this->response = $aResponse;
    }
    
    /**
     * 
     * @return type
     */
    public function getResponse() {
        return $this->response;
    }
    
    /**
     * 
     * @param Layout $aView
     */
    public function setView(Layout $aView) {
        $this->view = $aView;
    }
    
    /**
     * 
     * @return Layout
     */
    public function getView() {
        return $this->view;
    }
    
    /**
     *
     * @return type 
     */
    public function getSession() {
        if(!$this->session) {
            throw new ConfigurationException(null, "Session not instantiated");
        }
        return $this->session;
    }
    
    /**
     *
     * @return type 
     */
    public function getPerson() {
        if(!$this->user) {
            $this->user = $this->session->getSessionUser()->getUserProfile(); 
            if(!$this->user) {
                throw new ConfigurationException(null, "User is not in the session");
            }
        }
        
        $person = $this->user->person;
        return $person;
    }
    
    public function getSessionUser() {
        if(!$this->sessionUser) {
            $this->sessionUser = $this->session->getSessionUser(); 
            if(!$this->sessionUser) {
                throw new ConfigurationException(null, "User is not in the session");
            }
        }
        return $this->sessionUser;
    }
    
    /**
     * Get the user profile
     * @return type
     */
    public function getUserProfile() {
        $profile = $this->session->getSessionUser()->getUserProfile();
        return $profile;
    }
    
    /**
     * 
     * @param SessionUser $user
     */
    public function setSessionUser(SessionUser $user) {
        $this->session->setSessionUser($user);
    }
    
    /**
     * @deprecated use setSessionUser instead
     * @param UserProfile $aUserProfile
     */
    private function setUser(UserProfile $aUserProfile) {
        $this->userProfile = $aUserProfile;
    }
    
}
?>
