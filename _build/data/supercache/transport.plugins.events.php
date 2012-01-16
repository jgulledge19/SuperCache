<?php
/**
 * @package modmobile
 * @subpackage build
 */
$events = array();
// OnDocFormSave, OnLoadWebDocument, OnWebPagePrerender
$events['OnDocFormSave']= $modx->newObject('modPluginEvent');
$events['OnDocFormSave']->fromArray(array(
    'event' => 'OnDocFormSave',
    'priority' => 0,
    'propertyset' => 0,
),'',true,true);

$events['OnLoadWebDocument']= $modx->newObject('modPluginEvent');
$events['OnLoadWebDocument']->fromArray(array(
    'event' => 'OnLoadWebDocument',
    'priority' => 0,
    'propertyset' => 0,
),'',true,true);

$events['OnWebPagePrerender']= $modx->newObject('modPluginEvent');
$events['OnWebPagePrerender']->fromArray(array(
    'event' => 'OnWebPagePrerender',
    'priority' => 0,
    'propertyset' => 0,
),'',true,true);


return $events;