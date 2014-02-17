=== Better Datelines ===
Contributors: doejo, rinatkhaziev
Requires at least: 3.6
Tested up to: 3.8
Stable tag: 0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Dateline plugin for news publications

== Description ==

Store dateline as meta field and prepend it to content automatically.

If you'd like to check out the code and contribute, [join us on GitHub](https://github.com/rinatkhaziev/better-datelines/). Pull requests, issues, and plugin recommendations are more than welcome!

== Installation ==

1. Upload the `better-datelines` folder to your plugins directory (e.g. `/wp-content/plugins/`)
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Hide posts from the post edit screen

== Frequently Asked Questions ==

= How do I enable automatic prepending of dateline to the post content? =

Put
`add_filter( 'better_datelines_prepend_the_content', '__return_true' );`
to your theme's functions.php

= How do I change the format of automatically prepended dateline? =

There's another filter for that: 'better_datelines_formatted_content', filter accepts 3 arguments, so to add a filter
`add_filter( 'better_datelines_formatted_content', 'my_better_datelines_formatted_content', 10, 3);
function my_better_datelines_formatted_content( $formatted_content, $dateline, $original_content ) {
	// Do something

	return $formatted_content;
}`


== Changelog ==

= 0.1 =
* Initial Release