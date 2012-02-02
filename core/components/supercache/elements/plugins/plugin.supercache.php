<?php
/**
 * Author: Josh Gulledge
 * Date: 10/4/2011
 * 
 * system setting options: supercache.excludeResources, supercache.includeResources, supercache.timeLimit, 
 *          supercache.
 * 
 * Optionally set up TVs: supercache_use -Y/N, supercache_timeLimit(number in seconds), 
 */
$super_options = array('full', 'mobile');

$exclude_resources = array();
$tmp = $modx->getOption('supercache.excludeResources', $scriptProperties, '');
if ( !empty($tmp) ) {
    $exclude_resources = explode(',', $tmp);
}
$include_resources = array();
$tmp = $modx->getOption('supercache.includeResources', $scriptProperties, '');
if ( !empty($tmp) ) {
    $include_resources = explode(',', $tmp);
}
$time_limit = $modx->getOption('supercache.timeLimit', $scriptProperties, 900);
$ctime_limit = $modx->getOption('supercache_timeLimit', $scriptProperties, 0);

if ( $ctime_limit > 0 ) {
    $time_limit = $ctime_limit;
}
        
$eventName = $modx->event->name;
$page_type = 'full';

if ( !function_exists('allow_supercache') ) {
    function allow_supercache($id, $excludes, $includes ){
        if ( is_array($includes) && count($includes) > 0 ) {
            if ( !in_array($id, $includes) ) {
                return false;
            }
        } elseif ( is_array($excludes) && count($excludes) > 0 ) {
            if ( in_array($id, $excludes) ) {
                return false;
            }
        }
        return true;
    }
}

$userIP = $_SERVER['REMOTE_ADDR'];
$external = false;
/* Compare for 192.168 range INTERNAL 
    substr get the first 0 to 7 characters of the $userIP */
if( substr($userIP, 0, 7) != "192.168" && substr($userIP, 0, 3) != "10." ) {
    $external = true;
}

switch($eventName) {
  //  case 'OnWebPageInit':
    case 'OnLoadWebDocument': // http://rtfm.modx.com/display/revolution20/OnLoadWebDocument
        // get( string $key, array $options = array ) : mixed
        if (is_object($modx->resource) && $modx->resource->get('cacheable') && allow_supercache($modx->resource->get('id'), $exclude_resources, $include_resources) && !$modx->user->isAuthenticated('mgr') && count($_POST) == 0 && count($_GET) <= 1 ) {
            if ( isset($_SESSION[$modx->getOption('modmobile.get_var')]) ) {
                $page_type = $_SESSION[$modx->getOption('modmobile.get_var')];
            }
            // error_log('Page type Before: '. $page_type);
            if ( !in_array($page_type,$super_options) ){ 
                $page_type = 'full';
            }
            if ( !$external ) {
                $page_type = 'internal_'.$page_type;
            }
            
            $cached_data = $modx->cacheManager->get('supercache_'.$modx->resource->get('id'));//, array('page_type' => $page_type));
            if ( isset($cached_data[$page_type]) && !empty($cached_data[$page_type]) ) {
                // this is setting the content/output to the cached file - the saved processed output
                $modx->resource->_content = $modx->resource->_output = $cached_data[$page_type];
                $modx->resource->set('content', $cached_data[$page_type]);
                $modx->resource->setProcessed(true);
            }
        }
        break;
    case 'OnWebPagePrerender': // Not in the docs
        /* write output to file */
        if ( !$modx->user->isAuthenticated('mgr') && $modx->resource->get('cacheable') && allow_supercache($modx->resource->get('id'), $exclude_resources, $include_resources) && count($_POST) == 0 && count($_GET) <= 1) {
            // set( string $key, mixed $var, integer $lifetime = 0, array $options = array ) : boolean
            if ( isset($_SESSION[$modx->getOption('modmobile.get_var')]) ) {
                $page_type = $_SESSION[$modx->getOption('modmobile.get_var')];
            }
            if ( !$external ) {
                $page_type = 'internal_'.$page_type;
            }
            $data = array();
            // does the cache file already exist with other page data?
            $cached_data = $modx->cacheManager->get('supercache_'.$modx->resource->get('id'));//, array('page_type' => $page_type));
            if ( is_array($cached_data) ) {
                $data = $cached_data;
            }
            if ( !isset($data[$page_type]) ) {
                // only set if the data is
                $data[$page_type] = $modx->resource->_output;
                $modx->cacheManager->set('supercache_'.$modx->resource->get('id'), $data, $time_limit, array('page_type' => $page_type) );
            }
        }
        break;
    case 'OnDocFormSave': // Clear cache on Save
        if ( $resource ) {
            $modx->cacheManager->delete('supercache_'.$resource->get('id'));
            // need an option to clear cache of parents & siblings
        }
        break;
        
}