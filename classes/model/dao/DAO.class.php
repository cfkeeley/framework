<?php

/**
 *  
 * Copyright Jan 29, 2012 2:31:26 PM Chris Keeley <info@chriskeeley.co.uk> All rights reserved. 
 *
 * Description of Service
 *
 * @author chris
 */
abstract class DAO extends Mixin {
    
    /**
     * Access to the DB connection handle
     * @var type 
     */
    protected $dbh;
    
    /**
     *
     * @var ResultSetPager 
     */
    protected $pager;
    
    /**
     *
     * @var type 
     */
    protected $logger;
    
    /**
     * 
     */
    public function __construct(ResultSetPager $pager = null) {
        $this->dbh = DBConnection::instance();
        if($pager) {
            $this->pager = $pager;
        }
        $this->logger = Logger::getLogger(__CLASS__);
    }
    
    /**
     *
     * @param type $pager 
     */
    public function setPager(ResultSetPager $pager) {
        $this->pager = $pager;
    }
    
    /**
     * Execute the PDO Statement.
     * @param PDOStatement $stmt 
     */
    protected function execute(PDOStatement $stmt) {
        $this->logger->debug("*** Executing SQL Statement: ");
        $this->logger->debug($stmt);
        $stmt->execute();
    }
    
    /**
     * Begin a DB transaction sequence
     * @throws DBException 
     */
    protected function beginTX() {
        if(!$this->dbh->getAlreadyInTransaction()) {
            $this->logger->debug("Beginning DB Transaction");
            $this->dbh->setAlreadyInTransaction(true);
            $inTransaction = $this->dbh->beginTransaction();
            if(!$inTransaction) {
                $this->dbh->rollBack();
                throw new DBException("Unable to enter transaction! Cannot proceed. Rolling back");
            }
        }
    }
    
    /**
     * Commit a DB transaction sequence.
     * @throws DBException 
     */
    protected function commitTX() {
        if($this->dbh->getAlreadyInTransaction()) {
            $this->logger->debug("Committing DB Transaction");
            $committed = $this->dbh->commit();
            if(!$committed) {
                $this->dbh->rollBack();
                throw new DBException("Unable to commit transaction! Cannot proceed. Rolling back");
            }
            $this->dbh->setAlreadyInTransaction(false);
        }
    }
    
    /**
     *Rollback a DB transaction sequence. 
     */
    protected function rollBackTX() {
        if($this->dbh->getAlreadyInTransaction()) {
            $this->logger->debug("Rolling back DB Transaction");
            $this->dbh->rollBack();
            $this->dbh->setAlreadyInTransaction(false);
        }
    }
}

?>
