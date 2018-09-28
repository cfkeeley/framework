<?php

/**
 * Relationshapes 
 * Copyright Feb 16, 2013 Chris Keeley <info@relationshapes.com> All rights reserved. 
 */
class EntityNotFoundException extends GenericException {
    public function __construct(Exception $objCause = null, $strMessage = null, $intCode = null) {
            parent::__construct($objCause, $strMessage, $intCode);
    }
}
?>
