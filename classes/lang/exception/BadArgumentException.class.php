<?php
/**
 *  
 * Copyright 2011 Chris Keeley <info@chriskeeley.co.uk> All rights reserved.
 */
/**
 * This class handles errors to do with bad or missing arguments/parameters
 */
class BadArgumentException extends GenericException {
	public function __construct(Exception $objCause = null, $strMessage = null, $intCode = null) {
		parent::__construct($objCause, $strMessage, $intCode);
	}
}
?>