<?php

/**
 * Relationshapes 
 * Copyright Apr 29, 2012 Chris Keeley <info@relationshapes.com> All rights reserved. 
 *
 * Description of UIView
 *
 * @author chris
 */
abstract class UIView {
    
    /**
     *The layout engine for rendering view components.
     * @var type 
     */
    private $engine;
    
    /**
     * Context specific navigation menu for the UI component
     * @var type 
     */
    protected $navigation;
    
    /**
     * The main entity providing domain specific data for the view
     * @var type 
     */
    protected $model;
    
    /**
     *
     * @var type 
     */
    protected $pager;
    
    /**
     * layout backing the view
     * @var type 
     */
    private $layout;
    
    /**
     *
     * @var type 
     */
    private $viewDirectoryPrefix;
    
    /**
     *
     * @var type 
     */
    private $log;
    
    /**
     *any data that needs to be passed to the view
     * @var type 
     */
    private $data;
    
    /**
     *
     * @var type 
     */
    protected $logger;
    
    /**
     * Application context
     * @var type 
     */
    protected $context;

    /**
     * 
     */
    public function __construct($model = null) {
        if($model) {
            $this->model = $model;
        }
        $this->engine = Layout::$engine;
        $this->viewDirectoryPrefix = SMARTY_VIEW_DIR;
        $this->data = null;
        $this->logger = Logger::getLogger(__CLASS__);
    }
    
    /**
     * 
     * @param HttpContext $context
     */
    public function setContext(HttpContext $aContext) {
        $this->context = $aContext;
    }
    
    
    protected function getContext() {
        return $this->context;
    }
    
    /**
     *
     * @param type $data 
     */
    public function setData($data) {
        $this->data = $data;
    }
    
    /**
     * 
     */
    public function getData() {
        return $this->data;
    }
    
    public function getLayout() {
        return $this->layout;
    }
    
    public function setLayout($layout = null) {
        $this->logger->debug("Setting layout: {$layout}");
        $this->layout = $layout;
    }
    
    /**
     * Semantically meaningful call to be used when building component views/layouts
     * @param type $view 
     */
    public function setView($view = null) {
        $this->logger->debug("Setting view: {$view}");
        $this->layout = $view;
    }
    
    public function assign($key, $val) {
        $this->engine->assign($key,$val);
    }
    
    public function compileLayout() {
        $layout = $this->viewDirectoryPrefix.'/'.$this->layout;
        $html = $this->engine->fetch($layout);
        return $html;
    }
    
    /**
     *
     * @param type $pager 
     */
    public function setPager(ResultSetPager $pager) {
        $this->pager = $pager;
    }
    
    /**
     *
     * @param UIViewStyle $style 
     */
    public function setStyle(UIViewStyle $style) {
        $this->style = $style;
    }
    
    /**
     *
     * @return type 
     */
    public function getStyle() {
        return $this->style;
    }
    
    /**
     *
     * @param UIView $navigation 
     */
    public function setNavigation(SetEntity $navigation) {
        $this->navigation = $navigation;
    }
    
    /**
     * 
     * @return type
     */
    public function getNavigation() {
        return $this->navigation;
    }
    
    /**
     *
     * @param type $model 
     */
    public function setModel($model) {
        $this->model = $model;
    }
    
    /**
     * Render a ui respresentation of the associated entity/model
     * returns the rendered data representation
     */
    abstract function render();

}
?>
