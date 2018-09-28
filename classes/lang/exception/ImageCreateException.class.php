<?php

/**
 * Relationshapes 
 * Copyright Jan 20, 2013 Chris Keeley <info@relationshapes.com> All rights reserved. 
 */
class ImageCreateException extends GenericException {
    public function __construct(Exception $objCause = null, $strMessage = null, $intCode = null) {
            parent::__construct($objCause, $strMessage, $intCode);
    }
}
?>
