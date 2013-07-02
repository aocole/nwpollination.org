== Changelog ==

= 1.3 May 30 2013 =
* Updated package declaration.
* Made custom header and background pluggable.
* Separated wp.com-related code.
* Made footer text translatable and updated .pot file.
* Removed redundant title tag on post titles.

= 1.2 May 22 2013 =
* Add Video post format support.
* Style updates for all post formats.
* Use a filter to modify the output of wp_title().
* Enqueue scripts and styles via callback.
* Use get_posts() in content-gallery.php instead of get_children() to get image attachments.
* Rework the audio post format for 3.6 compatibility.

= 1.1 Nov 5 2012 =
* Bugfix: filtering attachment link URLs that don't have pretty permalinks will cause a 404 when viewing an unattached attachment.
* Move functions for grabbing bits of content into a new file, for separation and organization.
* Clean out unused functions.
* Escaping fixes; make sure attribute escaping occurs after printing.
* Add styling for HTML5 email inputs.
* Updates for the "audio" post format, remove outdated code from js/audio-player.js, use core version of swfobject and list as a dependency of js/audio-player.js, remove unneeded jQuery dependency.
* Prevent large images in the post_content from vertically distorting in IE8.
* PNG and JPG image compression.
* Add Jetpack compatibility file.
* Remove loading of $locale.php.
* Add a check is_ssl() to define a protocol for Google fonts in order to ensure it's available for both protocols.
* Switch to add_theme_support( 'custom-background' ) from add_custom_background().
