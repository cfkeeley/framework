<?php

/**
 * Relationshapes 
 * Copyright Dec 25, 2012 Chris Keeley <info@relationshapes.com> All rights reserved. 
 *
 * Description of FrameworkPDO
 *
 * @author chris
 */
class FrameworkPDO extends PDO {
    
    private $logger;

    /**
     * True if already in a transaction, else false.
     * @var boolean 
     */
    private $inTx = false;
    
    /**
     * 
     * @param type $dsn
     * @param type $username
     * @param type $passwd
     * @param type $options
     */
    public function __construct($dsn, $username, $passwd, $options) {
        $this->logger = Logger::getLogger(__CLASS__);
        parent::__construct($dsn, $username, $passwd, $options);
    }
    
    /**
     * 
     * @return type
     */
    public function getAlreadyInTransaction() {
        return $this->inTx;
    }
    
    /**
     * 
     * @param type $inTx
     */
    public function setAlreadyInTransaction($inTx = false) {
        $this->inTx = $inTx;
    }

}

?>
