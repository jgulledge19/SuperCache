<?php
/**
 * MyComponent transport plugins
 * Copyright 2011 Your Name <you@yourdomain.com>
 * @author Your Name <you@yourdomain.com>
 * 1/1/11
 *
 * MyComponent is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option) any
 * later version.
 *
 * MyComponent is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * MyComponent; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package mycomponent
 */
/**
 * Description:  Array of plugin objects for MyComponent package
 * @package mycomponent
 * @subpackage build
 */

if (! function_exists('getPluginContent')) {
    function getpluginContent($filename) {
        $o = file_get_contents($filename);
        $o = str_replace('<?php','',$o);
        $o = str_replace('?>','',$o);
        $o = trim($o);
        return $o;
    }
}
$plugins = array();

$plugins[1]= $modx->newObject('modplugin');
$plugins[1]->fromArray(array(
    'id' => 1,
    'name' => 'SuperCache',
    'description' => 'SuperCache is a plugin for MODX Revolution that will allow you to eliminate text processing of pages therefore possibly speeding them up significantly.',
    'plugincode' => getPluginContent($sources['source_core'].'/elements/plugins/plugin.supercache.php'),
),'',true,true);
/*
$properties = include $sources['data'].'properties/properties.myplugin1.php';
$plugins[1]->setProperties($properties);
unset($properties);
*/
/* add plugin events */
$events = include $sources['data'].'transport.plugins.events.php';
if (is_array($events) && !empty($events)) {
    $plugins[1]->addMany($events);
    $modx->log(xPDO::LOG_LEVEL_INFO,'Packaged in '.count($events).' Plugin Events.'); flush();
} else {
    $modx->log(xPDO::LOG_LEVEL_ERROR,'Could not find plugin events!');
}
return $plugins;