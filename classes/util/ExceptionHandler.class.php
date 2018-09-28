<?php

/**
 * Handles all exceptions that bubble up throught the application
 */
class ExceptionHandler {

    /**
     * The instance of this class 
     */
    private static $instance;
    private $logger;

    /**
     * Class constructor private never called externally. 
     */
    private function __construct() {
        set_exception_handler(array($this, 'handle'));
        $this->logger = Logger::getLogger(__CLASS__);
    }

    /**
     * 
     */
    public static function instance() {
        if (!self::$instance) {
            self::$instance = new ExceptionHandler();
        }
        return self::$instance;
    }

    /**
     * Handle the exception
     * @param type $exception 
     */
    public function handle($exception) {
        if ($exception instanceof AsyncPresenterException) {
            $this->handleAsync($exception);
        } 
        else 
        {
            $errors = array();
            do 
            {
                $exceptionClass = get_class($exception);
                $errorString = sprintf("*** Exception *** %s Message: %s File:%s Line:%s", $exceptionClass, $exception->getMessage(), $exception->getFile(), $exception->getLine());
                $this->logger->debug($errorString);
                //printf("An error has occurred. See php.log for more details");
                $errors[] = $errorString;
                if ($exception instanceof GenericException) {
                    $exception = $exception->getObjCause();
                } else {
                    $exception = null;
                }
            } 
            while ($exception);
            
            $layout = new Layout();
            $data = $layout->compile('error.tpl');
            $response = new HTTPResponse();
            $response->setData($data);
            HTTPOutputStream::respond($response);
        }
    }

    /**
     * Handle exceptions thrown during async calls to the server
     * @param type $exception 
     */
    private function handleAsync($exception) {
        do {
            $exceptionClass = get_class($exception);
            $errorString = sprintf("Exception: %s Message: %s", $exceptionClass, $exception->getMessage());
            // @TODO insert msg into the JSON construct
            $this->logger->debug($errorString);
            //$this->logger->debug($exception);
            if ($exception instanceof GenericException) {
                $exception = $exception->getObjCause();
            } else {
                $exception = null;
            }
        } while ($exception);
        
        $response = new HTTPResponse();
        $response->setData("<div class='error'>An error has occurred. Please contact your system administrator</div>");
        HTTPOutputStream::respond($response);
    }

}
