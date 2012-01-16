--------------------
SuperCache
--------------------
Version: 1.0 rc
Date: January 16, 2011
Author: Joshua Gulledge <jgulledge19@hotmail.com>
License: GNU GPLv2 (or later at your option)

SuperCache is a plugin for MODX Revolution that will allow you to eliminate text processing of pages
therefore possibly speeding them up significantly.  Note MODX Revolution already uses a cache
system to speed up page load times, this plugin uses the same cache system but in a different way
to deliver even faster page loads if you have moderate to complex templates.

Install:
- Install via the MODX Revolution package management
    verify that OnDocFormSave, OnLoadWebDocument, OnWebPagePrerender are selected.
- Optionally for even more configuration settings create the following TV to use:
    a. Create a TV with the following values:
        General Info Tab:
            Variable Name: supercache_timeLimit
            Caption: SuperCache time limit
            Description: Set to 0 to use the System Config value otherwise, put time in seconds that you wish to have this page cached.
        Input Options Tab:
            Input Type: Number
            Default Value: 0
            Allow Decimals: No


================================================================

Thanks for using SuperCache and hopefully you will find this useful!
Josh Gulledge