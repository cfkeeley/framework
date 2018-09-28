<?php

/**
 *  
 * Copyright 2011 Chris Keeley <info@chriskeeley.co.uk> All rights reserved.
 */
require_once 'config/routes.php';
class DirectoryService {

    /**
     * Never used as this class implements singleton pattern. 
     */
    final private function __construct() {
        /* Do nothing */
    }

    /**
     * Determine the name of the class mapped to the route.
     * Populate and return the request object.
     * @param $route
     * 
     * @TODO Improve by substituting url <-> directory entry search with regex matching
     */
    public static function lookupPresenter(HTTPRequest $request) {
        $logger = Logger::getLogger('directory');
        global $routes;
        $matchCount = 0;
        $aMatch = null;
        $aRoute = $request->get('route');
        if (!$aRoute) {
            $aRoute = 'index';
        } else if (strstr($aRoute, '.')) {
            $tokens = explode('.', $aRoute); // @todo change this
            $aRoute = $tokens[0];
        }
        $route = explode('/', $aRoute);
        $routeCount = count($route);
        $parms = null;

        foreach ($routes as $key => $val) {
            $keyTokens = explode('/', $key);
            $keyTokensCount = count($keyTokens);
            $matchCount = 0;
            $parms = null;
            if ($routeCount == $keyTokensCount) {
                for ($i = 0; $i < $keyTokensCount; $i++) {
                    $current = $keyTokens[$i];
                    $routeElem = $route[$i];
                    if (preg_match('/^%(\w+)%$/', $current, $matches)) {
                        $parms[$matches[1]] = $routeElem;
                        $matchCount++;
                    } else if (strcasecmp($current, $routeElem) == 0) {
                        $matchCount++;
                    } else {
                        break;
                    }
                }
                if ($matchCount == $routeCount) {
                    $logger->debug("Resolved URI: [{$key}]");
                    $aMatch = $key;
                    break;
                }
            }
        }

        if ($aMatch) {
            if ($parms) {
                foreach ($parms as $key => $val) {
                    $logger->debug("Mapped {$key}=>{$val} and pushed into request");
                    $request->set($key, $val);
                }
            }
            
            // get the mapping from the URLDirectory entry
            $map = $routes[$aMatch];
            if(isset($map['presenter'])) {
                $logger->debug("Setting presenter: [{$map['presenter']}]");
                $request->set('presenter', ucfirst($map['presenter']));
            }
            
            if(isset($map['hooks'])) {
                $request->set('hooks', $map['hooks']);
            }
            
            if(isset($map['roles'])) {
                $request->set('roles', $map['roles']);
            }

        } else {
            throw new DirectoryServiceException(null, "URI not found: [{$aRoute}]");
        }
        return $request;
    }

}