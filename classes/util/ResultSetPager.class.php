<?php

/**
 * Relationshapes 
 * Copyright May 4, 2012 Chris Keeley <chris@relationshapes.com> All rights reserved. 
 *
 * Description of ResultSetPager
 *
 * @author chris
 */
class ResultSetPager extends Mixin {
    
    /**
     *
     * @var type 
     */
    private $size;
    
    /**
     *
     * @var type 
     */
    private $current;
    
    /**
     *
     * @var type 
     */
    protected $pages;
    
    /**
     *
     * @var type 
     */
    private $total;
    
    /**
     * The url to assign each page link
     * @var type 
     */
    private $url;
    
    /**
     * The CSS class ID to assign the pager link node
     * @var type 
     */
    private $class;
    
    /**
     * the class for each top level item in the list
     * @var type 
     */
    private $item_class;
    
    /**
     * Set of key=>val pairs to add onto the link URLs
     * @var type 
     */
    private $args = array();
    
    /**
     * 
     */
    public function __construct(PageData $data = null, $isAsync = false) {
        $this->current = $data->page;
        $this->size = $data->maxPerPage;
        $this->url = null;
        $this->class = 'uipagerlink';
        $this->item_class = ($isAsync) ? 'asyncuipageritem' : 'uipageritem';
    }
    
    public function __clone() {
        return $this;
    }
    
    public function getCurrentPage() {
        return $this->current;
    }
    
    /**
     *
     * @param type $key
     * @param type $val 
     */
    public function addUrlArg($key,$val) {
        $this->args[$key] = $val;
    }
    
    /**
     * 
     */
    public function hasPages() {
        return ($this->pages > 0) ? true : false;
    }
    
    /**
     *
     * @param type $total 
     */
    public function setTotal($total) {
        if($total > 0) {
            $this->total = intval($total);
            $this->calculatePages();
        }
    }
    
    /**
     *
     * @param type $url 
     */
    public function setURL($url) {
        $this->url = $url;
    }
    
    /**
     * 
     */
    public function setCurrent($current) {
        $this->current = intval($current);
    }
    
    /**
     *
     * @param type $classID 
     */
    public function setPagerLinkClassID($classID) {
        $this->class = $classID;
    }
    
    /**
     * 
     */
    public function getLimit() {
        return $this->size;
    }
    
    /**
     * Calculate the offset
     */
    public function getOffset() {
        $offset = 0;
        if($this->current) {
            $current = $this->current;
            $offset = --$current * $this->size;
        }
        return $offset;
    }
    
    /**
     * Given the set size and the total records, calculate the number of pages
     * 
     */
    private function calculatePages() {
       $this->pages = round($this->total / $this->size);
    }
    
    /**
     * Generate a pager string
     * @TODO move this to a UIView based approach
     */
    public function pagerNodeSet() {
        
        if($this->pages > 0) {
            $pager = "<div class='uisetpager'>";
            $rigtharrow = "Next";
            $leftarrow = "Prev";

            if($this->url) {  
                
                $pos = strpos($this->url,'?');
                $joiner = ($pos > 0) ? "&" : "?";
                
                $pager .= "<div class='{$this->item_class}'>";
                if($this->current > 1) {
                    $pagePrevious = $this->current;
                    $pagePrevious--;
                    $pager .= "<a class='{$this->class}' href='/{$this->url}{$joiner}page={$pagePrevious}'>{$leftarrow}</a>";
                }
                else {
                    $pager .= "{$leftarrow}";
                }
                $pager .= "</div>";

                for($ix = 1; $ix <= $this->pages; $ix++) {
                    $pager .= "<div class='{$this->item_class}'>";
                    if($ix == $this->current) {
                        $pager .= "<span id='uipagercurrent'>{$ix}</span>";
                    }
                    else {
                        $pager .= "<a class='{$this->class}' href='/{$this->url}{$joiner}page={$ix}'>{$ix}</a>";
                    }
                    $pager .= '</div>';
                }

                $pager .= "<div class='{$this->item_class}'>";
                if($this->current < $this->pages) {
                    $pageNext = $this->current;
                    $pageNext++;
                    $pager .= "<a class='{$this->class}' href='/{$this->url}{$joiner}page={$pageNext}'>{$rigtharrow}</a>";
                }
                else {
                    $pager .= "{$rigtharrow}";
                }
                $pager .= "</div>";


                $pager .= "<div class='breaker'></div>";
            }

            $pager .= "</div>";
            return $pager;
        }
        else {
            return null;
        }
    }
  

}

?>
