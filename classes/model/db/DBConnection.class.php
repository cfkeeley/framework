<?php
/**
 *  
 * Copyright 2011 Chris Keeley <info@chriskeeley.co.uk> All rights reserved.
 */
class DBConnection {
    /**
     *
     * @var type 
     */
    public static $instance;
    /**
     * 
     */
    private function __construct() { 
        /* do nothing */ 
    }
    /**
     *
     * @return type 
     */
    public static function instance() {
        if(!isset(DBConnection::$instance)) {
            $dbOpts = array( PDO::ATTR_PERSISTENT => true );
            try {
                DBConnection::$instance = new FrameworkPDO('mysql:host=127.0.0.1;dbname='.DB_NAME, DB_USER, DB_PASSWORD, $dbOpts);	
                DBConnection::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ); 
                DBConnection::$instance->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
                DBConnection::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } 
            catch( PDOException $pdoe ) {
                throw new DBException($pdoe, 'Unable to obtain a DB connection instance');
            }
        }
        return DBConnection::$instance;
    }
}
?>