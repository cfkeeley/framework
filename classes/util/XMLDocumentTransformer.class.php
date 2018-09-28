<?php
/**
 *  
 * Copyright 2011 Chris Keeley <info@chriskeeley.co.uk> All rights reserved.
 */

/**
 * This class provides methods for the transformation
 * of an XML document against an XSL stylesheet. 
 */
class XMLDocumentTransformer {
	/**
	 * The XML source file
	 * @var string
	 * @access private
	 */
	private $xmlFile;
	/**
	 * The XSL source file
	 * @var string
	 * @access private
	 */
	private $xslFile;
	/**
	 * Class constructor
	 * Add the header to the xml document.
	 * @param string $xslFile path to xsl 
	 * @param string $xmlFile path to xml src
	 */
	public function __construct($xslFile, $xml) { 
		$this->xslFile = $xslFile;
		$this->xmlData = $xml;
	}
	/**
	 * Transform the data.
	 * @return mixed false if transform fails else a string of transformed data.
	 * @access public
	 */
	public function transform() {
		$xsl = new DomDocument();
		$xsl->load($this->xslFile);
		$xmlDoc = new DomDocument();
		$xmlDoc->loadXML($this->xmlData);
		$xp = new XsltProcessor();
		$xp->importStylesheet($xsl);
		$result = $xp->transformToXml($xmlDoc);
		return $result;	
	}
}
?>