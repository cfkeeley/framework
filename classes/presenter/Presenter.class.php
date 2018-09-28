<?php
/**
 *  
 * Copyright 2011 Chris Keeley <info@chriskeeley.co.uk> All rights reserved.
 */
abstract class Presenter {

    /**
     *
     * @var HTTPContext 
     */
    private $context;
    
    protected $logger;
    
    /**
     * Class constructor
     */
    public function __construct() {
        $this->logger = Logger::getLogger(__CLASS__);
    }
    
    /**
     *
     * @param type $context 
     */
    public function setContext(HTTPContext $context) {
        $this->context = $context;
    }
    
    /**
     * Get the current context
     * @return type 
     */
    public function getContext() {
        return $this->context;
    }
    
    /**
     * Get the HTTP request from the context
     * @return HTTPRequest
     */
    public function getRequest() {
        return $this->context->getRequest();
    }
    
    /**
     * Get the HTTP response object from the context
     * @return HTTPResponse
     */
    public function getResponse() {
        return $this->context->getResponse();
    }
    
    /**
     * Get the view from the context
     * @return Layout
     */
    public function getView() {
        return $this->context->getView();
    }
    
    /**
     * 
     * @return type
     */
    public function getUserProfile() {
        return $this->context->getUserProfile();
    }
    
    /**
     * Populate the view with the model data and present to the client
     */
    abstract public function present();
    
}
?>
