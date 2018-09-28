<?php

/**
 * Relationshapes 
 * Copyright Dec 30, 2012 Chris Keeley <chris@relationshapes.com> All rights reserved. 
 * 
 */

class Calendar extends Mixin implements Iterator {
    
    
    protected $month;
    
    protected $year;
    
    private $day;
    
    private $numDays;
    
    private $type = CAL_GREGORIAN;

    /**
     * The current item being evaluated
     * @var type
     */
    private $position;
    
    /**
     * Default formatting
     * @var type 
     */
    private $format = 'd-m-Y';
    
    /**
     * Assigned datetime object used to init the calendar
     * @var type 
     */
    private $dt_context;
    
    /**
     * 
     */
    public function __construct(DateTime $dt = null) {
        
        $tokens = null;
        if($dt) {
            $this->dt_context = $dt;
            $tokens = explode('-', $dt->format($this->format));
        }
        else {
            $now = new DateTime();
            $this->dt_context = $dt;
            $tokens = explode('-', $now->format($this->format));
        }
        
        $this->day = $tokens[0]; 
        $this->month = $tokens[1]; 
        $this->year = $tokens[2];
        
        $this->numDays = $num = cal_days_in_month($this->type, $this->month, $this->year);
        $this->position = 1;// first day of the month
    }
    
    /**
     * Get the DateTime instance used to initialise the calendar.
     */
    public function getDTContext() {
        return $this->dt_context;
    }
    
    public function year() {
        return $this->year;
    }
    
    public function month() {
        $name = date("F", mktime(0, 0, 0, $this->month, 10));
        return $name;
    }
    
    public function current() {
        return new DateTime("{$this->position}-{$this->month}-{$this->year}");
    }
    
    public function key() {
        return $this->position;
    }
    
    /**
     * Get the next DateTime instance from the calendar 
     */
    public function next() {
        ++$this->position;
    }
    
    public function rewind() {
        $this->position = 1;
    }
    
    /**
     * Valid if we are within the bounds of the current month
     * @return type 
     */
    public function valid() {
        return ($this->position <= $this->numDays) ? true : false;
    }
}
?>
