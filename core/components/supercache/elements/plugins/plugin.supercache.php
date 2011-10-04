<?php
$super_options = array('full', 'mobile');

$eventName = $modx->event->name;
$page_type = 'full';
switch($eventName) {
  //  case 'OnWebPageInit':
  case 'OnLoadWebDocument': // http://rtfm.modx.com/display/revolution20/OnLoadWebDocument
        /* do something */
        // OnLoadWebDocument (OnWebPageInit) - get the data from cache
        // get( string $key, array $options = array ) : mixed
    if (is_object($modx->resource)) {
        if ( !$modx->user->isAuthenticated('mgr') && count($_POST) == 0 && count($_GET) <= 1 ) {
            if ( isset($_SESSION[$modx->getOption('modmobile.get_var')]) ) {
                $page_type = $_SESSION[$modx->getOption('modmobile.get_var')];
            }
            // error_log('Page type Before: '. $page_type);
            if ( !in_array($page_type,$super_options) ){ 
                $page_type = 'full';
            }
            
            $cached_data = $modx->cacheManager->get('supercache_'.$modx->resource->get('id'));//, array('page_type' => $page_type));
            // error_log('Page type: '. $page_type.' post: '. http_build_query($_POST) );
            //echo 'POST: '.print_r($_POST); array_to_string();
            if ( isset($cached_data[$page_type]) && !empty($cached_data[$page_type]) ) {
                //echo '<br>-----Cache?';
                // error_log('Load Page from cache: supercache_'.$modx->resource->get('id'));
                // It would be much more ideal to set the content output to the last output, but this did not seem to cut out the processing script.
                $modx->resource->_output = $cached_data[$page_type];
                $modx->resource->set('content', $cached_data[$page_type]);
                $modx->resource->set('Template', 0);
                //
                @session_write_close();
                echo $cached_data[$page_type]; 
                //exit();
                //echo $modx->resource->_output;
                while (@ ob_end_flush()) {}
                exit();
            }
        }
    }
        break;
    case 'OnWebPagePrerender': // Not in the docs
        /* write output to file */
        if ( !$modx->user->isAuthenticated('mgr') && count($_POST) == 0 && count($_GET) <= 1) {
            // set( string $key, mixed $var, integer $lifetime = 0, array $options = array ) : boolean
            if ( isset($_SESSION[$modx->getOption('modmobile.get_var')]) ) {
                $page_type = $_SESSION[$modx->getOption('modmobile.get_var')];
            }
            $data = array();
            // does the cache file already exist with other page data?
            $cached_data = $modx->cacheManager->get('supercache_'.$modx->resource->get('id'));//, array('page_type' => $page_type));
            if ( is_array($cached_data) ) {
                $data = $cached_data;
            }
            $data[$page_type] = $modx->resource->_output;
            $modx->cacheManager->set('supercache_'.$modx->resource->get('id'), $data, 300, array('page_type' => $page_type) );
        }
        break;
        
}