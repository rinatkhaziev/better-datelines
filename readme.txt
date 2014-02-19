=== Better Datelines ===
Contributors: doejo, rinatkhaziev
Requires at least: 3.6
Tested up to: 3.8
Tags: editorial, dateline, news, excerpt, content
Stable tag: 0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Lightweight plugin for better dateline management for news sites. Store dateline as a custom meta field instead of putting it in the post content.

== Description ==

A dateline is a brief piece of text included in news articles that describes where and when the story occurred, or was written or filed, though the date is often omitted. This plugin gives you ability to store datelines as a meta field so you don't have to include them in your post body.

You can use either [better-dateline] shortcode to insert dateline manually or automatically prepend post content with a dateline. (See Frequently Asked Questions)

If you'd like to check out the code and contribute, [join us on GitHub](https://github.com/rinatkhaziev/better-datelines/). Pull requests, issues, and plugin recommendations are more than welcome!

== Installation ==

1. Upload the `better-datelines` folder to your plugins directory (e.g. `/wp-content/plugins/`).
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. You'll see a dateline textarea on post edit screen.

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

== Screenshots ==

1. Screenshot of edit post screen with a dateline
1. Screenshot of a post with a dateline

== Changelog ==

= 0.1 =
* Initial Release