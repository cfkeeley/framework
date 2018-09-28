<?php
/**
 *  
 * Copyright 2011 Chris Keeley <info@chriskeeley.co.uk> All rights reserved.
 * 
 * Determine which presenter to invoke and process any 
 * hooks as specified in the request parameters
 */
class Dispatcher {
    
    private $logger;

    /**
     * 
     */
    public function __construct() {
        $this->logger = Logger::getLogger(__CLASS__);
    }

    /**
     * Execute any specified hooks and then dispatch the request to the associated presenter 
     * @param HTTPRequest $request
     */
    public function dispatch(HTTPRequest $request, HTTPResponse $response) {
        $presenterString = $request->get('presenter');
        
        if (!$presenterString) {
            $presenterString = 'Index';
        }
        
        $presenterString .= 'Presenter';
        $this->logger->debug("Found presenter:[{$presenterString}]");
        
        if (!class_exists($presenterString)) {
            throw new ClassNotFoundException(null, "{$presenterString} not found");
        } 
        else {
            $presenter = new $presenterString();
            if ($presenter instanceof Presenter) {
                /* init The context */
                $context = new HttpContext();
                $context->setView(new Layout());
                $context->setRequest($request);
                $context->setResponse($response);
                $context->getSession()->init();
                $presenter->setContext($context);
                $hooks = $request->get('hooks');
                if ($hooks) {
                    $this->executeHooks($hooks, $context);
                }
                $response = $presenter->present();
            } else {
                throw new PresenterException(null, "Presenter is not of correct type");
            }
        }
        return ($response) ? ($response) : new HTTPResponse();
    }

    /**
     * Execute any hooks provided in the URL mapping
     */
    private function executeHooks($hooks, $context) {
        foreach ($hooks as $hook) {
            $classString = ucfirst($hook) . 'Hook';
            if (class_exists($classString)) {
                $hookImpl = new $classString($context);
                $hookImpl->execute();
            } else {
                throw new ClassNotFoundException(null, "Hook:{$classString} could not be found");
            }
        }
    }

}