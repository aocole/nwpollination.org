== Changelog ==

= 1.3 - May 17 2013 =
* Minor style tweaks in preparation for 3.6 compatibility.
* Enqueued scripts and styles via callback.
* Uses a filter to modify the output of wp_title().
* Now only set width: auto property for images in IE8 using a conditional tag in header.php.
* Updated comments in Jetpack compat files to point to live documentation on jetpack.me.
* Fixed a bug where post dates were not displayed when there was more than one post per day.

= 1.2 - Nov 5 2012 =
* Fix @package and @subpackage information.
* Remove loading of $locale.php.
* Logical statements should not be passed to gettext functions. Use _n() to handle conditional plurals instead.
* PNG image compression.
* Add Jetpack compatibility file.
* Updated screenshot for HiDPI support.

= 1.1.3 =
* Add Custom Header Image support, including featured header images on posts and pages.
* Remove self-linking titles in single.php.

= 1.1.2 - Oct 4 2011 =
* the_post should always be called in the loop.
* Make sure the current category highlights in the menu.
* Set svn:eol-style on all files.
* Move functions from comments.php to functions.php to avoid redeclaration errors.