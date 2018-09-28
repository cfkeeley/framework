<?php

/**
 *  
 * Copyright 2011 Chris Keeley <info@chriskeeley.co.uk> All rights reserved.
 */

/**
 * This class handles all errors related to controllers.
 */
class PresenterException extends GenericException {
	public function __construct(Exception $objCause = null, $strMessage = null, $intCode = null) {
		parent::__construct($objCause, $strMessage, $intCode);
	}
}

?>