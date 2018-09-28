<?php
/**
 * Description of ShapeRadius
 *
 * @author chris
 */
class ShapeRadius {
    
    private $maxRadius;
    private $scale;
    private $canvasHeight;
    private $canvasWidth;
    
    /**
     * 
     * @param integer $defaultRadius
     * @param integer $scale 
     */
    public function __construct($height=600, $width=500, $defaultRadius=250,$scale=6) {
        $this->canvasHeight = $height;
        $this->canvasWidth = $width;
        $this->maxRadius=$defaultRadius;
        $this->scale=$scale;
    }
    
    /**
     *
     * @param type $height 
     */
    public function setCanvasHeight($height) {
        $this->canvasHeight = $height;
    }
    
    /**
     *
     * @param type $width 
     */
    public function setCanvasWidth($width) {
        $this->canvasWidth = $width;
    }
    /**
     * calculate the new radius using the factor, the current radius and the 
     * unfactored weight that will become the new radius after being multiplied by the factor
     * @param integer $weight
     */
    public function calculate($weight) {
        $radius = $this->maxRadius;
        $scale = $this->scale;
        $factor = $radius / $scale;
        $newRadius = round($radius - $weight * $factor);
        // @TODO is new radius is equal to max radius we neec to reudce it slightly or find some other
        // way of displaying results where they are on top of each other
        // this will not be an issue in the 3D version of the shape
        return $newRadius;
    }
    
    /**
     * @TODO move centerX and centerY assignment out of here allowing them to be set by caller
     * @param type $radius
     * @param type $angle
     * @return \stdClass 
     */
    public function XY($radius,$angle) {
       $centerX = $this->canvasHeight/2;
       $centerY = $this->canvasWidth/2;
       $data = new stdClass();
       $data->x = $centerX+$radius*sin(deg2rad($angle));
       $data->y = $centerY+$radius*-cos(deg2rad($angle));
       return $data;
    }

}

?>
