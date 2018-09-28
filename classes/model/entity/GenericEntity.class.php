<?php

/**
 * Relationshapes 
 * Copyright Aug 2, 2012 Chris Keeley <info@relationshapes.com> All rights reserved. 
 */
class GenericEntity {
    /**
     *
     * @var type 
     */
    protected $created_on;
    /**
     *
     * @var type 
     */
    protected $updated_on;
    
    /**
     * If set to true all dates will be returned as instances of DateTime
     * when they are set using the magic methods.
     * This allows us to use get_object_vars as a shorthand for getting the object state
     * usually for transformation into another encoding. If the dates are objects then
     * get object vars falls over.
     * @var boolean 
     */
    protected $useDateTime;
    
    /**
     * Date fields that can be translated to object equivalents
     * @var type 
     */
    protected $dateFields = array(
        'updated_on', 
        'created_on', 
        'completion_date'
    );
    
    /**
     * Construct the class. If $record is not null then the object will be populated 
     * using the members of the passed in object.
     * @param type $record 
     */
    public function __construct($record=null, $useDateTime = false) {
        $this->useDateTime = $useDateTime;
        if($record) {
            $vars = get_object_vars($record);
            foreach($vars as $key=>$val) {
                $this->$key = $val;
            }
        }
    }
    
    /**
     *
     * @param type $useDateTime 
     */
    public function setUseDateTime($useDateTime = false) {
        $this->useDateTime = $useDateTime;
    }
    
    /**
     *
     * @param type $member
     * @return type
     * @throws PropertyNotExistsException 
     */
    public function __get($member) {
        if(property_exists($this, $member)) {
            $property = null;
            if(in_array($member, $this->dateFields)) {
                if($this->useDateTime) {
                    $property = new DateTime($this->$member, new DateTimeZone('Europe/London'));
                }
                else {
                    $property = $this->$member;
                }
             }
             else {
                 $property = $this->$member;
             } 
             return $property;
        }
        else {
            throw new PropertyException(null, "Named property:{$member} does not exist in ".__CLASS__);
        }
    }
    /**
     *
     * @param string $member
     * @param string $value
     * @return boolean
     * @throws PropertyException 
     */
    public function __set($member,$value) {
        if(property_exists($this, $member)) {
            if(is_array($this->$member)) {
                array_push($this->$member,$value);
            }
            else {
                switch($member) {
                    case 'updated_on':
                    case 'created_on':
                        if($this->useDateTime) {
                            $this->$member = new DateTime($value, new DateTimeZone('Europe/London'));
                        }
                        else {
                            $this->$member = $value;
                        }
                    break;
                    default:
                        $this->$member = $value;
                    break;
                }
                
            }
            return true;
        }
        else {
            /**
             * @TODO __CLASS__ doesn't resolve as expected e.g. not as the descendant. 
             */
            throw new PropertyException(null, "Named property:{$member} does not exist in ".__CLASS__);
        }
    }
    
    /**
     *
     * @return Entity 
     */
    public function getState() {
        return $this;
    }
}
?>
