<?php
/**
 * Adds set related functionality to generic Entities 
 */
class SetEntity extends Entity implements Iterator {
    
    protected $logger;
    
    /**
     * The elements of the set
     * @var mixed determined by the extending implementation
     */
    protected $elements;
    
    /**
     * The current element being iterated over.
     * @var type 
     */
    private $current;
    
    /**
     *
     * @var type 
     */
    protected $pager;
    
    /**
     * 
     */
    public function __construct() {
        parent::__construct();
        $this->elements = array();
        $this->current = 0;
        $this->logger = Logger::getLogger(__CLASS__);
    }
    
    public function initWithArray($elements) {
        $this->elements = $elements;
    }
    
    /**
     * Add an element into the set
     * @param type $element 
     */
    public function addElement(Entity $element) {
        $this->elements[] = $element;
    }
    
    /**
     * return the current element from the set
     */
    public function current() {
        return $this->elements[$this->current];
    }
    
    /**
     * Move the current position to the next element.
     */
    public function next() {
        $this->current++;
    }
    
    /**
     * Whether or not we have any elements left in the list 
     */
    public function hasNext() {
        $size = $this->size();
        return ($this->current == --$size) ? false : true;
    }
    
    /**
     * Return the key of the current element.
     * In this implementation it is always the integer 
     * value of the current index
     */
    public function key() {
        return $this->current;
    }
    
    /**
     * Rewind the internal current pointer to the beginning of the list.
     * In this case: zero.
     */
    public function rewind() {
        $this->current = 0;
    }
    
    /**
     * Determine if the element references by current is actually a valid element.
     * @return type 
     */
    public function valid() {
        if(isset($this->elements[$this->current])) {
            return (boolean)true;
        }
        return (boolean)false;
    }
    
    /**
     * Number of elements in the current set
     * @return type 
     */
    public function size() {
        return count($this->elements);
    }
    
    public function toArray() {
        return $this->elements;
    }
    
    /**
     * 
     * @param type $index
     */
    public function getElement($index) {
        if(isset($this->elements[$index])) {
            return $this->elements[$index];
        }
        return null;
    }
    
}
?>
