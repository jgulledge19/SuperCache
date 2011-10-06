--------------------
SuperCache
--------------------
Version: 1.0 beta
Since: October 5th, 2011
Author: Joshua Gulledge <jgulledge19@hotmail.com>
License: GNU GPLv2 (or later at your option)

SuperCashe is a plugin that will allow you to eliminate text processing of pages
therefor possibly speeding them up signifigantly.  Note MODX Revolution already uses a cache
system to speed up pageload times, this plugin uses the same cache system but in a different way
to deleiver even faster page loads if you have moderate to complex templates.  On my test box 
response was 450 to 600 milliseconds and now with supercache it is 60 to 100 milliseconds.  Note 1000 
milliseconds is 1 second.

Install:
 - Future: Install via the MODX Revolution packagemanagment
1. Create a plugin: 
    - Name it supercache
    - Copy and paste the code from core/components/supercache/elements/plugins/plugin.supercache.php
    - Save it
2. Add the following setting to your context(s) under Area Lexicon of SuperCache:
    See System Settings for more info: http://rtfm.modx.com/display/revolution20/System+Settings
      A. Key: supercache.excludeResources 
         Name: Excluded Resources
         Field Type: Textfield
         Value: 0 (or example: 5,10)
         Description: Comma separated list of resource ids that you do not want to use supercache on
      B. Key: supercache.includeResources 
         Name: Included Resources
         Field Type: Textfield
         Value: 0 (or example: 5,10)
         Description: Comma separated list of resource ids that you want to use supercache on.  Note if you 
                use this you will automatically exclude all other pages.
      C. Key: supercache.timeLimit 
         Name: Cache time limit
         Field Type: Textfield
         Value: 900 
         Description: Time in seconds that you wish to have pages cached is seconds.  Default is 900 seconds (15 minutes) 
    Note that SuperCache does respect the Cacheable option under Page Settings
       
3.  Optionally for even more configuration settings create the following TVs to use:
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