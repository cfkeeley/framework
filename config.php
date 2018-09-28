<?php
/**
 * Application paths 
 */
define("APP_NAME", 'framework');
define('ROOT', '/Users/chris/www/'.APP_NAME);
define("SMARTY_DIR", ROOT.'/lib/Smarty-3.0.6/libs/');
define("VIEW_DIR", 'views');
define("SMARTY_TEMPLATE_DIR", ROOT.'/'.VIEW_DIR.'/templates');
define("SMARTY_COMPILE_DIR", ROOT.'/'.VIEW_DIR.'/templates_c');
define("SMARTY_CACHE_DIR", ROOT.'/'.VIEW_DIR.'/cache/');
define("SMARTY_CONFIG_DIR",ROOT.'/'.VIEW_DIR.'/config/');
define("SMARTY_PLUGIN_DIR", ROOT.'/'.VIEW_DIR.'/plugins/');
define("AUTOLOAD_CACHE_FILE", ROOT.'/autoload.cache');
define("DEFAULT_PAGE_SIZE", 10);
define("DB_NAME", '');
define("DB_USER", '');
define("DB_PASSWORD", '');
define("IMAGE_UPLOAD_PATH",ROOT.'/uploads/images/');
/**
 * include paths 
 */
//ini_set('include_path', ini_get('include_path').":".ROOT.":".ROOT."/lib/classes/:".ROOT."/lib/classes/util:".ROOT."/lib/Smarty-3.0.6/libs/:".ROOT."/lib/Smarty-3.0.6/libs/plugins:".ROOT."/lib/Smarty-3.0.6/libs/sysplugins");
/**
 * when invoked from __autoload() the ClassLoader will use these as entry points
 * to recurse through looking for classes.
 */
$classPaths = array( 
	ROOT.'/lib/',
	ROOT.'/resources/'
);
/**
 * default skin
 */
define("DEFAULT_SKIN", 'default.css');
/**
 * path to skin 
 */
define("SKIN_PATH", '/skin/default');
/**
 * path for uploaded pics
 */
define("PROFILE_PIC_PATH",'/uploads/images');
/**
 * Upon each invocation of the PHP application, Smarty tests to see if the current
 * template has changed (different time stamp) since the last time it was compiled.
 * If it has changed, it recompiles that template.
 * If the template has not been compiled, it will compile regardless of this setting.
 * Set this to false for production sites for performance purposes.
 * *** NOTE: TURN OFF FOR PRODUCTION SITES. ***
 */
define("RECOMPILE_TEMPLATES", TRUE);
/**
 * show ClassLoader info
 * @var unknown_type
 */
define("SHOW_RUNTIME_CLASS_LOOKUP", true);
/**
 * This forces Smarty to (re)compile templates on every invocation.
 * This setting overrides RECOMPILE_TEMPLATES and can be useful in debug/test environments.
 * *** NOTE: TURN OFF FOR PRODUCTION SITES. ***
 */
define("FORCE_COMPILE", TRUE);
/**
 * This tells Smarty whether or not to cache the output of the templates to the SMARTY_CACHE_DIR.
 * Value can be 1 or 2
 * @see http://www.smarty.net/manual/en/variable.caching.php for more details of the integer values
 */
define("USE_CACHE", 0);
define("CACHE_LIFETIME", 3600);
/**
 * Set this to true in order to see a javascript debug console
 * for smarty
 */
define("SMARTY_DEBUG_CONSOLE", false);
/**
 * $security can be TRUE or FALSE, defaults to FALSE.
 * Security is good for situations when you have untrusted parties editing
 * the templates eg via ftp, and you want to reduce the risk of system security
 * compromises through the template language.
 */
define("SECURITY_ENABLED", TRUE);
/**
 * how smarty code is escaped in the templates
 */
define("SMARTY_LEFT_DELIMETER", '{');
define("SMARTY_RIGHT_DELIMETER", '}');
/**
 *This is an array of all local files and directories that are considered secure.
 * {include} and {fetch} use this when $security is enabled.
 */
$secure_dirs[] = SMARTY_TEMPLATE_DIR;
/**
 * Logging - LOG4PHP setup 
 */
