<?php
/**
 *  
 * Copyright 2011 Chris Keeley <info@chriskeeley.co.uk> All rights reserved.
 */
/**
 * Map routes to the handlers responsible for executing them.
 * This can be revisited some time since the values is looked up we can provide whatever implementation 
 * we like.
 * 
 * Usage: url => mapping
 * 
 * 
 * URLs can contain placeholders that get mapped to their real values in the request url:
 * E.g.
 * 
 * /example/url/%exampleid%
 * 
 * for a request URL such as:
 * 
 * /example/url/heypresto
 * 
 * Would map the value heypresto to the variable name exampleid.
 * 
 * Thus in the presenter class you can call:
 * 
 * $request = $this->getRequest();
 * 
 * $id = $request->get('exampleid');
 * 
 * The value of $id would be 'heypresto'
 * 
 * @TODO add some type enforcement into the request->get method.
 * e.g. $request->get('exampleid', TYPE_INT);
 * 
 */
$directory = array
( 
    /**
     *  show the index page
     */
    'index' =>          'Index'
);