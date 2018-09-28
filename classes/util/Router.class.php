<?php 
/**
 *  
 * Copyright 2011 Chris Keeley <info@chriskeeley.co.uk> All rights reserved.
 * @deprecated we bypass this now straight to the dispatcher
 */
require_once('DirectoryService.class.php');
class Router {
	/**
	 * The HTTP request
	 * @var HTTPRequest
	 */
	private $request;
	/**
	 * default constructor
	 * @param unknown_type $request
	 */
	public function __construct(HTTPRequest $request) {
		$this->request = $request;
                $this->logger = Logger::getLogger(__CLASS__);
	}
	/**
	 * lookup the presenter responsible for handling the request.
	 */
	public function route() {
            $dispatcher = new Dispatcher();
            $request = $this->request;
            try {
                    $request = DirectoryService::lookupPresenter($request);
                    $this->logger->debug("Dispatching request to: {$request->get('route')}");
                    $dispatcher->dispatch($request);
            }
            catch(DirectoryServiceException $e) {
                    throw new RoutingException("Unable to route request", $e);
            }
            catch(PresenterException $c) {
                    throw new RoutingException("Unable to route request", $c);
            }	
	}
}
?>

