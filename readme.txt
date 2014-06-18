=== Adobe Analytics for WordPress by RepEquity ===
Contributors: smiro2000
Donate link: htpp://repequity.com
License: GPLv3 or later
License URI: http://opensource.org/licenses/GPL-3.0
Tags: analytics, adobe, custom metrics, catalyst, omniture
Requires at least:
Tested up to: 3.8

== Description ==

The Adobe Analytics for WordPress plugin by RepEquity allows users to easily configure custom analytics metrics. It reveals a settings form in the Wordpress dashboard that allows users to set site-wide analytics and a per-post settings form for more granular customization.


== Changelog ==
= 0.6.8 =
* Handles error when global custom variables are not set.

= 0.6.7 =
* The 'type' replacement token now supports error pages and returns 'errorPage'.

= 0.6.6 =
* Added support for 'breadcrumbs' replacement token. The 'breadcrumbs' token uses simple page ancestry lookup.
* Added support for 'wpseo_breadcrumbs' replacement token. The 'wpseo_breadcrumbs' token uses the wordpress_seo module advanced breadcrumbs module. Patch to wordpress_seo module is required for now and can be found here => https://gist.github.com/smiro2000/8240767 (git diff patch) or replace the file frontend/class-breadcrumbs.php with the one found here => https://github.com/smiro2000/wordpress-seo/blob/142853d528f99b0aa8b42b802a10c59dc8c14512/frontend/class-breadcrumbs.php

= 0.6.5 =
* Added support for replacement tokens on the post/page level variables
* Bugfixes and other small enhancements

= 0.6.4 =
* Bugfix when page/post variables aren't defined

= 0.6.4 =
* Now only correctly looks for page and post specific variables on posts and page types

= 0.6.3 =
* Fixed exception when no post specific values are set

= 0.6.2 =
* Added wpml_lang token to return the current page language from wpml

= 0.6.1 =
* Updates to Settings interface
  * Added "Instructions tab"
  * Filled Info and Credits tab with appropriate content

= 0.6 =
* Enhancements
  * On-page and post custom variables now work correctly

= 0.5 =
* Enhancements
  * Improved settings page with new tabbed navigation
  * Settings page form is now in divs and not a table

* TODO
  * Finish integration of per-post and per-page custom variables
  * Make the custom variables form on the post/page form and the plugin settings form match
  * Strip out parts of the metaboxes library that we don't need (i.e.. all of it except for the repeating field part)
  * Add more tokens
  * Clean up code that generates the analytics script into it's own class with separate methods for each part of the script
  * Add script preview to settings page
  * Allow to reorder the script?
  * Make translatable
  * Make multisite compatible
