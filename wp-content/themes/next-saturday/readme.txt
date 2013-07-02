== Changelog ==

= 1.2 May 22 2013 =
* Use a filter to modify the output of wp_title()
* Enqueue scripts and styles via callback
* Use get_posts() in content-gallery.php instead of get_children() to get image attachments
* Simplify image post format callback
* Add forward compat for custom header and custom background
* Remove redundant permalink titles
* Fix a bug where the entry header was not displayed in link posts
* Forward compatibility with 3.6 content grabber functions
* Remove SWF file and update with 3.6 functionality (with fallbacks) for audio post format support

= 1.1 Nov 5 2012 =
* Move functions for grabbing bits of content directly into the theme includes.
* Clean up unused functions.
* Replace esc_attr( printf() ) with sprintf to prevent potential XSS and potential broken code.
* Updates to audio player JS and jQuery dependencies.
* Make sure attribute escaping occurs after printing.
* PNG image compression.
* Remove esc_html() from get_the_author() since it's not being used in an attribute.
* Updated screenshot for HiDPI support.
* Add Jetpack compatibility file.