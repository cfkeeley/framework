<?php

/**
 * Relationshapes 
 * Copyright Apr 29, 2012 Chris Keeley <info@relationshapes.com> All rights reserved. 
 *
 * Description of HTTPResponse
 *
 * @author chris
 */
class HTTPResponse {
    
    /**
     * The set of HTTP headers for the response
     * @var type 
     */
    private $headers;
    
    /**
     * The data for the http response 
     */
    private $html;
    
    /**
     *
     * @var type 
     */
    private $data;
    
    /**
     *
     * @param type $data 
     */
    public function __construct() {
        $this->html = null;
        $this->headers = array();
    }
    
    /**
     *
     * @param type $data 
     */
    public function setData($data = null) {
        $this->data = $data;
    }
    
    /**
     *
     * @return type 
     */
    public function getData() {
        return $this->data;
    }
    
    /**
     *
     * @return type 
     */
    public function getHeaders() {
        return $this->headers;
    }
    
    /**
     *
     * @param type $header 
     */
    public function header($header) {
        $this->headers[] = $header;
    }
    
    /**
     * 
     * @param type $url
     */
    public function redirect($url) {
        $this->headers[] = "Location: {$url}";
    }

}

?>
