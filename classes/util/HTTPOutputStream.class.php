<?php

/**
 * Relationshapes 
 * Copyright May 24, 2012 Chris Keeley <chris@relationshapes.com> All rights reserved. 
 *
 * Description of OutputStream
 *
 * @author chris
 */
class HTTPOutputStream {
    /**
     * @TODO make this an instance method and construct in front controller
     * to receive the response from the dispatcher
     * @param HTTPResponse $response 
     */
    public static function respond(HTTPResponse $response) {
        //$logger = Logger::getLogger('http');
        $headers = $response->getHeaders();
        // turn on the output buffering
        ob_start();
        if($headers) {
            foreach($headers as $header) {
                header($header);
            }
        }
        // the actual data (if any)
        $data = $response->getData();
        if($data) {
            //$logger->debug($data);
            echo $data;
        }
        // flush the buffer
        ob_end_flush();
    }

}

?>
