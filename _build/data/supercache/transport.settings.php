<?php
/** Array of system settings for Mycomponent package
 * @package mycomponent
 * @subpackage build
 */


/* This section is ONLY for new System Settings to be added to
 * The System Settings grid. If you include existing settings,
 * they will be removed on uninstall. Existing setting can be
 * set in a script resolver (see install.script.php).
 */
$settings = array();

/* The first three are new settings */
$settings['supercache.excludeResources']= $modx->newObject('modSystemSetting');
$settings['supercache.excludeResources']->fromArray(array (
    'key' => 'supercache.excludeResources',
    'value' => '0',
    'xtype' => 'textfield',
    'namespace' => 'SuperCache',
    'area' => 'SuperCache',
), '', true, true);


$settings['supercache.includeResources']= $modx->newObject('modSystemSetting');
$settings['supercache.includeResources']->fromArray(array (
    'key' => 'supercache.includeResources',
    'value' => '0',
    'xtype' => 'textfield',
    'namespace' => 'SuperCache',
    'area' => 'SuperCache',
), '', true, true);


$settings['supercache.timeLimit']= $modx->newObject('modSystemSetting');
$settings['supercache.timeLimit']->fromArray(array (
    'key' => 'supercache.timeLimit',
    'value' => '900',
    'xtype' => 'textfield',
    'namespace' => 'SuperCache',
    'area' => 'SuperCache',
), '', true, true);

return $settings;