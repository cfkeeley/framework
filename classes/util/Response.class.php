<?php
/**
 *  
 * Copyright 2011 Chris Keeley <info@chriskeeley.co.uk> All rights reserved.
 */

/**
 * this class represents a response from the server.
 * passed back from delegates and parsed by router.
 * @author chris
 *
 */
class Response implements DelegateResponder {
	
	private $dataFormat;
	private $error;
	private $msg;
	private $view;
	private $headers = array();
	private $data = array();
	
	public function Response($format='smarty') {
		$this->dataFormat = $format;
		$this->error = false;
		switch ($this->dataFormat) {
			default:
				$this->view = true;
				break;
		}
	}
	
	public function setHeader($header) {
		array_push($this->headers, $header);
	}
	
	public function unSetHeader($header) {
		// search for header and remove
		foreach($this->headers as $hdr) {
			if(strcasecmp($hdr, $header)==0) {
				// remove header
			}
		}
	}
	
	public function getFormat() {
		return $this->dataFormat;
	}
	
	public function setFormat($format) {
		$this->dataFormat = $format;
	}
	
	public function hasError() {
		return $this->error;
	}
	
	public function setHasError() {
		$this->error = true;
	}
	
	public function getErrorMessage() {
		return $this->msg;
	}
	
	public function setErrorMessage($msg) {
		return $this->msg = $msg;
	}
	
	public function setView($view = 'index.tpl') {
		$this->view = $view;
	}
	
	public function getView() {
		return $this->view;
	}
	
	public function setRawData($rawData) {
		$this->data = $rawData;
	}
	
	public function getRawData() {
		return $this->data;
	}
	
	public function setViewParam($varString, $varValue) {
		$this->data[$varString] = $varValue;
	}
	
	public function interpolateViewParams(&$view) {
		foreach($this->data as $name => $val) {
			$view->assign($name, $val);
		}
	}	
}