== Changelog ==

= 1.2 May 22 2013 =
* Use a filter to modify the output of wp_title()
* Enqueue scripts and styles via callback
* Use get_posts() in content-gallery.php instead of get_children() to get image attachments
* Add forward compat with 3.6 and new post formats functionality

= 1.1 Nov 5 2012 =
* Add trailing slashes to URLs in comment header
* Move functions for grabbing bits of content into a new file, for separation and organization
* Clean out unused functions
* Escaping fixes; make sure attribute escaping occurs after printing
* Updates for the "audio" post format, remove outdated code from js/audio-player.js, use core version of swfobject and list as a dependency of js/audio-player.js, remove unneeded jQuery dependency
* PNG and JPG image compression
* Add Jetpack compatibility file
* Remove loading of $locale.php
* Add a check is_ssl() to define a protocol for Google fonts in order to ensure it's available for both protocols. 
* New HiDPi-ready screenshot.png file at 600x450