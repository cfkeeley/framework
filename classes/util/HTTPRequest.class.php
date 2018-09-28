<?php

/**
 *  
 * Copyright 2011 Chris Keeley <info@chriskeeley.co.uk> All rights reserved.
 * 
 * 
 * @TODO Update the get and set method to use the magic __set and __get methods.
 * This will make it much easier to reference member variables of the request object.
 */
class HTTPRequest {
    
    private $logger;

    const MIME_TYPE_JSON = 'application/json';
    const CONTENT_TYPE_HEADER = 'Content-Type';
    const PHP_INPUT_STREAM_URL = 'php://input';
    const FORMDATA_PARAMETER = 'form';
    const FORM_SUBMISSION = 'application/x-www-form-urlencoded';
    const MULTIPART_FORM = 'multipart/form-data';
    const REFERER_HEADER = 'Referer';
    const ROUTE = 'route';
    
    private $headers = array();
    private $params = null;
    private $files = null;
    private $method; // HTTP method type e.g. POST
    private $pageData;
    private $route;
    /**
     * The URI responsible for invoking this one.
     * @var type 
     */
    private $referer;
    /**
     *
     * @param type $request
     * @param type $files 
     */

    public function __construct($request = null, $files = null) {
        $this->logger = Logger::getLogger(__CLASS__);
        $this->headers = apache_request_headers();
        if (isset($this->headers[self::CONTENT_TYPE_HEADER])) {
            if (strncasecmp($this->headers[self::CONTENT_TYPE_HEADER], self::MIME_TYPE_JSON, 16) == 0) {
                $rawData = file_get_contents(self::PHP_INPUT_STREAM_URL);
                if (mb_strlen($rawData)) {
                    $json = json_decode($rawData);
                    $vars = get_object_vars($json);
                    foreach ($vars as $key => $val) {
                        $request[$key] = $val;
                    }
                }
            }
        }
        $this->extractPagingData($request);
        $this->params = $request;
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->files = $_FILES;
        
        if(isset($this->headers[self::REFERER_HEADER])) {
            $this->referer = $this->headers[self::REFERER_HEADER];
        }
        
        if(isset($this->params[self::FORMDATA_PARAMETER])) {
            $this->extractFormData($this->params[self::FORMDATA_PARAMETER]);
        }
    }
    
    /**
     *
     * @return type 
     */
    public function isFormSubmission() {
        $result = false;
        if(isset($this->headers[self::CONTENT_TYPE_HEADER])) {
            if(strncmp($this->headers[self::CONTENT_TYPE_HEADER], self::FORM_SUBMISSION, strlen(self::CONTENT_TYPE_HEADER)) == 0) {
                $result = true;
            } 
        }
        return $result;
    }
    
    /**
     *
     * @return type 
     */
    public function isMultipartFormSubmission() {
        $result = false;
        if(isset($this->headers[self::CONTENT_TYPE_HEADER])) {
            if(strncmp($this->headers[self::CONTENT_TYPE_HEADER], self::MULTIPART_FORM, strlen(self::MULTIPART_FORM)) == 0) {
                $result = true;
            } 
        }
        return $result;
    }
    
    /**
     * Extract the form data and insert into the params member set
     * @param type $formdataEncodedURL 
     */
    private function extractFormData($encodedURL) {
        $urlTokens = explode('&', $encodedURL);
        foreach($urlTokens as $pair) {
            list($k, $v) = array_map("urldecode", explode("=", $pair)); 
            $this->params[$k] = $v;
        }
    }
    
    /**
     * Extract any paging data from the request and construct an object to normalize access
     * to this data.
     */
    private function extractPagingData($request) {
        // defaults, unless we have other values in the request
        $this->pageData = new PageData(); 
        if(isset($request['page'])) {
            $this->pageData->page = intval($request['page']);
            if(isset($request['size'])) {
                $this->pageData->maxPerPage = intval($request['size']);
            }
            else {
                $this->pageData->maxPerPage = DEFAULT_PAGE_SIZE;
            }
        }
    }
    
    /**
     * Get the page data 
     * @return type
     */
    public function getPageData() {
        return $this->pageData;
    }
    
    /**
     * Get a pager instance wrapped around the page data
     */
    public function getPager($isAsync = null) {
        $data = $this->getPageData();
        $isAsyncRequest = ( $isAsync == null ) ? $this->isAsync() : $isAsync;
        $pager = new ResultSetPager($data, $isAsyncRequest);
        $pager->setURL($this->params[self::ROUTE]);
        return $pager;
    }
    
    /**
     * 
     * @return type
     */
    public function getReferer() {
        return ($this->referer) ? $this->referer : "/";
    }

    /**
     * If the HTTP method type is POST return true else false.
     * @return boolean true if is POST else false 
     */
    public function isPost() {
        return (strncasecmp($this->method, 'post', 4) == 0) ? true : false;
    }

    public function set($key, $val) {
        $this->params[$key] = $val;
    }

    public function get($key) {
        if (isset($this->params[$key])) {
            return $this->params[$key];
        }
        return null;
    }

    public function getFile($key) {
        if (isset($this->files[$key])) {
            return $this->files[$key];
        }
        return null;
    }

    public function isAsync() {
        if (array_key_exists('X-Requested-With', $this->headers)) {
            if (strcasecmp($this->headers['X-Requested-With'], 'XMLHttpRequest') == 0) {
                $this->logger->debug("This is an asynchronous request");
                return true;
            }
        }
        return false;
    }

}

?>