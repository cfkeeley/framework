<?php
/**
 *  
 * Copyright 2011 Chris Keeley <info@chriskeeley.co.uk> All rights reserved.
 */
class Image {
	/**
	 * The full path to the image file
	 * @var string
	 * @access private 
	 */
	private $imageUrl;
	/**
	 * New filename for the generated image
	 * @var string
	 * @access private 
	 */
	public $newFilename; 
	/**
	 * Image attributes such as width, height, mimetype, bits et al
	 * as returned from @see http://uk.php.net/manual/en/function.getimagesize.php
	 * @var mixed $dimensions
	 * @access private 
	 */
	private $attr;
	/**
	 * the location on the filesystem to store optimised images
	 * @var string 
	 * @access private 
	 */
	private $optUrl;
        /**
         * size of the newly created file on disk.
         * @var <type>
         */
        public $fileSizeOnDisk;
        
        /**
         *
         * @var type 
         */
        private $size;
	
	/**
	 * Class constructor
	 * @param string $imageUrl path to the image
	 */
	public function __construct($imageUrl = null, $uploadPath = null, $x = null, $y = null) {
            $this->imageUrl = realpath($imageUrl);
            if(file_exists($this->imageUrl)) {
                    $imageAttributes = getimagesize($this->imageUrl);
                    $this->attr = $imageAttributes;
                    $this->size = new stdClass();
                    $this->size->x = ($x == null)?128:$x;
                    $this->size->y = ($y == null)?128:$y;
                    $this->optUrl = $uploadPath;
            } 
	}
        
        public function getNewFilename() {
            return $this->newFilename;
        }
        
        public function getAbsNewFilename() {
            return $this->optUrl . $this->newFilename;
        }
	
	/**
         * 
         */
	public function create() {
            switch($this->attr['mime']) {
                case 'image/png': 
                    $imageHandle = imagecreatefrompng($this->imageUrl);
                    $ext = ".png"; 
                break;
                case 'image/jpeg':
                case 'image/pjpeg':
                    $imageHandle = imagecreatefromjpeg($this->imageUrl);
                    $ext = ".jpeg"; 
                break;
                case 'image/gif': 
                    $imageHandle = imagecreatefromgif($this->imageUrl); 
                    $ext = ".gif";
                    break;
                default:
                            throw new ImageCreateException("Mime type {$this->attr['mime']} is not currently supported. Supported types: jpeg, png or gif");
                    break;	
            }

            if(!$imageHandle) {
                throw new ImageException("Image creation failed for mime type: {$this->attr['mime']} ");
            }
		
            // existing attributes
            $width = $this->attr[0];
            $height = $this->attr[1];

            $new_width = $this->size->x; //PROFILE_PIC_WIDTH;
            $new_height = $this->size->y; //PROFILE_PIC_HEIGHT;
		
            $this->newFilename = substr( md5( rand( 0, 10000 ) . time( ) ), 0, 16 )."__".basename( $this->imageUrl ).$ext;

            // this will hold the new image data resamples from the original
            $can_img = imagecreatetruecolor($new_width, $new_height);
            // init ready to receive the data
            $bgColor = imagecolorallocate($can_img, 255, 255, 255);
            // fill with white
            imagefill($can_img, 0, 0, $bgColor);
            // copy the image data
            if(! imagecopyresampled($can_img, $imageHandle, 0, 0, 0, 0, $new_width, $new_height, $width, $height)) {
                throw new ImageException("Unable to copy or resize image");
            }
            // determine the quality setting of the image
            $imageQuality = 100; //($width < 150 || $height < 15) ? 100 : $this->size['image_quality'];

            $fullPath = $this->optUrl . $this->newFilename;

            // create a jpeg image from the resampled data
            if (imagejpeg($can_img, $fullPath, $imageQuality)) {
                // set permissions to none executable and stat the image
                @chmod($fullPath, 0644);
                $this->fileSizeOnDisk = sprintf("%u", filesize($fullPath));
            }
            else {
                    throw new ImageCreateException(null, "Unable to create new image using data from original");
            }
            imagedestroy($imageHandle);
    }
	
}
?>