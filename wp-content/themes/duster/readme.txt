= DUSTER =

* by Automattic, http://automattic.com/

== ABOUT DUSTER ==

Duster is an Automattic-produced theme designed and developed by the Theme Team which, apart from the custom possibilities you’re acquainted with in most of our themes -- features like custom backgrounds, headers, and menus -- is also equipped with a custom Showcase Page Template that can propel your site up to a new level.

With the help of the Showcase Template you can make your front page display an introductory text message, a featured post with an image -- big or small, your call -- at the top, a recent post column showing the full latest post and a list of other recent posts below, and a sidebar with a custom widget that displays your Aside or Link posts.

You can read more about Duster and how to setup the Showcase Template here:

http://theme.wordpress.com/themes/duster/

== Changelog ==

= 1.2 - May 30 2013 =
* Updated package declaration.
* Made custom header and background pluggable.
* Separated wp.com-related code.
* Made footer text translatable and updated .pot file.
* Removed redundant title tag on post titles.
* Making adjustments to post format media sizing and minor style tweaks for 3.6 compatibility.
* Update license.
* Enqueues scripts and styles via callback.
* Make theme update notice dismissable. See #1097.
* Uses a filter to modify the output of wp_title().
* Updated comments in Jetpack compat files to point to live documentation on jetpack.me.

= 1.1 - Nov 05 2012 =
* Replace esc_attr( printf() ) with sprintf to prevent potential XSS and potential broken code.
* Add styling for HTML5 email inputs.
* Make sure attribute escaping occurs after printing.
* PNG and JPG image compression.
* Remove loading of $locale.php.
* Remove esc_html() from get_the_author() since it's not being used in an attribute.
* Updated screenshot for HiDPI support.
* Add Jetpack compatibility file.

= 1.0.7 - Oct 05 2011 =
* Add support for status and quote post formats.
* Layout fixes.
* Fix get_the_author() escaping.
* Set svn:eol-style on JS and TXT files.
* the_post should always be called in the loop.
* Trim extra whitespace.
* Change TEMPLATEPATH to get_template_directory().
* Add POT file.

= 1.0.6 - Apr 18 2011=
* Move functions out of comments.php.
* Move HTML out of gettext strings.
* Clean up double spaces, 8-bit chars in plain text, and indentation.
* Update to latest html5shiv.
* Move JS files into js dir.
* Move widgets into inc dir.