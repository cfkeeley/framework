<?php

/**
 * Relationshapes 
 * Copyright Nov 15, 2012 Chris Keeley <info@relationshapes.com> All rights reserved. 
 */

class PageData extends Mixin {
    
    protected $page;
    
    protected $maxPerPage;
    
    protected $total;
    
    public function __construct($page = 1, $maxPerPage = DEFAULT_PAGE_SIZE) {
        $this->page = $page;
        $this->maxPerPage = $maxPerPage;
        $this->total = 0;
    }
    
    public function hasPages() {
        return ($this->total > 0) ? true : false;
    }
}
?>
