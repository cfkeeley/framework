<?php

/**
 *  
 * Copyright Jan 30, 2012 9:08:32 AM Chris Keeley <info@chriskeeley.co.uk> All rights reserved. 
 *
 * The implemntation of Observer in this class deviates from the standard approach for the Observer (pub/sub) pattern.
 * Here the View observes Models who implement the Observable interface.
 * When the view renders itself it queries all observed objects for their state.
 *
 * @author chris
 */
class Layout {

    /**
     * Set of publishers to which we are subscribing for updates when we render
     * @var type 
     */
    private $observed;
    
    /**
     * Template engine     
     * @var type 
     */
    public static $engine;
    
    /**
     *
     * @var type 
     */
    private $logger;
    
    /**
     * 
     * @var type 
     */
    private $messages;

    /**
     * 
     */
    public function __construct() {
        $this->observed = array();
        $this->messages = array();
        $this->logger = Logger::getLogger(__CLASS__);
    }
    
    /**
     * Register interest in what a publisher in providing. 
     */
    public function assignView($placeholder, UIView $view) {
        $this->observed[$placeholder] = $view;
    }
    
    /**
     * Assign a variable into the view using a value
     * @param type $key
     * @param type $value 
     */
    public function assign($key,$value) {
        if($value instanceof UIView) {
            throw new TypeMismatchException(null,"You cannot assign an object in this context. Try using: assignView()");
        }
        self::$engine->assign($key,$value);
    }
    
    /**
     * Render all the ui view components in the layout 
     */
    private function render() {
        foreach($this->observed as $placeholder => $view) {
            $viewClass = get_class($view);
            $this->logger->debug("Notify => Placeholder:[{$placeholder}] Placeholder:[{$viewClass}]");
            $rendered = $view->render();
            self::$engine->assign($placeholder,$rendered);
        }
    }
    
    /**
     * Set a message to display on the view
     */
    public function addMessage($msg = null) {
        if($msg) {
            $this->messages[] = $msg;
        }
    }
    
    /**
     * Call publish on all subscribers to get their data
     * for the view.
     */
    public function display($template) {
      $this->render();
      $this->logger->debug("Setting layout: {$template}");
      self::$engine->display($template);
    }
    
    /**
     *
     * @param type $template
     * @return type 
     */
    public function compile($template) {
        if(count($this->messages)) {
            self::$engine->assign("__messages__",$this->messages);
        }
        $this->render();
        $compiled = self::$engine->fetch($template);
        return $compiled;
    }
}