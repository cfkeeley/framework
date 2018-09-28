<?php
/**
 *  
 * Copyright 2011 Chris Keeley <info@chriskeeley.co.uk> All rights reserved.
 */
class UploadFile {

	/**
	 * The absolute path under the application
	 * where uploaded files will reside.
	 * @var string
	 */
	protected $absPath;

	/**
	 * The file name of the upload
	 * @var string $fileName
	 */
	public $fileName;

	/**
	 * The name of the input element used to upload the file
	 * from the front end. This will be used as the index into the $_FILES array.
	 * @var string
	 */
	protected $uploadElementName;
	
	/**
	 * The mime type of the uploaded file
	 * @var string
	 */
	protected $uploadedFileMimeType;

	/**
	 * This member holds a list of allowed mime type strings
	 * @var mixed
	 */
	protected $allowedMimeTypes = array();

	/**
	 * Class constructor
	 * @param string $inputName
	 */
	public function __construct($inputName) {
		$this->uploadElementName = $inputName;
	}

	/**
	 * This method checks that the uploaded mime type is in the list of
	 * allowed mime types.
	 * @access protected
	 * @return boolean true if in the list, false if not
	 */
	public function checkMimeType( ) {
		if( isset( $_FILES[ $this->uploadElementName ] ) ) {
			$this->uploadedFileMimeType = $_FILES[ $this->uploadElementName ][ 'type' ];
			foreach( $this->allowedMimeTypes as $mimeType ) {
				if( strcmp( $mimeType, $this->uploadedFileMimeType ) == 0 ) {
					return true;
				}
			}
		}
		return false;
	}
    
	/**
	 * This method add a mime type identifier into the list of
	 * allowed mimetypes
	 * @param string $mimeType the mime type identifier e.g 'application/pdf'
	 * @return void
	 * @access protected
	 */
	protected function addMime($mimeType) {
		if(is_array($mimeType)) {
			foreach($mimeType as $mt) {
				array_push($this->allowedMimeTypes, $mt);
			}
		}
		else {
			array_push($this->allowedMimeTypes, $mimeType);
		}
	}

	/**
	 * This method checks whether the file is within
	 * the size constraint specified within the global config
	 * file.
	 * @access public
	 * @return boolean true if the file is within the size contraints.
	 */
	public function checkSize() {
            if(isset($_FILES[$this->uploadElementName])) {
                $maxUploadLimitBytes = ceil( MAX_UPLOAD_LIMIT * 1024 * 1024 );
                 return ( $_SERVER[ 'CONTENT_LENGTH' ] <= $maxUploadLimitBytes ) ? true : false;
            }
            return false;
	}

	/**
	 * Move the uploaded file from its temp location to the place
	 * where it will reside under the applciation
	 * @return boolean true if move OK, false if not
	 */
	public function move($targetPath) {
            $absPath = $targetPath.$this->fileName;
            if(!move_uploaded_file($_FILES[$this->uploadElementName]['tmp_name'], $absPath)) {
                    throw new UploadException("The selected file could not be uploaded to the server. Please contact an Administrator");
            }
             @chmod($absPath, 0644);
            return true;
	}

    /**
     * create a unique filename
     * @param <type> $url
     * @param <type> $fileExtension
     * @return <type>
     */
    protected function createFileName( $url, $fileExtension = null ) {
       return substr(md5(rand(0, 10000) . mktime()), 0, 16)."__".basename( $url ).$fileExtension;
    }

}
?>