<?php

/**
 * Relationshapes 
 * Copyright Apr 2, 2012 Chris Keeley <chris@relationshapes.com> All rights reserved. 
 *
 * Description of ErrorHandler
 *
 * @author chris
 */
class ErrorHandler {

    /**
     *
     * @var type 
     */
    private static $instance;
    
    /**
     * 
     */
    private function __construct() {
        set_error_handler(array($this, 'handle'));
        Smarty::muteExpectedErrors();
    }
    
    /**
     * 
     */
    public static function instance() {
      if(!self::$instance) {
          self::$instance = new ErrorHandler();
      }  
      return self::$instance;
    }
    
    /**
     * Handle the error.
     */
    public function handle($errno, $errstr, $errfile, $errline) {      
        $error = new Error();
        $error->number = $errno;
        $error->string = $errstr;
        $error->file = $errfile;
        $error->line = $errline;
        $errorString = sprintf("%s",$error->string);
        $logger = Logger::getLogger(__CLASS__);
        $logger->debug($error);
        $response = new HTTPResponse();
        $response->setData($errorString);
        HTTPOutputStream::respond($response);
    }
}
?>
