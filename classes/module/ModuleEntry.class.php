<?php

/**
 * Relationshapes 
 * Copyright Sep 16, 2013 Chris Keeley <info@relationshapes.com> All rights reserved. 
 * All modules should return this populated from the init method of Module
 */
class ModuleEntry {
    
    private $routes;
    private $items;
    private $name;
    private $path;
    private $groups = Array();
    
    public function setPath($aPath) {
        $this->path = $aPath;
    }
    
    public function getPath() {
        return $this->path;
    }
    
    public function setGroups(array $groups) {
        $this->groups = $groups;
    }
    
    public function getGroups() {
        return $this->groups;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function setName($name) {
        $this->name = $name;
    }
    
    public function setItems(array $items) {
        $this->items = $items;
    }
    
    public function getItems() {
        return $this->items;
    }
    
    public function getRoutes() {
        return $this->routes;
    }
    
    public function setRoutes(array $routes) {
        $this->routes = $routes;
    }
}
?>
