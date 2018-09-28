<?php

/**
 * Relationshapes 
 * Copyright Apr 17, 2012 Chris Keeley <info@relationshapes.com> All rights reserved. 
 *
 * Description of JSONResponse
 *
 * @author chris
 */
class JSONResponse {

    /**
     *
     * @var type 
     */
    private $data;
    
    /**
     *
     * @var type 
     */
    private $error;
    
    /**
     * 
     */
    public function __construct() {
        $this->data = array();
        $this->error = null;
    }
    
    /**
     *
     * @param type $error 
     */
    public function addError($error) {
        $this->error = $error;
    }
    
    /**
     *
     * @param type $data 
     */
    public function addData($data) {
        $this->data = $data;
    }
    
    /**
     * 
     * 
     */
    public function display() {
        $json['payload'] = $this->data;
        $json['error'] = $this->error;
        $encoded = json_encode($json, true);
        ob_start();
        echo $encoded;
        ob_flush();
    }

}

?>
