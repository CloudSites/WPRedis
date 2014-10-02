=== wp-redis-cache ===
Contributors: krazybean, antpb
Donate link: 
Tags: redis, cache, beta
Requires at least: 3.0.1
Tested up to: 3.4
Stable tag: 0.2
Version: 0.2.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Redis caching on wordpress, the easy way.

== Description ==

Basically this is an attempt to simply existing implementation of wordpress caching.

Unfortunately it's missing a few features that are on their way, as such this plugin is still in **beta.**

Expected features:

*   Image Compression
*   .htaccess rule appending

Requires:

 - Wordpress :)
 - PHP
 - mcrypt
 - Redis server
 - Redis credentials (optional)



== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Download the `plugin.zip` and upload via `plugins > add new` section
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Configure the server information in the `settings` section
1. Enable plugin! :)

== Frequently Asked Questions ==

= Can this plugin be used with another caching plugin? =

I've tested this with SuperCache and it seemed to improve response times.


== Screenshots ==

1. Dashboard Screenshot

== Changelog ==

= 0.1 =
* Full beta, ready for testing and prototype usage
* Use at your own risk

= 0.2 =
* Still beta, please report any bugs
* Added TTL key flushing
* Added Flush DB function
* Added css minification ability

= 0.2.5 =
* Added post event purging

== Upgrade Notice ==

= 0.1 =
Barebones upload
= 0.2 =
Added new features!
= 0.2.5 =
Automatic cache purging on post

== Arbitrary section ==



  [1]: http://profiles.wordpress.org/krazybean
  [2]: /assets/screenshot-1.jpg

