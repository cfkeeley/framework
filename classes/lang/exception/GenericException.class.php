<?php
/**
 *  
 * Copyright 2011 Chris Keeley <info@chriskeeley.co.uk> All rights reserved.
 */
/**
 * This file extends the default exception and 
 * provides functionality for nested exceptions
 */
class GenericException extends Exception {
	
        /**
	 * @var GenericException the cause of this exception
	 * @access private
	 */
	protected $objCause;
	
        /**
	 * Class constructor
	 * Init member variables and call parent constructor
	 * @access public
	 */
	public function __construct(Exception $objCause = null, $strMessage = null, $intCode = 0) {
		parent::__construct($strMessage, $intCode);
                $this->objCause = $objCause;
	}
        
        /**
         *
         * @return type 
         */
        public function getObjCause() {
            return $this->objCause;
        }
}
?>